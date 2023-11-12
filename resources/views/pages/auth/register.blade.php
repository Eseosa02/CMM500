@extends('layouts.auth.app')
@section('content')
    <!-- Info Section -->
    <div class="login-section">
		<div class="image-layer" style="background-image: url({{ asset('assets/images/background/12.jpg') }});"></div>
		<div class="outer-box">
			<!-- Login Form -->
			<div class="login-form default-form">
				<div class="form-inner">
					<h3>Create a Free {{ env('APP_NAME') }} Account</h3>

					<!-- Register Error message -->
					@if ($errors->count() > 0)
						<div class="message-box error">
                            <p class="m-0">{!! $errors->first() !!}</p>
                            <button class="close-btn"><span class="close_icon"></span></button>
                        </div>
					@endif
		
					<!--Login Form-->
					<form method="post" action="{{ route('register.account') }}">
						@csrf
						<div class="form-group">
							<div class="btn-box row">
								<div class="col-lg-6 col-md-12">
								<a href="#" class="theme-btn btn-style-seven" id="candidateOption" onclick="handleRoleSwitch(event)"><i class="la la-user"></i> Candidate </a>
								</div>
								<div class="col-lg-6 col-md-12">
								<a href="#" class="theme-btn btn-style-four" id="employerOption" onclick="handleRoleSwitch(event)"><i class="la la-briefcase"></i> Employer </a>
								</div>
							</div>
						</div>
		
						<div class="form-group">
							<label id="nameToggle">Name</label>
							<input type="text" id="nameToggleInput" name="name" placeholder="Name" value="{{ old('name') }}">
						</div>

						<div class="form-group">
							<label>Email Address</label>
							<input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
						</div>
		
						<div class="form-group">
							<label>Password</label>
							<input id="password-field" type="password" name="password" value="" placeholder="Password">
						</div>

						<div class="form-group">
							<input type="hidden" name="role" id="roleValue" value="{{ old('role') }}">
						</div>

						<!-- Input -->
						<div class="form-group">
							<ul class="switchbox">
								<li>
									<label class="switch">
										<input type="checkbox" name="accepted">
										<span class="slider round gdpr"></span>
										<span class="title">
											<i>I hereby consent to the processing of the personal data that I have provided and declare my agreement with the data protection regulations in the data privacy statement of {{ env('APP_NAME') }}</i>
										</span>
									</label>
								</li>
							</ul>
						</div>
		
						<div class="form-group">
							<button class="theme-btn btn-style-one " type="submit" name="Register">Register</button>
						</div>
					</form>
		
					{{-- <div class="bottom-box">
						<div class="divider"><span>or</span></div>
						<div class="btn-box row">
							<div class="col-lg-6 col-md-12">
								<a href="#" class="theme-btn social-btn-two facebook-btn"><i class="fab fa-facebook-f"></i> Log In via Facebook</a>
							</div>
							<div class="col-lg-6 col-md-12">
								<a href="#" class="theme-btn social-btn-two google-btn"><i class="fab fa-google"></i> Log In via Gmail</a>
							</div>
						</div>
					</div> --}}
				</div>
			</div>
			<!--End Login Form -->
		</div>
	</div>
	<!-- End Info Section -->
@endsection
@section('script')
	<script>
		function handleRoleSwitch (event) {
			event.preventDefault();
			const { id: idSelector } = event.target
			const candidateOptionElement = document.getElementById("candidateOption");
			const employerOptionElement = document.getElementById("employerOption");
			const roleValueElement = document.getElementById("roleValue");
			const nameToggleElement = document.getElementById("nameToggle");
			const nameToggleInputElement = document.getElementById("nameToggleInput");
			
			if (idSelector === "candidateOption" && !candidateOptionElement.classList.contains('btn-style-seven')) {
				candidateOptionElement.classList.remove("btn-style-four");
				candidateOptionElement.classList.add("btn-style-seven");

				employerOptionElement.classList.remove("btn-style-seven");
				employerOptionElement.classList.add("btn-style-four");
				roleValueElement.value = 'candidate';
				nameToggleElement.innerText = 'Name';
				nameToggleInputElement.placeholder = 'Name';
			}
			
			if (idSelector === "employerOption" && !employerOptionElement.classList.contains('btn-style-seven')) {
				candidateOptionElement.classList.remove("btn-style-seven");
				candidateOptionElement.classList.add("btn-style-four");
				
				employerOptionElement.classList.remove("btn-style-four");
				employerOptionElement.classList.add("btn-style-seven");
				roleValueElement.value = 'employer';
				nameToggleElement.innerText = 'Company Name';
				nameToggleInputElement.placeholder = 'Company Name';
			}
		}
		$(document).ready(function () {
			// check url for default category and enable checkbox
			const defaultCategory = Object.fromEntries(new URLSearchParams(location.search));
			if (defaultCategory.category) {
				document.getElementById("roleValue").value = "employer";
			}

			//  default behaviour for no category set on the url
			const roleValueElement = document.getElementById("roleValue");
			if (!roleValueElement.value) {
				roleValueElement.value = 'candidate';
			}
			const candidateOptionElement = document.getElementById("candidateOption");
			const employerOptionElement = document.getElementById("employerOption");
			const nameToggleElement = document.getElementById("nameToggle");
			const nameToggleInputElement = document.getElementById("nameToggleInput");

			if (roleValueElement.value === "employer") {
				candidateOptionElement.classList.remove("btn-style-seven");
				candidateOptionElement.classList.add("btn-style-four");
				
				employerOptionElement.classList.remove("btn-style-four");
				employerOptionElement.classList.add("btn-style-seven");
				nameToggleElement.innerText = 'Company Name';
				nameToggleInputElement.placeholder = 'Company Name';
			}
		});
	</script>
@endsection