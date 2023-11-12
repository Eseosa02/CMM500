<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Routing\Route;

class ProfileCompletion
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $this->auth->user();
        $role = $user->role;

        $currentRoute = $request->route()->getName();

        if (in_array($role, ['candidate', 'employer'])) {
            $isComplete = $user->isComplete;

            if ($role === 'candidate') {
                // redirect to candidate profile page
                $redirectToCandidateProfile = 'dashboard.candidate.profile.index';
                $redirectToCandidateProfileUpdate = 'dashboard.candidate.profile.update';
                if ($isComplete < 60 && !in_array($currentRoute, [$redirectToCandidateProfile, $redirectToCandidateProfileUpdate])) {
                    return redirect()->route($redirectToCandidateProfile);
                }
                
                // redirect to candidate resume page
                // $redirectToCandidateResume = 'dashboard.candidate.resume';
                // if ($isComplete >= 60 && $isComplete < 90 && $currentRoute !== $redirectToCandidateResume) {
                //     return redirect()->route($redirectToCandidateResume);
                // }
                
                // // redirect to candidate cv upload page
                // $redirectToCandidateCvUpload = 'dashboard.candidate.cv.index';
                // if ($isComplete >= 90 && $isComplete < 100 && $currentRoute !== $redirectToCandidateCvUpload) {
                //     return redirect()->route($redirectToCandidateCvUpload);
                // }
            }

            if ($role === 'employer') {
                $redirectToEmployerProfile = 'dashboard.employer.profile.index';
                $redirectToEmployerProfileUpdate = 'dashboard.employer.profile.update';
                if ($isComplete < 100 && !in_array($currentRoute, [$redirectToEmployerProfile, $redirectToEmployerProfileUpdate])) {
                    return redirect()->route($redirectToEmployerProfile);
                }
            }

            return $next($request);
        }

        $this->auth->logout();
        return redirect()->route('login')->withErrors([
            'email' => 'You are not permitted to access the application',
        ]);
    }
}
