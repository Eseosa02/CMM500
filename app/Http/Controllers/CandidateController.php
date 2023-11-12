<?php

namespace App\Http\Controllers;

use App\Jobs\JobNotificationJob;
use App\Models\Feedback;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\JobNotification;
use App\Models\SavedJob;
use App\Models\User;
use App\Models\UserCv;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if (Auth::check() && $this->user->role === User::ROLE_CANDIDATE) {
                return $next($request);
            }

            return redirect()->back();
        });
    }

    public function index(Request $request) {
        $jobApplications = $request->user()->jobApplications->whereNotIn(JobApplication::STATUS, ['withdrawn'])->count();
        $jobNotificationsCount = $request->user()->candidateJobNotifications->where(JobNotification::STATUS, 'unread')->count();
        $savedJobCount = $request->user()->candidateSavedJobs->count();
        $featuredJobs = JobListing::where(JobListing::STATUS, 'open')->inRandomOrder()->take(3)->get();
        $recentlyAppliedJobs = $request->user()->jobApplications()->orderBy(JobApplication::CREATED_AT, 'DESC')->take(3)->get();
        return view('pages.dashboard.candidate.index', [
            'savedJobCount' => $savedJobCount,
            'jobApplications' => $jobApplications,
            'recentlyAppliedJobs' => $recentlyAppliedJobs,
            'featuredJobs' => $featuredJobs,
            'jobNotificationsCount' => $jobNotificationsCount,
        ]);
    }

    public function profileIndex(Request $request) {
        $candidate = Auth::user();
        $candidateInfo = $candidate->candidateInfo;
        return view('pages.dashboard.candidate.profile.index', [
            'skills' => self::SKILLS,
            'countries' => self::COUNTRIES,
            'candidate' => $candidate,
            'candidateInfo' => $candidateInfo,
        ]);
    }

    public function profileIndexUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'title' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:male,female,others',
            'dob' => 'required|date',
            'education' => 'required|in:OND,HND,Bachelor of Science,Master of Science,Doctor of Philosophy',
            'experience' => 'required',
            'skills' => 'required|array',
            'description' => 'required',
            'country' => 'required',
            'city' => 'required',
            'image' => 'nullable',
            'sexuality' => 'required|in:'. implode(',', ['Heterosexual', 'Gay', 'Lesbian', 'Bisexual', 'Prefer not to say']),
            'disability' => 'required|in:'. implode(',', ['Yes', 'No', 'Prefer not to say']),
            'religion' => 'required|in:'. implode(',', ['Christianity', 'Buddhist', 'Muslim', 'Hindu', 'Other', 'Prefer not to say']),
            'website' => 'nullable|url:http,https',
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
            User::NAME => $request->name,
            User::IS_COMPLETE => $user->isComplete > 50 ? $user->isComplete : 50
        ]);

        $dataToStore = $request->except(['name', '_token', '_method', 'image']);

        if (!empty($request->image)) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time().'.' . $extension;
            $file->move(public_path('uploads/candidate'), $filename);
            $dataToStore['image']= 'uploads/candidate/' . $filename;
            if ($user->candidateInfo->image) {
                File::delete(public_path($user->candidateInfo->image));
            }
            $user->update([
                User::NAME => $request->name,
                User::IS_COMPLETE => $user->isComplete > 60 ? $user->isComplete : 60
            ]);
        }

        $dataToStore[UserProfile::RATING] = $this->handleRatingData($request->skills, $user->candidateInfo->rating);

        $user->candidateInfo()->update($dataToStore);

        return back()->with('message', 'Information updated successfully!');
    }

    public function jobsManage(Request $request) {
        $status = Str::lower($request->query('status'));
        if ($status && $status !== "all") {
            $jobApplications = $request->user()->jobApplications()->where('status', $status)->orderBy('created_at', 'DESC')->paginate(15);
        } else {
            $jobApplications = $request->user()->jobApplications()->orderBy('created_at', 'DESC')->paginate(15);
        }

        return view('pages.dashboard.candidate.jobs.manage', [
            'jobApplications' => $jobApplications,
            'status' => $status
        ]);
    }

    public function manageSavedJobs(Request $request) {
        $savedJobs = $request->user()->candidateSavedJobs()->orderBy('created_at', 'DESC')->paginate(15);

        return view('pages.dashboard.candidate.jobs.saved', [
            'savedJobs' => $savedJobs,
        ]);
    }

    public function resumeIndex(Request $request) {
        $candidate = Auth::user();
        $candidateEducations = $request->user()->candidateEducations()->orderBy(JobApplication::CREATED_AT, 'desc')->get();
        $candidateExperiences = $request->user()->candidateExperiences()->orderBy(JobApplication::CREATED_AT, 'desc')->get();
        $candidateInfo = $request->user()->candidateInfo;
        return view('pages.dashboard.candidate.resume.index', [
            'candidate' => $candidate,
            'skillsRating' => $candidateInfo->rating,
            'candidateInfo' => $request->user()->candidateInfo,
            'candidateEducations' => $candidateEducations,
            'candidateExperiences' => $candidateExperiences,
        ]);
    }

    public function resumeUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'skills' => 'required|array|min:1',
            'ratings' => 'required|array|min:1',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $request->user();

        $user->update([
            User::IS_COMPLETE => $user->isComplete > 90 ? $user->isComplete : 90
        ]);

        $user->candidateInfo()->update([
            UserProfile::RATING => array_combine($request->skills, $request->ratings)
        ]);

        return back()->with('message', 'Information updated successfully!');
    }

    public function educationIndex(Request $request) {
        $candidate = Auth::user();
        $editModeId = $request->query('edit');
        $deleteModeId = $request->query('trash');
        $candidateEducation = [];
        if ($editModeId) {
            $candidateEducation = $candidate->candidateEducations->find($editModeId);

            if (!$candidateEducation) {
                abort(404);
            }
        }
        
        if ($deleteModeId) {
            $educationDelete = $candidate->candidateEducations->find($deleteModeId);
            
            if(!$educationDelete) {
                abort(404);
            }

            $educationDelete->delete();
            
            return back()->with('message', 'Information deleted successfully!');
        }

        return view('pages.dashboard.candidate.education.index', [
            'candidate' => $candidate,
            'editModeId' => $editModeId,
            'candidateEducation' => $candidateEducation
        ]);
    }

    public function educationUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'institution' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'grade' => 'required',
            'mode' => 'required|in:edit,create',
            'id' => 'required_if:mode,edit'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $request->user();

        $dataToStore = $request->except(['_token', '_method', 'mode', 'id']);

        if ($request->mode === 'create') {
            $user->candidateEducations()->create($dataToStore);
            $user->update([
                User::IS_COMPLETE => $user->isComplete > 70 ? $user->isComplete : 70
            ]);
        } else {
            $user->candidateEducations()->find($request->id)->update($dataToStore);
        }

        return redirect()->route('dashboard.candidate.resume')->with('message', 'Information updated successfully!');
    }

    public function experienceIndex(Request $request) {
        $candidate = Auth::user();
        $editModeId = $request->query('edit');
        $deleteModeId = $request->query('trash');
        $candidateExperience = [];
        if ($editModeId) {
            $candidateExperience = $candidate->candidateExperiences->find($editModeId);

            if (!$candidateExperience) {
                abort(404);
            }
        }
        
        if ($deleteModeId) {
            $experienceDelete = $candidate->candidateExperiences->find($deleteModeId);
            
            if(!$experienceDelete) {
                abort(404);
            }

            $experienceDelete->delete();
            
            return back()->with('message', 'Information deleted successfully!');
        }

        return view('pages.dashboard.candidate.experience.index', [
            'candidate' => $candidate,
            'editModeId' => $editModeId,
            'candidateExperience' => $candidateExperience
        ]);
    }

    public function experienceUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'institution' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'is_present' => 'nullable',
            'description' => 'required',
            'mode' => 'required|in:edit,create',
            'id' => 'required_if:mode,edit'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!$request->has('is_present') && !$request->end_date) {
            return redirect()->back()->withErrors('End date is required')->withInput();
        }

        $user = $request->user();

        $dataToStore = $request->except(['_token', '_method', 'mode', 'id', 'end_date']);

        if ($request->has('is_present')) {
            $dataToStore['is_present'] = 1;
        } else {
            $dataToStore['is_present'] = $request->end_date;
        }

        if ($request->mode === 'create') {
            $user->candidateExperiences()->create($dataToStore);
            $user->update([
                User::IS_COMPLETE => $user->isComplete > 80 ? $user->isComplete : 80
            ]);
        } else {
            $user->candidateExperiences()->find($request->id)->update($dataToStore);
        }

        return redirect()->route('dashboard.candidate.resume')->with('message', 'Information updated successfully!');
    }

    public function cvIndex(Request $request) {
        $candidate = $request->user();

        if ($request->query('is_default')) {
            $candidate->candidateCVs()->where(UserCv::USER_ID, $candidate->id)->update([
                UserCv::IS_DEFAULT => 0
            ]);
            $candidate->candidateCVs()->where(UserCv::ID, $request->query('is_default'))->update([
                UserCv::IS_DEFAULT => 1
            ]);

            return back();
        }
        
        $candidateCvs = $candidate->candidateCVs()->orderBy(UserCv::IS_DEFAULT, 'DESC')->get();

        return view('pages.dashboard.candidate.cv.index', [
            'candidate' => $candidate,
            'candidateCvs' => $candidateCvs,
        ]);
    }

    public function cvDelete(Request $request, $cvId) {
        $candidate = $request->user();
        $deleteModeId = $cvId;
        $candidateCVs = $candidate->candidateCVs;
        
        if ($deleteModeId) {
            $userCV = $candidateCVs->find($deleteModeId);
            
            if(!$userCV) {
                abort(404);
            }

            if (File::exists(public_path($userCV->attachment))) {
                File::delete(public_path($userCV->attachment));
            }
            
            if ($candidateCVs->count() === 1) {
                $candidate->update([
                    User::IS_COMPLETE => 90
                ]);
            } else {
                $candidateCVs->where(UserCv::ID, '<>', $deleteModeId)->first()->update([
                    UserCv::IS_DEFAULT => 1
                ]);
            }

            $userCV->delete();
            
            return back();
        }

        return back();
    }

    public function cvUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'attachment' => 'required',
            'is_default' => 'nullable',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $candidate = $request->user();

        $dataToStore = $request->except(['_token', '_method']);

        if (!empty($request->attachment)) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time().'.' . $extension;
            $file->move(public_path('uploads/candidate/cv'), $filename);
            $dataToStore[UserCv::ATTACHMENT]= 'uploads/candidate/cv/' . $filename;
            $candidate->update([
                User::IS_COMPLETE => $candidate->isComplete > 90 ? $candidate->isComplete : 100
            ]);
        }

        if (isset($dataToStore[UserCv::IS_DEFAULT]) && $dataToStore[UserCv::IS_DEFAULT] === "on") {
            $candidate->candidateCVs()->where(UserCv::USER_ID, $candidate->id)->update([
                UserCv::IS_DEFAULT => 0
            ]);
        }

        $is_default = $candidate->candidateCVs->count() === 0 || (isset($dataToStore[UserCv::IS_DEFAULT]) && $dataToStore[UserCv::IS_DEFAULT] === "on") ? 1 : 0;

        $candidate->candidateCVs()->create([
            UserCv::USER_ID => $candidate->id,
            UserCv::ATTACHMENT => $dataToStore[UserCv::ATTACHMENT],
            UserCv::TITLE => $dataToStore[UserCv::TITLE],
            UserCv::IS_DEFAULT => $is_default
        ]);


        return back()->with('message', 'Information updated successfully!');
    }

    public function bookmarkJobAdd(Request $request, $jobId) {
        $jobListing = JobListing::find($jobId);

        if (!$jobListing) {
            abort(404);
        }

        SavedJob::create([
            SavedJob::FK_USER_ID => $request->user()->id,
            SavedJob::FK_JOB_LISTING_ID => $jobId
        ]);

        JobNotification::create([
            JobNotification::USER_ID => $request->user()->id,
            JobNotification::JOB_LISTING_ID => $jobId,
            JobNotification::MESSAGE => "You added $jobListing->title to Saved Jobs."
        ]);

        return redirect()->back();
    }

    public function bookmarkJobRemove(Request $request, $jobId) {
        $jobListing = JobListing::find($jobId);

        if (!$jobListing) {
            abort(404);
        }

        $savedJob = SavedJob::where([
            SavedJob::FK_USER_ID => $request->user()->id,
            SavedJob::FK_JOB_LISTING_ID => $jobId
        ])->first();

        if (!$savedJob) {
            abort(404);
        }

        $savedJob->delete();

        JobNotification::create([
            JobNotification::USER_ID => $request->user()->id,
            JobNotification::JOB_LISTING_ID => $jobId,
            JobNotification::MESSAGE => "You removed $jobListing->title from Saved Jobs."
        ]);

        return redirect()->back();
    }

    public function jobApplicationSubmission (Request $request) {
        $validator = Validator::make($request->all(), [
            'job_listing_id' => 'required|exists:job_listings,id',
            'message' => 'nullable',
            'cv_id' => 'required|exists:user_cvs,id',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $candidate = $request->user();

        if ($candidate->isCandidate()) {
            if ($candidate->isComplete == 100) {
                $dataToStore = $request->except(['_token', '_method']);
    
                $dataToStore[JobListing::USER_ID] = $candidate->id;

                $jobListing = JobListing::find($dataToStore[JobApplication::JOB_LISTING_ID]);

                $jobApplication = $candidate->jobApplications()->where([
                    JobApplication::JOB_LISTING_ID => $dataToStore[JobApplication::JOB_LISTING_ID]
                ])->first();

                if (!$jobApplication) {
                    $jobApplication = $candidate->jobApplications()->create($dataToStore);
                    // candidate notification
                    JobNotification::create([
                        JobNotification::USER_ID => $candidate->id,
                        JobNotification::JOB_LISTING_ID => $dataToStore[JobApplication::JOB_LISTING_ID],
                        JobNotification::MESSAGE => $jobListing->title . " application has been submitted."
                    ]);
                    // employer notification
                    JobNotification::create([
                        JobNotification::USER_ID => $jobListing->user_id,
                        JobNotification::JOB_LISTING_ID => $dataToStore[JobApplication::JOB_LISTING_ID],
                        JobNotification::MESSAGE => $candidate->name . " submitted application for " . $jobListing->title . "."
                    ]);
                    dispatch(new JobNotificationJob($candidate, $jobApplication));
                    return back()->with('message', 'Job Application Submitted successfully.');
                }
                
                if ($jobApplication && $jobApplication->status === 'withdrawn') {
                    $dataToStore = $request->except(['_token', '_method', 'job_listing_id']);
                    $dataToStore[JobApplication::STATUS] = 'submitted';
                    $jobApplication->update($dataToStore);
                    
                    // candidate notification
                    JobNotification::create([
                        JobNotification::USER_ID => $jobApplication->user_id,
                        JobNotification::JOB_LISTING_ID => $jobApplication->job_listing_id,
                        JobNotification::MESSAGE => $jobApplication->jobListing->title . " application has been re-submitted."
                    ]);

                    // employer notification
                    JobNotification::create([
                        JobNotification::USER_ID => $jobListing->user_id,
                        JobNotification::JOB_LISTING_ID => $dataToStore[JobApplication::JOB_LISTING_ID],
                        JobNotification::MESSAGE => $candidate->name . " re-submitted application for " . $jobListing->title . "."
                    ]);
                    
                    return back()->with('message', 'Your application has been re-submitted.');
                }

                return back()->withErrors('You have submitted an application already.');
            } else {
                return back()->withErrors('You must complete your profile up to 100% to apply for a job.');
            }
        } else {
            return back()->with('message', 'You must be a candidate to apply for jobs');
        }
    }

    public function jobApplicationFeedback (Request $request) {
        $validator = Validator::make($request->all(), [
            'job_listing_id' => 'required|exists:job_listings,id',
            'message' => 'nullable',
            'rating' => 'required|min:1'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $candidate = $request->user();

        if ($candidate->isCandidate()) {
            if ($candidate->isComplete == 100) {
                $dataToStore = $request->except(['_token', '_method']);
    
                $dataToStore[Feedback::USER_ID] = $candidate->id;

                $jobApplication = $candidate->jobApplications()->where([
                    JobApplication::JOB_LISTING_ID => $dataToStore[JobApplication::JOB_LISTING_ID]
                ])->first();

                if (!$jobApplication) {
                    return back()->with('message', 'Job Listing is invalid.');
                }

                $candidate->candidateFeedbacks()->create($dataToStore);

                return back()->with('message', 'Your feedback is greatly appreciated as it helps us continually improve.');

            } else {
                return back()->withErrors('You must complete your profile up to 100% to apply for a job.');
            }
        } else {
            return back()->with('message', 'You must be a candidate to submit feedback.');
        }
    }

    public function withdrawApplication(Request $request, $applicationId) {
        $candidate = $request->user();
        $jobApplication = $candidate->jobApplications()->find($applicationId);

        if (!$jobApplication) {
            abort(404);
        }

        $jobApplication->update([
            JobApplication::STATUS => 'withdrawn',
        ]);

        return redirect()->back();
    }
}
