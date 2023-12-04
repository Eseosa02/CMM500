@extends('layouts.auth.app')
@section('content')
    <!-- Info Section -->
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{ asset('assets/images/background/12.jpg') }});"></div>
        <div class="outer-box">
          	<!-- Login Form -->
			<div class="login-form default-form">
				<div class="form-inner">
					<h3>Admin Login to {{ env('APP_NAME') }}</h3>
					
					<!-- Login Error message -->
					@if ($errors->count() > 0)
						<div class="message-box error">
                            <p class="m-0">{!! $errors->first() !!}</p>
                            <button class="close-btn"><span class="close_icon"></span></button>
                        </div>
					@endif
					
					<!--Login Form-->
					<form method="post" action="{{ route('admin.login.authenticate') }}">
						@csrf
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
						</div>
		
						<div class="form-group">
							<label>Password</label>
							<input id="password-field" type="password" name="password" value="" placeholder="Password">
						</div>
		
						{{-- <div class="form-group">
							<div class="field-outer">
								<div class="input-group checkboxes square">
								<input type="checkbox" name="remember-me" value="" id="remember">
								<label for="remember" class="remember"><span class="custom-checkbox"></span> Remember me</label>
								</div>
								<a href="#" class="pwd">Forgot password?</a>
							</div>
						</div> --}}
		
						<div class="form-group">
							<button class="theme-btn btn-style-one" type="submit" name="log-in">Log In</button>
						</div>
					</form>
				</div>
			</div>
			<!--End Login Form -->
        </div>
    </div>
    <!-- End Info Section -->
@endsection