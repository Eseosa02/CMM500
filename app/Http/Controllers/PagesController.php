<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\EmployerProfile;
use App\Models\Feedback;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\SavedJob;
use App\Models\UserCv;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function homepage(Request $request) {
        $jobPostCounts = JobListing::where(JobListing::STATUS, '<>', "draft")->count();
        $categories = Category::with(['jobCategoryListing'])->orderBy(Category::TITLE, 'ASC')->take(9)->get();
        $featuredJobs = JobListing::whereNotIn(JobListing::STATUS, ['draft', 'discarded', 'closed'])->inRandomOrder()->limit(6)->get();
        return view('pages.homepage', [
            'featuredJobs' => $featuredJobs,
            'jobsCount' => $jobPostCounts,
            'categories' => $categories
        ]);
    }

    public function about(Request $request) {
        return view('pages.about');
    }
    
    public function contact(Request $request) {
        return view('pages.contact');
    }

    public function privacyPolicy(Request $request) {
        return view('pages.privacy-policy');
    }

    public function employerDetails(Request $request, $unique_id, $name) {
        $employerDetails = EmployerProfile::where(EmployerProfile::UNIQUE_ID, $unique_id)->first();
        $employer = $employerDetails->employer;

        if ($employerDetails && $employer->name === $name) {
            $openJobsCount = $employer->jobListings->where(JobListing::STATUS, 'open')->count();
            $recentJobs = $employer->jobListings()->whereNotIn(JobListing::STATUS, ['draft', 'discarded'])->orderBy(JobListing::CREATED_AT, 'desc')->take(2)->get();
            return view('pages.employer.details', [
                'recentJobs' => $recentJobs,
                'openJobsCount' => $openJobsCount,
                'employerDetails' => $employerDetails,
            ]);
        }

        return abort(404);
    }

    public function candidateDetails(Request $request, $unique_id) {
        $candidateInfo = UserProfile::where(UserProfile::UNIQUE_ID, $unique_id)->first();

        if ($candidateInfo) {
            $candidate = $candidateInfo->candidate;
            $candidateCV = $candidate->candidateCVs->where(UserCv::IS_DEFAULT, 1)->first();
            $candidateExperiences = $candidate->candidateExperiences()->orderBy(UserProfile::CREATED_AT, 'DESC')->get();
            $candidateEducations = $candidate->candidateEducations()->orderBy(UserProfile::CREATED_AT, 'DESC')->get();
            $jobApplication = NULL;
            $jobListing = NULL;
            
            // attach the right applicant CV and also the employer message
            $applicationId = $request->query('applicationId');
            if ($applicationId) {
                $applicationId = openssl_decrypt($applicationId, "AES-128-ECB", "FP25Hg9KKNJx");
                $jobApplication = JobApplication::find($applicationId);

                if ($jobApplication && $jobApplication->cv_id) {
                    $candidateCV = UserCv::find($jobApplication->cv_id);
                }
            }

            // match the number of skills
            $joblistingId = $request->query('joblistingId');
            if ($joblistingId) {
                $joblistingId = openssl_decrypt($joblistingId, "AES-128-ECB", "FP25Hg9KKNJx");
                $jobListing = JobListing::find($joblistingId);
            }
            
            return view('pages.candidate.details', [
                'candidateInfo' => $candidateInfo,
                'candidate' => $candidate,
                'candidateExperiences' => $candidateExperiences,
                'candidateEducations' => $candidateEducations,
                'jobApplication' => $jobApplication,
                'jobListing' => $jobListing,
                'candidateCV' => $candidateCV,
            ]);
        }

        return abort(404);
    }

    public function jobSearch(Request $request) {
        $limit = $request->query('limit') ?? 10;
        $categories = Category::orderBy(Category::TITLE, 'ASC')->get();
        $whereClause = [
            [JobListing::STATUS, 'open']
        ];

        if (count($request->query) > 0) {
            if ($request->query('category')) {
                $whereClause = array_merge($whereClause, [[JobListing::CATEGORY_ID, openssl_decrypt($request->query('category'), "AES-128-ECB", "FP25Hg9KKNJx")]]);
            }
            
            if ($request->query('filter') && $request->query('filter') !== 'all') {
                $whereClause = array_merge($whereClause, [[JobListing::CONTRACT_TYPE, $request->query('filter')]]);
            }

            $jobListings = JobListing::where('title', 'LIKE', "%{$request->query('title')}%")
                ->where($whereClause)
                ->where(function (Builder $query) use ($request) {
                    if ($request->query('location')) {
                        return $query->where(JobListing::CITY, 'LIKE', "%{$request->query('location')}%")
                            ->orWhere(JobListing::COUNTRY, 'LIKE', "%{$request->query('location')}%");
                    }
                    return $query;
                });
        } else {
            $jobListings = JobListing::inRandomOrder()->latest();
        }

        if ($request->query('filter') === 'all') {
            $jobListings = $jobListings->latest();
        }

        $jobListings = $jobListings->paginate($limit);

        return view('pages.search', [
            'categories' => $categories,
            'jobListings' => $jobListings
        ]);
    }

    public function jobDetails(Request $request, $uniqueId, $titleSlug) {
        $jobDetail = JobListing::where(JobListing::TITLE_SLUG, $titleSlug)
                                ->where(JobListing::JOB_REFERENCE, $uniqueId)
                                ->first();

        if ($jobDetail) {
            $employer = $jobDetail->employer;
            $categoryId = $jobDetail->category_id;
            $employerInfo = $employer->employerInfo;
            $relatedJobs = JobListing::where([
                [JobListing::CATEGORY_ID, '=', $categoryId],
                [JobListing::ID, '<>', $jobDetail->id]
            ])->whereIn(JobListing::STATUS, ['open'])->inRandomOrder()->take(3)->get();
            
            $jobDetail->update([
                JobListing::VIEWS => $jobDetail->views + 1
            ]);

            if (Auth::check() && $request->user()->isCandidate()) {
                $jobApplications = JobApplication::where(
                    [
                        JobApplication::JOB_LISTING_ID => $jobDetail->id,
                        JobApplication::USER_ID => Auth::id()
                    ]
                )->get();
                if ($jobApplications->count() > 0) {
                    $jobApplication = $jobApplications->first();
                    $jobApplicationId = $jobApplications->first()->id;
                    $isApplied = $jobApplications;
                }
                $isBookmarked = SavedJob::where(
                    [
                        SavedJob::FK_JOB_LISTING_ID => $jobDetail->id,
                        SavedJob::FK_USER_ID => Auth::id()
                    ]
                )->count();
            }

            $isExpired = $jobDetail->expiry_date && $jobDetail->expiry_date < now() ? true : false;

            return view('pages.jobs.details', [
                'jobDetail' => $jobDetail,
                'employer' => $employer,
                'employerInfo' => $employerInfo,
                'relatedJobs' => $relatedJobs,
                'jobApplication' => $jobApplication ?? false,
                'jobApplicationId' => $jobApplicationId ?? false,
                'isApplied' => $isApplied ?? collect([]),
                'isBookmarked' => $isBookmarked ?? false,
                'isExpired' => $isExpired ?? false
            ]);
        }

        return abort(404);
    }

    public function jobApplyIndex(Request $request, $uniqueId) {
        if (Auth::guard('admin')->check()) {
            return redirect()->back();
        }
        $jobDetail = JobListing::where(JobListing::JOB_REFERENCE, $uniqueId)->first();
        if ($jobDetail) {
            $employer = $jobDetail->employer;
            $employerInfo = $employer->employerInfo;

            if (Auth::check()) {
                $candidate = $request->user();
                $candidateCvs = $candidate->candidateCVs()->orderBy(UserCv::CREATED_AT, 'DESC')->get();
                $defaultCVId = $candidate->defaultCandidateCV();
                $jobApplication = JobApplication::where(
                    [
                        JobApplication::JOB_LISTING_ID => $jobDetail->id,
                        JobApplication::USER_ID => Auth::id()
                    ]
                )->first();
                $isApplied = JobApplication::where(
                    [
                        JobApplication::JOB_LISTING_ID => $jobDetail->id,
                        JobApplication::USER_ID => Auth::id()
                    ]
                )->count();
                $hasFeedback = Feedback::where(
                    [
                        JobApplication::JOB_LISTING_ID => $jobDetail->id,
                        JobApplication::USER_ID => Auth::id()
                    ]
                )->count();
            }

            return view('pages.jobs.apply', [
                'jobDetail' => $jobDetail,
                'jobApplication' => $jobApplication ?? false,
                'employer' => $employer,
                'candidateCvs' => $candidateCvs ?? collect([]),
                'employerInfo' => $employerInfo,
                'defaultCVId' => $defaultCVId ?? false,
                'isApplied' => $isApplied ?? false,
                'hasFeedback' => $hasFeedback ?? false,
            ]);
        }
        return abort(404);
    }

    public function contactSubmit(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dataToStore = $request->except(['_token', '_method']);

        Contact::create($dataToStore);

        return redirect()->back()->with('message', "We will contact you shortly.");
    }
}
