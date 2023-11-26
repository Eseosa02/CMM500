<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Log;

class EmployerVerified
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

        if ($role === 'employer') {
            $isComplete = $user->isComplete;

            
            if ($isComplete == 100 && in_array($user->employerInfo->approval, ['unverified', 'rejected'])) {
                return redirect()->route('employer.verification');
            }

            return $next($request);
        }

        $this->auth->logout();
        return redirect()->route('login')->withErrors([
            'email' => 'You are not permitted to access the application',
        ]);
    }
}
