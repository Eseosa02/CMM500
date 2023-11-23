<?php

namespace App\Http\Controllers;

use App\Models\JobNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            if (Auth::check() && in_array($this->user->role, [User::ROLE_EMPLOYER, User::ROLE_CANDIDATE])) {
                return $next($request);
            }

            Auth::logout();
            return redirect()->route('login');
        });
    }

    public function index(Request $request) {
        $redirectUrl = $this->user->role === User::ROLE_EMPLOYER ? 'dashboard.employer.index' : 'dashboard.candidate.index';
        return redirect()->route($redirectUrl);
    }

    public function jobNotification(Request $request) {
        $jobNotifications = $request->user()->candidateJobNotifications()->orderBy('created_at', 'DESC')->paginate(15);
        return view('pages.dashboard.notifications', [
            'jobNotifications' => $jobNotifications,
        ]);
    }

    public function jobNotificationUpdate(Request $request, $mode, $notificationId) {
        if (!in_array($mode, ['delete', 'read']) && !$notificationId) {
            abort(422);
        }
        $jobNotification = JobNotification::find($notificationId);

        if (!$jobNotification) {
            abort(404);
        }

        if ($mode === 'delete') {
            $jobNotification->delete();
        }

        if ($mode === 'read') {
            $jobNotification->update([
                JobNotification::STATUS => 'read'
            ]);
        }

        return back();
    }

    public function passwordIndex(Request $request) {
        return view('pages.dashboard.password');
    }

    public function passwordChange(Request $request) {
        $validator = Validator::make($request->all(), [
            'old-password' => 'required|current_password',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'password_confirmation' => 'required|same:password'
        ], [
            'old-password.current_password' => 'Current password is incorrect'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update Password
        $request->user()->update([
            'password' => $request->password
        ]);

        return back()->with('message', 'Password change successfully!');
    }
}
