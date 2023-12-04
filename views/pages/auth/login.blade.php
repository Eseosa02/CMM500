@extends('layouts.auth.app')
@section('content')
    <!-- Info Section -->
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{ asset('assets/images/background/12.jpg') }});"></div>
        <div class="outer-box">
          	<!-- Login Form -->
			<div class="login-form default-form">
				<div class="form-inner">
					<h3>Login to {{ env('APP_NAME') }}</h3>
					
					<!-- Login Error message -->
					@if ($errors->count() > 0)
						<div class="message-box error">
                            <p class="m-0">{!! $errors->first() !!}</p>
                            <button class="close-btn"><span class="close_icon"></span></button>
                        </div>
					@endif
					
					<!--Login Form-->
					<form method="post" action="{{ route('login.authenticate') }}">
						@csrf
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
						</div>
		
						<div class="form-group">
							<label>Password</label>
							<input id="password-field" type="password" name="password" value="" placeholder="Password">
						</div>
		
						<div class="form-group">
							<div class="field-outer">
								<div class="input-group checkboxes square">
								<input type="checkbox" name="remember-me" value="" id="remember">
								<label for="remember" class="remember"><span class="custom-checkbox"></span> Remember me</label>
								</div>
								{{-- <a href="#" class="pwd">Forgot password?</a> --}}
							</div>
						</div>

						<input type="hidden" name="jobId" value="{{ Request::query('jobId') }}">
		
						<div class="form-group">
							<button class="theme-btn btn-style-one" type="submit" name="log-in">Log In</button>
						</div>
					</form>
		
					<div class="bottom-box">
						<div class="text">Don't have an account? <a href="{{ route('register') }}">Register</a></div>
						{{-- <div class="divider"><span>or</span></div>
						<div class="btn-box row">
							<div class="col-lg-6 col-md-12">
								<a href="#" class="theme-btn social-btn-two facebook-btn"><i class="fab fa-facebook-f"></i> Log In via Facebook</a>
							</div>
							<div class="col-lg-6 col-md-12">
								<a href="#" class="theme-btn social-btn-two google-btn"><i class="fab fa-google"></i> Log In via Gmail</a>
							</div>
						</div> --}}
					</div>
				</div>
			</div>
			<!--End Login Form -->
        </div>
    </div>
    <!-- End Info Section -->
@endsection