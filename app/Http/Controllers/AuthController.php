<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    public function login() {
        if (Auth::check()) {
            return $this->dashboardRedirection();
        }
        return view('pages.auth.login');
    }
    
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->status === 'disabled') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'You account has been disabled, please contact admin',
                ])->onlyInput('email');
            }
            
            // redirect user back to the intended job application page
            if ($request->jobId) {
                $jobId = $request->jobId;
                $jobListing = JobListing::where(JobListing::JOB_REFERENCE, $jobId)->first();

                if ($jobListing && Auth::user()->isComplete == 100) {
                    return redirect()->route('pages.jobs.apply', ['uniqueId' => $jobId]);
                }
            }
 
            return $this->dashboardRedirection();
        }
 
        return back()->withErrors([
            'email' => 'Invalid Email and/or Password',
        ])->onlyInput('email');
    }

    public function register() {
        if (Auth::check()) {
            return $this->dashboardRedirection();
        }
        return view('pages.auth.register');
    }

    public function createAccount(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
            'accepted' => 'required',
            'role' => 'required|in:' . User::ROLE_CANDIDATE . ',' .  User::ROLE_EMPLOYER ,
        ], [
            'accepted.required' => 'You must accept our GDPR Rules & Regulations'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $user = User::create($data);
        $dataToStore = [
            User::FK_USER_ID => $user->id
        ];
        $user->isEmployer() ? $user->employerInfo()->create(
            array_merge($dataToStore, [
                'unique_id' => $this->generateUniqueId(User::ROLE_EMPLOYER)
            ])
        ) : $user->candidateInfo()->create(
            array_merge($dataToStore, [
                'unique_id' => $this->generateUniqueId(User::ROLE_CANDIDATE)
            ])
        );
        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard.index');
    }

    public function emailVerificationIndex(Request $request) {
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return $this->dashboardRedirection();
        }
        return view('pages.auth.email-verification-notice');
    }

    public function emailVerification(EmailVerificationRequest $request) {
        $request->fulfill();
         
        return $this->dashboardRedirection();
    }

    public function emailVerificationResend(Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }

    public function adminLogin() {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('dashboard.admin.index');
        }
        return view('pages.admin.login');
    }
    
    /**
     * Handle an authentication attempt.
     */
    public function adminAuthenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::guard('admin')->user()->status === 'disabled') {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'You account has been disabled, please contact admin',
                ])->onlyInput('email');
            }
 
            return redirect()->route('dashboard.admin.index');
        }
 
        return back()->withErrors([
            'email' => 'Invalid Email and/or Password',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->back();
    }

    /**
     * Log the user out of the application.
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('admin.login');
    }
}
