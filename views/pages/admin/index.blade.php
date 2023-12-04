@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Welcome back, {{ Auth::guard('admin')->user()->name }}!!</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
			<div class="row">
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.admin.joblistings') }}">
						<div class="ui-item">
							<div class="left">
								<i class="icon flaticon-briefcase"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($jobListings) }}</h4>
								<p>Total Job Lisitings</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<div class="ui-item ui-yellow">
						<div class="left">
							<i class="icon la la-file-invoice"></i>
						</div>
						<div class="right">
							<h4>{{ number_format($jobsPostedApplications) }}</h4>
							<p>Total Job Applications</p>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.admin.jobseekers') }}">
						<div class="ui-item ui-green">
							<div class="left">
								<i class="icon la la-user-tie"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($jobseekerCount) }}</h4>
								<p>Total Job Seekers</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.admin.recruiters') }}">
						<div class="ui-item ui-green">
							<div class="left">
								<i class="icon la la-users"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($recruiterCount) }}</h4>
								<p>Total Recruiters</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<div class="ui-item ui-red">
						<div class="left">
							<i class="icon la la-ban"></i>
						</div>
						<div class="right">
							<h4>{{ number_format($bannedUsers) }}</h4>
							<p>Banned Members</p>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.admin.feedbacks') }}">
						<div class="ui-item ui-green">
							<div class="left">
								<i class="icon la la-comment-alt"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($feedbacks) }}</h4>
								<p>Submitted Feedbacks</p>
							</div>
						</div>
					</a>
				</div>
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.admin.list') }}">
						<div class="ui-item ui-green">
							<div class="left">
								<i class="icon la la-user-secret"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($admins) }}</h4>
								<p>Total Admins</p>
							</div>
						</div>
					</a>
				</div>
			</div>
  
			{{-- <div class="row">
				<div class="col-lg-7">
					<!-- applicants Widget -->
					<div class="applicants-widget ls-widget">
						<div class="widget-title">
							<h4>Jobs Applied Recently</h4>
						</div>
						<div class="widget-content">
							<div class="row">
								@if ($recentlyAppliedJobs->count() === 0)
									You haven't applied for any job yet.
								@else
									@foreach ($recentlyAppliedJobs as $job)
										<!-- Job Block -->
										<div class="job-block col-lg-12 col-md-12 col-sm-12">
											<div class="inner-box">
												<div class="content">
													<span class="company-logo"><img src="{{ $job->jobListing->employer->employerInfo->image ? asset($job->jobListing->employer->employerInfo->image) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
													<h4><a href="{{ route('pages.jobs.detail', ['uniqueId' => $job->jobListing->job_reference, 'titleSlug' => $job->jobListing->title_slug]) }}">{{ $job->jobListing->title }}</a></h4>
													<ul class="job-info">
														<li><span class="icon flaticon-briefcase"></span> {{ $job->jobListing->category->title }}</li>
														<li><span class="icon flaticon-map-locator"></span> {{ $job->jobListing->city }}, {{ $job->jobListing->country }}</li>
														<li><span class="icon flaticon-clock-3"></span> {{ $job->jobListing->created_at->diffForHumans() }}</li>
														<li><span class="icon flaticon-money"></span> {{ $job->jobListing->salary }}</li>
													</ul>
													<ul class="job-other-info">
														<li class="time">{{ Str::title($job->jobListing->contract_type) }}</li>
														<li class="required">{{ Str::ucfirst($job->jobListing->priority) }}</li>
													</ul>
												</div>
											</div>
										</div>
									@endforeach
								@endif
							</div>
						</div>
					</div>
				</div>
	
				<div class="col-lg-5">
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
									<li><span class="icon flaticon-briefcase"></span> <strong>Wade Warren</strong> applied for a job <span class="colored">Web Developer</span></li>
									<li><span class="icon flaticon-briefcase"></span> <strong>Henry Wilson</strong> applied for a job <span class="colored">Senior Product Designer</span></li>
									<li class="success"><span class="icon flaticon-briefcase"></span> <strong>Raul Costa</strong> applied for a job <span class="colored">Product Manager, Risk</span></li>
									<li><span class="icon flaticon-briefcase"></span> <strong>Jack Milk</strong> applied for a job <span class="colored">Technical Architect</span></li>
									<li class="success"><span class="icon flaticon-briefcase"></span> <strong>Michel Arian</strong> applied for a job <span class="colored">Software Engineer</span></li>
									<li><span class="icon flaticon-briefcase"></span> <strong>Ali Tufan</strong> applied for a job <span class="colored">UI Designer</span></li>
								</ul>
							@endif
						</div>
					</div>
				</div>
	
	
				<div class="col-lg-12">
					
				</div>
			</div> --}}
        </div>
    </section>
    <!-- End Dashboard -->
@endsection