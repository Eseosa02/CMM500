@extends('layouts.dashboard.app')
@section('content')
	<!-- Dashboard -->
	<section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Change Password</h3>
				<div class="text">Ready to jump back in?</div>
			</div>

			<!-- Ls widget -->
			<div class="ls-widget">
				<div class="widget-title">
					<h4>Change Password</h4>
				</div>

				<div class="widget-content">
					<!-- Profile Error message -->
					@if ($errors->count() > 0)
						<div class="message-box error">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
                            <button class="close-btn"><span class="close_icon"></span></button>
                        </div>
					@endif
					@if (\Session::has('message'))
						<div class="message-box success">
                            <p class="m-0">{!! \Session::get('message') !!}</p>
                            <button class="close-btn"><span class="close_icon"></span></button>
                        </div>
					@endif
					<form class="default-form" method="POST" action="{{ route('dashboard.password.change') }}">
						@csrf
						@method('POST')
						<div class="row">
							<!-- Input -->
							<div class="form-group col-lg-7 col-md-12">
								<label>Old Password </label>
								<input type="password" name="old-password">
							</div>

							<!-- Input -->
							<div class="form-group col-lg-7 col-md-12">
								<label>New Password</label>
								<input type="password" name="password">
							</div>

							<!-- Input -->
							<div class="form-group col-lg-7 col-md-12">
								<label>Confirm Password</label>
								<input type="password" name="password_confirmation">
							</div>

							<!-- Input -->
							<div class="form-group col-lg-6 col-md-12">
								<button class="theme-btn btn-style-one" type="submit">Update</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
	<!-- End Dashboard -->
@endsection