<?php

namespace App\Http\Controllers;

use App\Jobs\JobNotificationJob;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\JobAlert;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\JobNotification;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class EmployerController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if (Auth::check() && $this->user->role === User::ROLE_EMPLOYER) {
                return $next($request);
            }

            return redirect()->back();
        });
    }

    public function index(Request $request) {
        $jobsPostedId = $request->user()->jobListings()->get(['id']);
        $jobsPostedApplications = JobApplication::whereIn(JobApplication::JOB_LISTING_ID, $jobsPostedId);
        $jobApplicationsReview = JobApplication::whereIn(JobApplication::JOB_LISTING_ID, $jobsPostedId)->where(JobApplication::STATUS, 'under-review')->count();
        // $jobApplicationsAccepted = JobApplication::whereIn(JobApplication::JOB_LISTING_ID, $jobsPostedId)->where(JobApplication::STATUS, 'accepted')->count();
        $jobRecentApplications = JobApplication::whereIn(JobApplication::JOB_LISTING_ID, $jobsPostedId)->orderBy(JobApplication::CREATED_AT, 'DESC')->take(3)->get();
        $jobNotificationsCount = $request->user()->candidateJobNotifications->where(JobNotification::STATUS, 'unread')->count();
        $jobNotifications = $request->user()->candidateJobNotifications()->orderBy('created_at', 'DESC')->take(5)->get();
        return view('pages.dashboard.employer.index', [
            'jobsPosted' => $jobsPostedId->count(),
            'jobsApplications' => $jobsPostedApplications->count(),
            'jobApplicationsReview' => $jobApplicationsReview,
            // 'jobApplicationsAccepted' => $jobApplicationsAccepted,
            'jobRecentApplications' => $jobRecentApplications,
            'jobNotificationsCount' => $jobNotificationsCount,
            'jobNotifications' => $jobNotifications,
        ]);
    }

    public function profileIndex(Request $request) {
        $employer = Auth::user();
        return view('pages.dashboard.employer.profile.index', [
            'countries' => self::COUNTRIES,
            'industries' => self::INDUSTRY,
            'employer' => $employer,
        ]);
    }

    public function profileIndexUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'website' => 'required',
            'founded' => 'required',
            'company_size' => 'required',
            'industry' => 'required|array',
            'description' => 'required',
            'country' => 'required',
            'city' => 'required',
            'image' => 'nullable',
            'address' => 'required',
            'fb_link' => 'nullable|url:http,https',
            'tw_link' => 'nullable|url:http,https',
            'linkedin_link' => 'nullable|url:http,https',
            'in_link' => 'nullable|url:http,https',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $request->user();

        $user->update([
            'name' => $request->name,
            User::IS_COMPLETE => $user->isComplete < 100 ? 100 : $user->isComplete
        ]);

        $dataToStore = $request->except(['name', '_token', '_method', 'option', 'image']);

        if (!empty($request->image)) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time().'.' . $extension;
            $file->move(public_path('uploads/employers'), $filename);
            $dataToStore['image']= 'uploads/employers/' . $filename;
            if ($user->employerInfo->image) {
                File::delete(public_path($user->employerInfo->image));
            }
        }

        $user->employerInfo()->update($dataToStore);

        return back()->with('message', 'Information updated successfully!');
    }

    public function jobCreateIndex(Request $request) {
        $employer = Auth::user();
        $editModeJobReference = $request->query('edit');
        $categories = Category::orderBy('title', 'ASC')->get(['id', 'title']);
        if ($editModeJobReference) {
            $employerJobListing = $employer->jobListings->where(JobListing::JOB_REFERENCE, $editModeJobReference)->first();

            if (!$employerJobListing) {
                abort(404);
            }
        }
        return view('pages.dashboard.employer.jobs.create', [
            'skills' => self::SKILLS,
            'countries' => self::COUNTRIES,
            'categories' => $categories,
            'editModeJobReference' => $editModeJobReference,
            'employerJobListing' => $employerJobListing ?? NULL
        ]);
    }

    public function jobCreate(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'contract_type' => 'required',
            'priority' => 'required|in:low,medium,urgent',
            'experience' => 'required|array',
            'city' => 'required',
            'country' => 'required',
            'salary' => 'nullable',
            'expiry_date' => 'nullable',
            'hours' => 'nullable',
            'skills' => 'required|array',
            'submit' => 'required',
            'status' => 'required_if:submit,edit',
            'id' => 'required_if:submit,edit'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employer = $request->user();

        if ($employer->isComplete != 100) {
            return redirect()->back()->withErrors('You must complete your profile before posting a job')->withInput();
        }

        $dataToStore = $request->except(['name', '_token', '_method', 'submit', 'user_id', 'id']);
        
        $dataToStore[JobListing::USER_ID] = $employer->id;

        if ($request->submit === 'edit') {
            $employerJobListing = $employer->jobListings->where(JobListing::JOB_REFERENCE, $request->id)->first();

            $employerJobListing->update($dataToStore);

            return redirect()->route('dashboard.employer.job.manage')->with('message', 'Job updated successfully!');
        } else {
            $dataToStore[JobListing::JOB_REFERENCE] = $this->generateUniqueId("joblisting");
            $dataToStore[JobListing::TITLE_SLUG] = Str::slug($dataToStore['title'], '-') . '-' . rand(10000000, 99999999);
            $dataToStore[JobListing::STATUS] = $request->submit;
    
            $newJobListing = $employer->jobListings()->create($dataToStore);
            JobAlert::create([
                JobAlert::JOB_LISTING_ID => $newJobListing->id
            ]);
            return redirect()->route('dashboard.employer.job.manage')->with('message', 'Job created successfully!');
        }

    }

    public function jobsManage(Request $request) {
        $status = Str::lower($request->query('status'));
        if ($status && $status === "expired") {
            $jobListings = $request->user()->jobListings()->where('expiry_date', '<', now())->orderBy('created_at', 'DESC')->paginate(15);
        } elseif ($status && $status !== "all") {
            $jobListings = $request->user()->jobListings()->where('status', $status)->orderBy('created_at', 'DESC')->paginate(15);
        } else {
            $jobListings = $request->user()->jobListings()->orderBy('created_at', 'DESC')->paginate(15);
        }
        $jobListings->each(function ($listing) {
            if ($listing->expiry_date < now()) {
                $listing->update([
                    JobListing::STATUS => 'expired'
                ]);
            }
        });
        return view('pages.dashboard.employer.jobs.manage', [
            'jobListings' => $jobListings,
            'status' => $status
        ]);
    }

    public function jobsPostedManage(Request $request) {
        $jobListings = $request->user()->jobListings()->orderBy('created_at', 'DESC')->paginate(15);
        $jobListings->each(function ($listing) {
            if ($listing->expiry_date < now()) {
                $listing->update([
                    JobListing::STATUS => 'expired'
                ]);
            }
        });
        return view('pages.dashboard.employer.jobs.posted', [
            'jobListings' => $jobListings
        ]);
    }

    public function jobsApplicationManage(Request $request) {
        $jobsPostedId = $request->user()->jobListings()->get(['id']);
        $jobsPostedApplications = JobApplication::whereIn(JobApplication::JOB_LISTING_ID, $jobsPostedId);
        $status = Str::lower($request->query('status'));
        if ($status && $status !== "all") {
            $jobsPostedApplications = $jobsPostedApplications->where('status', $status)->orderBy('created_at', 'DESC')->paginate(15);
        } else {
            $jobsPostedApplications = $jobsPostedApplications->orderBy('created_at', 'DESC')->paginate(15);
        }

        return view('pages.dashboard.employer.jobs.applications', [
            'jobsPostedApplications' => $jobsPostedApplications,
            'status' => $status
        ]);
    }

    public function jobsApplicantManage(Request $request, $jobReference) {
        $jobListing = JobListing::where(JobListing::JOB_REFERENCE, $jobReference)->first();

        if (!$jobListing) {
            abort(404, __('The requested resource was not found!'));
        }

        $jobListingApplicationsCount = $jobListing->jobApplications()->with(['user', 'candidateInfo'])->count();
        $jobListingApplications = $jobListing->jobApplications()->with(['user', 'candidateInfo'])->orderBy('created_at', 'DESC')->get();

        $stats = [
            'under-review' => $jobListingApplications->where('status', 'under-review')->count(),
            'approved' => $jobListingApplications->where('status', 'accepted')->count(),
            'rejected' => $jobListingApplications->where('status', 'rejected')->count(),
            'withdrawn' => $jobListingApplications->where('status', 'withdrawn')->count()
        ];
        
        // Check the status query
        $status = Str::lower($request->query('status'));
        if ($status && $status !== "all") {
            $jobListingApplications = $jobListing->jobApplications()->with(['user', 'candidateInfo'])->where('status', $status)->orderBy('created_at', 'DESC')->get();
        }

        $starApplicants = $this->getStarApplicants($jobListingApplications, $jobListing);

        return view('pages.dashboard.employer.jobs.applicants', [
            'jobListing' => $jobListing,
            'jobListingApplicationsCount' => $jobListingApplicationsCount,
            'jobListingApplications' => $jobListingApplications,
            'status' => $status,
            'stats' => $stats,
            'starApplicants' => $starApplicants
        ]);
    }

    public function jobListingDelete(Request $request) {
        $validator = Validator::make($request->all(), [
            'listingId' => 'required'
        ]);

        if ($validator->fails()) {
            abort(500);
        }
        
        $jobListing = JobListing::find(openssl_decrypt($request->listingId, "AES-128-ECB", "FP25Hg9KKNJx"));

        if (!$jobListing) {
            abort(404);
        }
        JobApplication::where(JobApplication::JOB_LISTING_ID, $jobListing->id)->delete();
        Feedback::where(Feedback::JOB_LISTING_ID, $jobListing->id)->delete();
        SavedJob::where(SavedJob::FK_JOB_LISTING_ID, $jobListing->id)->delete();
        JobNotification::where(JobNotification::JOB_LISTING_ID, $jobListing->id)->delete();

        $jobListing->delete();

        return redirect()->back();
    }

    public function jobsApplicantManageDecision(Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:accepted,under-review,rejected',
            'applicationId' => 'required'
        ]);

        if ($validator->fails()) {
            abort(500);
        }
        
        $jobApplication = JobApplication::find(openssl_decrypt($request->applicationId, "AES-128-ECB", "FP25Hg9KKNJx"));

        if (!$jobApplication) {
            abort(404);
        }
        
        $employer = $request->user();

        if ($employer->isEmployer() && $jobApplication->jobListing->employer->id === $employer->id ) {
            $jobApplication->update([
                JobApplication::STATUS => $request->status
            ]);
            JobNotification::create([
                JobNotification::USER_ID => $jobApplication->user_id,
                JobNotification::JOB_LISTING_ID => $jobApplication->job_listing_id,
                JobNotification::MESSAGE => $jobApplication->jobListing->title . " application has been moved to " . $request->status
            ]);
            dispatch(new JobNotificationJob($jobApplication->user, $jobApplication));
            return redirect()->back();
        }
        
        return back()->withErrors('You don\'t have permission for this action');
    }
}
