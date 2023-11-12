@if (Route::currentRouteName() !== 'pages.homepage')
<!-- Header Span -->
<span class="header-span"></span>
@endif

<!-- Main Header-->
<header class="main-header {{ Route::currentRouteName() !== 'pages.homepage' ? 'header-shaddow' : '' }}">
	@if (Route::currentRouteName() !== 'pages.homepage')
		<div class="container-fluid">
	@endif
		<!-- Main box -->
		<div class="main-box">
			<!--Nav Outer -->
			<div class="nav-outer">
				<div class="logo-box">
					<div class="logo"><a href="{{ route('pages.homepage') }}"><img src="{{ asset('assets/images/logo.svg') }}" alt="" title=""></a></div>
				</div>

				<nav class="nav main-menu">
					<ul class="navigation" id="navbar">
						<li class="{{ Route::currentRouteName() === 'pages.homepage' ? 'current' : '' }}">
							<a href="{{ route('pages.homepage') }}">
								<span>Home</span>
							</a>
						</li>
						<li class="{{ Route::currentRouteName() === 'pages.search' ? 'current' : '' }}">
							<a href="{{ route('pages.search', ['title' => '', 'location' => '']) }}">
								<span>Find Jobs</span>
							</a>
						</li>
						<li class="{{ Route::currentRouteName() === 'pages.about' ? 'current' : '' }}">
							<a href="{{ route('pages.about') }}">
								<span>About</span>
							</a>
						</li>
						<li class="{{ Route::currentRouteName() === 'pages.contact' ? 'current' : '' }}">
							<a href="{{ route('pages.contact') }}">
								<span>Contact</span>
							</a>
						</li>
						@if (Auth::check() || Auth::guard('admin')->check())
							@if (Auth::guard('admin')->check())
								<li class="{{ request()->is('admin/dashboard/*') ? 'current' : '' }}">
									<a href="{{ route('dashboard.admin.index') }}">
										<span>Dashboard</span>
									</a>
								</li>
							@else
								<li class="{{ request()->is('dashboard/*') ? 'current' : '' }}">
									<a href="{{ route('dashboard.index') }}">
										<span>Dashboard</span>
									</a>
								</li>
							@endif
						@else
							<li class="d-block d-sm-block d-md-none {{ request()->is('auth/*') ? 'current' : '' }}">
								<a href="{{ route('login') }}">
									<span>Login</span>
								</a>
							</li>
						@endif

						<!-- Only for Mobile View -->
						<li class="mm-add-listing">
							<span>
								<span class="contact-info">
									<span class="phone-num"><span>Call us</span><a href="tel:07716283642">077 162 836 42</a></span>
									<span class="address">Garthdee House, Garthdee Road, <br>Aberdeen, AB10 7AQ.</span>
									<a href="mailto:{{ env('SUPPORT_EMAIL') }}" class="email">{{ env('SUPPORT_EMAIL') }}</a>
								</span>
								<span class="social-links">
									<a href="#"><span class="fab fa-facebook-f"></span></a>
									<a href="#"><span class="fab fa-twitter"></span></a>
									<a href="#"><span class="fab fa-instagram"></span></a>
									<a href="#"><span class="fab fa-linkedin-in"></span></a>
								</span>
							</span>
						</li>
					</ul>
				</nav>
				<!-- Main Menu End-->
			</div>

			<div class="outer-box">
				@if (Auth::guard('admin')->check() || (Auth::check() && Auth::id()))
					{{-- @if (Auth::check())
						<button class="menu-btn">
							<span class="count notification">1</span>
							<span class="icon la la-bell"></span>
						</button>
					@endif --}}

					<!-- Dashboard Option -->
					<div class="dropdown dashboard-option">
						<a class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
							@if ($userImage = !Auth::guard('admin')->check() && Auth::user()->userImage())
								<img src="{{ asset(Auth::user()->userImage()) }}" alt="avatar" class="thumb logo-icon">
							@else
								<img src="{{ asset('assets/images/admin.png') }}" alt="avatar" class="thumb">
							@endif
							<span class="name">{{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : Auth::user()->name }}</span>
						</a>
						<ul class="dropdown-menu">
							@if (Auth::guard('admin')->check())
								<li><a href="{{ route('dashboard.admin.index') }}"><i class="la la-home"></i>Dashboard</a></li>
								<li><a href="{{ route('dashboard.admin.password.index') }}"><i class="la la-lock"></i>Change Password</a></li>
							@else
								<li><a href="{{ route('dashboard.index') }}"><i class="la la-home"></i>Dashboard</a></li>
								<li><a href="{{ route('dashboard.password.index') }}"><i class="la la-lock"></i>Change Password</a></li>
							@endif
							<li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="la la-sign-out"></i>Logout</a></li>
							<form method="post" action="{{ Auth::guard('admin')->check() ? route('dashboard.admin.logout') : route('dashboard.logout') }}" id="logout-form"  style="display: none;">
								@csrf
								@method('POST')
								<button class="theme-btn btn-style-three" type="submit" name="logout">Logout</button>
							</form>
						</ul>
					</div>
				@else
					<!-- Login/Register -->
					<div class="btn-box">
						<a href="{{ route('login') }}" class="theme-btn btn-style-three">Login / Register</a>
					</div>
				@endif
				<select class="selectpicker" style="margin-left: 15px" data-width="fit">
					<option selected>🇬🇧 EN</option>
					<option>🇪🇸 ES</option>
					<option>🇫🇷 FR</option>
					<option>🇩🇪 GE</option>
					<option>🇯🇵 JP</option>
				</select>
			</div>
		</div>
	@if (Route::currentRouteName() !== 'pages.homepage')
		</div>
	@endif

    <!-- Mobile Header -->
    <div class="mobile-header">
		<div class="logo"><a href="{{ Auth::check() ? route('dashboard.index') : route('pages.homepage') }}"><img src="{{ asset('assets/images/logo.svg') }}" alt="" title=""></a></div>

		<!--Nav Box-->
		<div class="nav-outer clearfix">

			<div class="outer-box">
				@if (Auth::check() || Auth::guard('admin')->check())
					<button id="toggle-user-sidebar"><img src="{{ asset('assets/images/resource/company-7.png') }}" alt="avatar" class="thumb"></button>
				@else
					<!-- Login/Register -->
					<div class="login-box">
						<a href="{{ route('login') }}"><span class="icon-user"></span></a>
					</div>
				@endif
				<a href="#nav-mobile" class="mobile-nav-toggler {{ Auth::check() ? 'navbar-trigger' : '' }}"><span class="flaticon-menu-1"></span></a>
			</div>
		</div>
    </div>

    <!-- Mobile Nav -->
    <div id="nav-mobile"></div>
</header>
<!--End Main Header -->