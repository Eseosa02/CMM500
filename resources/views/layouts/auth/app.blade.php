<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.css')
    </head>
    <body data-anm=".anm">
        <div class="page-wrapper">
            <!-- Preloader -->
            <div class="preloader"></div>
            
            <!-- Main Header-->
            <header class="main-header">
                <div class="container-fluid">
                <!-- Main box -->
                <div class="main-box">
                    <!--Nav Outer -->
                    <div class="nav-outer">
                    <div class="logo-box">
                        <div class="logo"><a href="{{ route('pages.homepage') }}"><img src="{{ asset('assets/images/logo-2.svg') }}" alt="" title=""></a></div>
                    </div>
                    </div>
        
                    <div class="outer-box">
                    <!-- Login/Register -->
                    <div class="btn-box">
                        @if (Auth::check())
                            <form method="post" action="{{ route('dashboard.logout') }}">
                                @csrf
                                @method('POST')
                                <button class="theme-btn btn-style-three" type="submit" name="logout">Logout</button>
                            </form>
                        @else
                            @if (Route::currentRouteName() === 'login')
                                <a href="{{ route('register') }}" class="theme-btn btn-style-three">Register</a>
                            @else
                                <a href="{{ route('login') }}" class="theme-btn btn-style-three">Login</a>
                            @endif
                        @endif
                    </div>
                    </div>
                </div>
                </div>
        
                <!-- Mobile Header -->
                <div class="mobile-header">
                    <div class="logo"><a href="{{ route('pages.homepage') }}"><img src="{{ asset('assets/images/logo.svg') }}" alt="" title=""></a></div>
                </div>
        
                <!-- Mobile Nav -->
                <div id="nav-mobile"></div>
            </header>
            <!--End Main Header -->
            
            @yield("content")

        </div><!-- End Page Wrapper -->
        @include('layouts.js')
        @yield("script")
    </body>
</html>