<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.css')
    </head>
    <body>
        <div class="page-wrapper dashboard">
            <!-- Preloader -->
            <div class="preloader"></div>
            
            @include('_partials.main.header')

            <!-- Sidebar Backdrop -->
            <div class="sidebar-backdrop"></div>

            <!-- User Sidebar -->
            <div class="user-sidebar">

            <div class="sidebar-inner">
                <ul class="navigation">
                    @if (Auth::guard('admin')->check())
                        <li class="{{ Route::currentRouteName() === 'dashboard.admin.index' ? 'active' : '' }}"><a href="{{ route('dashboard.admin.index') }}"> <i class="la la-home"></i> Dashboard</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.admin.feedbacks' ? 'active' : '' }}"><a href="{{ route('dashboard.admin.feedbacks') }}"> <i class="la la-comment-alt"></i> Feedback</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.admin.joblistings' ? 'active' : '' }}"><a href="{{ route('dashboard.admin.joblistings') }}"> <i class="la la-briefcase"></i> Job Listings</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.admin.jobseekers' ? 'active' : '' }}"><a href="{{ route('dashboard.admin.jobseekers') }}"> <i class="la la-user-tie"></i> Jobseekers</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.admin.recruiters' ? 'active' : '' }}"><a href="{{ route('dashboard.admin.recruiters') }}"> <i class="la la-users"></i> Recruiters</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.admin.list' ? 'active' : '' }}"><a href="{{ route('dashboard.admin.list') }}"> <i class="la la-user-secret"></i> Admins</a></li>
                    @else
                        <li class="{{ Route::currentRouteName() === 'dashboard.candidate.index' || Route::currentRouteName() === 'dashboard.employer.index' ? 'active' : '' }}"><a href="{{ route('dashboard.index') }}"> <i class="la la-home"></i> Dashboard</a></li>
                    @endif
                    @if (!Auth::guard('admin')->check() && Auth::user()->role === "employer")
                        <li class="{{ Route::currentRouteName() === 'dashboard.employer.profile.index' ? 'active' : '' }}"><a href="{{ route('dashboard.employer.profile.index') }}"><i class="la la-user-tie"></i>Company Profile</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.employer.job.index' ? 'active' : '' }}"><a href="{{ route('dashboard.employer.job.index') }}"><i class="la la-paper-plane"></i>Post a New Job</a></li>
                        <li class="{{ Str::contains(Route::currentRouteName(), 'dashboard.employer.job.manage') ? 'active' : '' }}"><a href="{{ route('dashboard.employer.job.manage') }}"><i class="la la-briefcase"></i> Manage Jobs</a></li>
                        <li class="{{ Str::contains(Route::currentRouteName(), 'dashboard.employer.job.applications') ? 'active' : '' }}"><a href="{{ route('dashboard.employer.job.applications') }}"><i class="la la-file-invoice"></i> Manage Applications</a></li>
                    @endif
                    @if (!Auth::guard('admin')->check() && Auth::user()->role === "candidate")
                        <li class="{{ Route::currentRouteName() === 'dashboard.candidate.profile.index' ? 'active' : '' }}"><a href="{{ route('dashboard.candidate.profile.index') }}"><i class="la la-user-tie"></i>My Profile</a></li>
                        <li class="{{ Str::contains(Route::currentRouteName(), 'dashboard.candidate.resume') ? 'active' : '' }}"><a href="{{ route('dashboard.candidate.resume') }}"><i class="la la-file-invoice"></i>My Resume</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.candidate.job.manage' ? 'active' : '' }}"><a href="{{ route('dashboard.candidate.job.manage') }}"><i class="la la-briefcase"></i> Applied Jobs </a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.candidate.job.saved' ? 'active' : '' }}"><a href="{{ route('dashboard.candidate.job.saved') }}"><i class="la la-bookmark"></i> Saved Jobs </a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.candidate.cv.index' ? 'active' : '' }}"><a href="{{ route('dashboard.candidate.cv.index') }}"><i class="la la-file-invoice"></i> CV manager</a></li>
                    @endif
                    @if (Auth::guard('admin')->check())
                        <li class="{{ Route::currentRouteName() === 'dashboard.admin.password.index' ? 'active' : '' }}"><a href="{{ route('dashboard.admin.password.index') }}"><i class="la la-lock"></i>Change Password</a></li>
                    @else
                        <li class="{{ Route::currentRouteName() === 'dashboard.notification.index' ? 'active' : '' }}"><a href="{{ route('dashboard.notification.index') }}"><i class="la la-bell"></i>Notifications</a></li>
                        <li class="{{ Route::currentRouteName() === 'dashboard.password.index' ? 'active' : '' }}"><a href="{{ route('dashboard.password.index') }}"><i class="la la-lock"></i>Change Password</a></li>
                    @endif
                    <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="la la-sign-out"></i>Logout</a></li>
                </ul>

                @if (!Auth::guard('admin')->check() && Auth::user()->role === "candidate")
                    <div class="skills-percentage">
                        <h4>Profile Percentage</h4>
                        @if (Auth::user()->isComplete < 50)
                            <p>Complete Information for "My Profile" to increase your profile completion up to "50%"</p>
                        @endif
                        @if (Auth::user()->isComplete == 50 && !Auth::user()->candidateInfo->image)
                            <p>Upload a "Profile Image" to increase your profile completion up to "60%"</p>
                        @endif
                        @if (Auth::user()->isComplete == 60)
                            <p>Complete Information for "My Resume" to increase your profile completion up to "90%"</p>
                        @endif
                        @if (Auth::user()->isComplete == 90)
                            <p>Complete Information for "CV Manager" to increase your profile completion up to "100%"</p>
                        @endif
                        <!-- Pie Graph -->
                        <div class="pie-graph">
                            <div class="graph-outer">
                                <input type="text" class="dial" data-fgColor="#7367F0" data-bgColor="transparent" data-width="234" data-height="234" data-linecap="normal" value="{{ Auth::user()->isComplete }}">
                                <div class="inner-text count-box"><span class="count-text txt" data-stop="{{ Auth::user()->isComplete }}" data-speed="2000"></span>%</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            </div>
            <!-- End User Sidebar -->
            
            @yield("content")

            <!-- Copyright -->
            <div class="copyright-text">
                <p>© {{ date('Y') }} {{ env('APP_NAME') }}. All Right Reserved.</p>
            </div>
        </div><!-- End Page Wrapper -->
        @include('layouts.js')
        @yield("script")
        @yield("script2")
    </body>
</html>