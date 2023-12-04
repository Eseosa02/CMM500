@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Welcome back, {{ Auth::user()->name }}!</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
			<div class="row">
				<div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.employer.job.posted') }}">
						<div class="ui-item">
							<div class="left">
								<i class="icon flaticon-briefcase"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($jobsPosted) }}</h4>
								<p>Posted Jobs</p>
							</div>
						</div>
					</a>
				</div>
				<div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.employer.job.applications') }}">
						<div class="ui-item ui-green">
							<div class="left">
								<i class="icon la la-file-invoice"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($jobsApplications) }}</h4>
								<p>Total Applications</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.notification.index') }}">
						<div class="ui-item ui-red">
							<div class="left">
								<i class="icon la la-bell"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($jobNotificationsCount) }}</h4>
								<p>Notifications</p>
							</div>
						</div>
					</a>
				</div>
				<div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.employer.job.applications', ['status' => 'under-review']) }}">
						<div class="ui-item ui-yellow">
							<div class="left">
								<i class="icon la la-comment-o"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($jobApplicationsReview) }}</h4>
								<p>Under Review</p>
							</div>
						</div>
					</a>
				</div>
				{{-- <div class="ui-block col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<div class="ui-item ui-green">
						<div class="left">
							<i class="icon la la-handshake-o"></i>
						</div>
						<div class="right">
							<h4>{{ number_format($jobApplicationsAccepted) }}</h4>
							<p>Accepted</p>
						</div>
					</div>
				</div> --}}
			</div>
  
		  	<div class="row">
				<div class="col-xl-7 col-lg-12">
					<!-- applicants Widget -->
					<div class="applicants-widget ls-widget">
						<div class="widget-title">
							<h4>Recent Applications</h4>
						</div>
						<div class="widget-content">
							<div class="row">
								@foreach ($jobRecentApplications as $application)
									<!-- Candidate block three -->
									<div class="candidate-block-three col-lg-12 col-md-12 col-sm-12">
										<div class="inner-box">
											<div class="content">
												<figure class="image"><img src="{{ $application->user->userImage() ? asset($application->user->userImage()) : asset('assets/images/resource/candidate-1.png') }}" alt=""></figure>
												<h4 class="name" style="position: relative; display: flex; flex-wrap: wrap;">
													<a href="{{ route('dashboard.employer.job.manage.applicant', ['jobReference' => $application->jobListing->job_reference ]) }}">{{ $application->user->name }}</a>
													<div class="job-other-info" style="position: relative; display: flex; flex-wrap: wrap;">
														<li class="time status {{ $application->status }} m-0 mx-2">{{ Str::replaceFirst('-', ' ', Str::title($application->status)) }}</li>
													</div>
												</h4>
												<ul class="candidate-info">
													<li class="designation">{{ $application->candidateInfo->title }}</li>
													<li><span class="icon flaticon-map-locator"></span> {{ $application->candidateInfo->city }}, {{ $application->candidateInfo->country }}</li>
													<li><span class="icon flaticon-money"></span> {{ $application->candidateInfo->experience }} Years</li>
												</ul>
												@if (count($application->candidateInfo->skills) > 0)
													<ul class="post-tags">
														@foreach ($application->candidateInfo->skills as $key => $skill)
															@if ($key < 3)
																<li><a href="#">{{ $skill }}</a></li>
															@endif
														@endforeach
														@if (count($application->candidateInfo->skills) - 3 > 0)
															{{ count($application->candidateInfo->skills) - 3 }} +
														@endif
													</ul>
												@endif
											</div>
											<div class="option-box">
												<ul class="option-list">
													<li>
														<a href="{{ route('pages.candidate.detail', ['uniqueId' => $application->candidateInfo->unique_id, 'applicationId' => openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx"), 'joblistingId' => openssl_encrypt($application->jobListing->id, "AES-128-ECB", "FP25Hg9KKNJx")]) }}">
															<button data-text="View Profile"><span class="la la-eye"></span></button>
														</a>
													</li>
													@if (!in_array($application->status, ['rejected', 'withdrawn']))
														@if ($application->status === "under-review")
															<li>
																<a href="#" onclick="event.preventDefault(); document.getElementById('approve-form-{{ $application->id }}').submit();">
																	<button data-text="Approve Application" class="approve"><span class="la la-check approve"></span></button></li>
																</a>
																<form method="post" action="{{ route('dashboard.employer.job.manage.decision') }}" id="approve-form-{{ $application->id }}"  style="display: none;">
																	@csrf
																	@method('POST')
																	<input type="hidden" name="applicationId" value="{{ openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx") }}">
																	<input type="hidden" name="status" value="accepted">
																	<button class="theme-btn btn-style-three" type="submit">Approve Application</button>
																</form>
														@else
															@if ($application->status !== "accepted")
																<li>
																	<a href="#" onclick="event.preventDefault(); document.getElementById('under-review-form-{{ $application->id }}').submit();">
																		<button data-text="Move to Review" class="under-review"><span class="la la-plus under-review"></span></button>
																	</a>
																	<form method="post" action="{{ route('dashboard.employer.job.manage.decision') }}" id="under-review-form-{{ $application->id }}"  style="display: none;">
																		@csrf
																		@method('POST')
																		<input type="hidden" name="applicationId" value="{{ openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx") }}">
																		<input type="hidden" name="status" value="under-review">
																		<button class="theme-btn btn-style-three" type="submit">Review Application</button>
																	</form>
																</li>
															@endif
														@endif
														<li>
															<a href="#" onclick="event.preventDefault(); document.getElementById('rejected-form-{{ $application->id }}').submit();">
																<button data-text="Reject Application" class="reject"><span class="la la-times-circle reject"></span></button>
															</a>
															<form method="post" action="{{ route('dashboard.employer.job.manage.decision') }}" id="rejected-form-{{ $application->id }}"  style="display: none;">
																@csrf
																@method('POST')
																<input type="hidden" name="applicationId" value="{{ openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx") }}">
																<input type="hidden" name="status" value="rejected">
																<button class="theme-btn btn-style-three" type="submit">Review Application</button>
															</form>
														</li>
													@endif
												</ul>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
  
				<div class="col-xl-5 col-lg-12">
					<!-- Notification Widget -->
					<div class="notification-widget ls-widget">
						<div class="widget-title">
							<h4>Notifications</h4>
						</div>
						<div class="widget-content">
							@if ($jobNotifications->count() === 0)
								<p>Nothing to see here at the moment.</p>
							@else
								<ul class="notification-list">
									@foreach ($jobNotifications as $key => $notification)
										<li @if(Str::contains($notification->status, 'accepted')) class="success" @endif>
											<span class="icon flaticon-briefcase"></span> 
											{{ $notification->message }} @if ($notification->status === 'unread') <span class="label label-notification">New</span> @endif
										</li>
									@endforeach
								</ul>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Dashboard -->
@endsection