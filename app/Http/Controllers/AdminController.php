<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\EmployerProfile;
use App\Models\Feedback;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    private $admin;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->admin = Auth::guard('admin')->user();

            if (Auth::guard('admin')->check() && $this->admin) {
                return $next($request);
            }

            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');
        });
    }

    public function index(Request $request) {
        $jobListings = JobListing::count();
        $jobsPostedApplications = JobApplication::count();
        $jobseekerCount = User::where(User::ROLE, User::ROLE_CANDIDATE)->count();
        $recruiterCount = User::where(User::ROLE, User::ROLE_EMPLOYER)->count();
        $bannedUsers = User::where(User::STATUS, 'disabled')->count();
        $feedbacks = Feedback::count();
        $admins = Admin::count();
        return view('pages.admin.index', [
            'jobListings' => $jobListings,
            'jobsPostedApplications' => $jobsPostedApplications,
            'jobseekerCount' => $jobseekerCount,
            'recruiterCount' => $recruiterCount,
            'bannedUsers' => $bannedUsers,
            'feedbacks' => $feedbacks,
            'admins' => $admins,
        ]);
    }

    public function feedbacksIndex(Request $request) {
        $feedbacks = Feedback::orderBy(Feedback::CREATED_AT, 'DESC');
        $rating = $request->query('rating');
        if ($rating && $rating !== 'all') {
            $feedbacks = $feedbacks->where(Feedback::RATING, $rating);
        }
        $feedbacks = $feedbacks->paginate(15);
        return view('pages.admin.feedbacks', [
            'feedbacks' => $feedbacks,
        ]);
    }

    public function feedbacksDelete(Request $request) {
        $validator = Validator::make($request->all(), [
            'feedbackId' => 'required'
        ]);

        if ($validator->fails()) {
            abort(500);
        }
        
        $feedback = Feedback::find(openssl_decrypt($request->feedbackId, "AES-128-ECB", "FP25Hg9KKNJx"));

        if (!$feedback) {
            abort(404);
        }

        $feedback->delete();

        return redirect()->back();
    }

    public function jobseekersIndex(Request $request) {
        $jobseekers = User::where(User::ROLE, User::ROLE_CANDIDATE)->orderBy(User::CREATED_AT, 'DESC');
        $status = $request->query('status');
        $name = $request->query('name');
        if ($status && $status !== 'all') {
            $jobseekers = $jobseekers->where(User::STATUS, $status);
        }
        if ($name) {
            $jobseekers = $jobseekers->where(User::NAME, 'LIKE', "%$name%");
        }
        $jobseekers = $jobseekers->paginate(15);
        return view('pages.admin.jobseekers', [
            'jobseekers' => $jobseekers,
        ]);
    }

    public function recruitersIndex(Request $request) {
        $recruiters = User::where(User::ROLE, User::ROLE_EMPLOYER)->orderBy(User::CREATED_AT, 'DESC');
        $status = $request->query('status');
        $name = $request->query('name');
        if ($status && $status !== 'all') {
            $recruiters = $recruiters->where(User::STATUS, $status);
        }
        if ($name) {
            $recruiters = $recruiters->where(User::NAME, 'LIKE', "%$name%");
        }
        $recruiters = $recruiters->paginate(15);
        return view('pages.admin.recruiters', [
            'recruiters' => $recruiters,

        ]);
    }

    public function recruiterVerificationUpdate(Request $request, $employerId, $status) {
        $employerInfo = EmployerProfile::where(EmployerProfile::UNIQUE_ID, $employerId)->first();
        
        if (!$employerInfo) {
            abort(404);
        }
        
        if (!in_array($status, ['rejected', 'verified'])) {
            return redirect()->back();
        }
        
        $employerInfo->update([
            EmployerProfile::APPROVAL => $status
        ]);
        
        return redirect()->route('dashboard.admin.recruiters');
    }

    public function joblistingsIndex(Request $request) {
        $joblistings = JobListing::orderBy(User::CREATED_AT, 'DESC');
        $status = $request->query('status');
        $title = $request->query('title');
        if ($status && $status !== 'all') {
            $joblistings = $joblistings->where(User::STATUS, $status);
        }
        if ($title) {
            $joblistings = $joblistings->where(JobListing::TITLE, 'LIKE', "%$title%");
        }
        $joblistings = $joblistings->paginate(15);
        return view('pages.admin.joblistings', [
            'joblistings' => $joblistings,
        ]);
    }

    public function memberStatusUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:disabled,active',
            'userId' => 'required'
        ]);

        if ($validator->fails()) {
            abort(500);
        }
        
        $user = User::find(openssl_decrypt($request->userId, "AES-128-ECB", "FP25Hg9KKNJx"));

        if (!$user) {
            abort(404);
        }

        if (!in_array($request->status, ['active', 'disabled'])) {
            abort(422);
        }

        $user->update([
            User::STATUS => $request->status
        ]);

        return redirect()->back();
    }

    public function memberDelete(Request $request) {
        $validator = Validator::make($request->all(), [
            'userId' => 'required'
        ]);

        if ($validator->fails()) {
            abort(500);
        }
        
        $user = User::find(openssl_decrypt($request->userId, "AES-128-ECB", "FP25Hg9KKNJx"));

        if (!$user) {
            abort(404);
        }

        if ($user->isCandidate()) {
            // delete the uploaded images
            if ($user->candidateInfo->image) {
                File::delete(public_path($user->candidateInfo->image));
            }
            // delete candidateInfo
            $user->candidateInfo->delete();
            // delete candidateEducations
            $user->candidateEducations()->delete();
            // delete candidateExperiences
            $user->candidateExperiences()->delete();
            // delete candidateJobNotifications
            $user->candidateJobNotifications()->delete();
            // delete candidateSavedJobs
            $user->candidateSavedJobs()->delete();
            // delete jobApplications
            $user->jobApplications()->delete();
            // delete jobApplications
            $user->candidateFeedbacks()->delete();
            // delete candidateCVs
            $user->candidateCVs->each(function ($cv) {
                if ($cv->attachment && File::exists(public_path($cv->attachment))) {
                    File::delete(public_path($cv->attachment));
                }
            });
            $user->candidateCVs()->delete();
        }

        if ($user->isEmployer()) {
            // delete employerInfo
            $user->employerInfo->delete();
            // delete jobListings application
            $user->jobListings->each(function ($listing) {
                JobApplication::where(JobApplication::JOB_LISTING_ID, $listing->id)->delete();
                Feedback::where(Feedback::JOB_LISTING_ID, $listing->id)->delete();
            });
            // delete jobListings
            $user->jobListings()->delete();
        }

        $user->delete();

        return redirect()->back();
    }

    public function adminsIndex(Request $request) {
        $admins = Admin::orderBy(User::CREATED_AT, 'DESC');
        $status = $request->query('status');
        $name = $request->query('name');
        if ($status && $status !== 'all') {
            $admins = $admins->where(User::STATUS, $status);
        }
        if ($name) {
            $admins = $admins->where(User::NAME, 'LIKE', "%$name%");
        }
        $admins = $admins->paginate(15);
        return view('pages.admin.manage', [
            'admins' => $admins,
        ]);
    }

    public function adminStatusUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:disabled,active',
            'userId' => 'required'
        ]);

        if ($validator->fails()) {
            abort(500);
        }
        
        $admin = Admin::find(openssl_decrypt($request->userId, "AES-128-ECB", "FP25Hg9KKNJx"));

        if (!$admin) {
            abort(404);
        }

        if (!in_array($request->status, ['active', 'disabled'])) {
            abort(422);
        }

        $admin->update([
            Admin::STATUS => $request->status
        ]);

        return redirect()->back();
    }

    public function adminDelete(Request $request) {
        $validator = Validator::make($request->all(), [
            'userId' => 'required'
        ]);

        if ($validator->fails()) {
            abort(500);
        }
        
        $admin = Admin::find(openssl_decrypt($request->userId, "AES-128-ECB", "FP25Hg9KKNJx"));

        if (!$admin) {
            abort(404);
        }

        $admin->delete();

        return redirect()->back();
    }

    public function adminsCreateIndex(Request $request) {
        $admin = NULL;
        $editModeId = openssl_decrypt($request->query('edit'), 'AES-128-ECB', 'FP25Hg9KKNJx');
        if ($editModeId) {
            $admin = Admin::find($editModeId);

            if (!$admin) {
                abort(404);
            }
        }
        return view('pages.admin.create', [
            'admin' => $admin,
            'editModeId' => $editModeId
        ]);
    }

    public function adminsCreate(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required_if:mode,create|unique:admins',
            'status' => 'required|in:active,disabled',
            'mode' => 'required|in:edit,create',
            'id' => 'required_if:mode,edit'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dataToStore = $request->except(['_token', '_method', 'mode', 'id']);

        if ($request->mode === 'create') {
            $dataToStore[Admin::PASSWORD] = $this->generateRandomString(8); 
            Admin::create($dataToStore);
            $response = 'created';
        } else {
            Admin::findOrFail($request->id)->update($dataToStore);
            $response = 'updated';
        }

        return redirect()->route('dashboard.admin.create.index')->with('message', "Admin $response successfully! Email will be sent to Admin.");
    }

    public function passwordIndex(Request $request) {
        return view('pages.admin.password');
    }

    public function passwordChange(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'password_confirmation' => 'required|same:password'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $admin = Auth::guard('admin')->user();
        
        if (Hash::check($request->old_password, $admin->password)) {
            // Update Password
            Auth::guard('admin')->user()->update([
                'password' => $request->password
            ]);
        } else {
            return redirect()->back()->withErrors(['Current password doesn\'t match.'])->withInput();
        }

        return back()->with('message', 'Password change successfully!');
    }
}
