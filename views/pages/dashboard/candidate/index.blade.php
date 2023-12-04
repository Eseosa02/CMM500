@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
			<div class="upper-title-box">
				<div class="row">
					<div class="col-md-8">
						<h3>Welcome back, {{ Auth::user()->name }}!!</h3>
						<div class="text">Ready to jump back in?</div>
					</div>
					<div class="col-md-4">
						<div class="search-box-one">
							<div class="form-group">
								<span class="icon flaticon-search-1"></span>
								<input type="search" name="title" value="{{ Request::query('title') }}" placeholder="Search Jobs" required="" id="title" style="border: 2px solid grey">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.candidate.job.manage') }}">
						<div class="ui-item">
							<div class="left">
								<i class="icon flaticon-briefcase"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($jobApplications) }}</h4>
								<p>Applied Jobs</p>
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
				<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
					<a href="{{ route('dashboard.candidate.job.saved') }}">
						<div class="ui-item ui-green">
							<div class="left">
								<i class="icon la la-bookmark-o"></i>
							</div>
							<div class="right">
								<h4>{{ number_format($savedJobCount) }}</h4>
								<p>Saved Jobs</p>
							</div>
						</div>
					</a>
				</div>
			</div>
  
			<div class="row">
				<div class="col-lg-6">
					<!-- applicants Widget -->
					<div class="applicants-widget ls-widget">
						<div class="widget-title">
							<h4>Featured Jobs</h4>
						</div>
						<div class="widget-content">
							<div class="row">
								@if ($featuredJobs->count() === 0)
									Nothing to see here.
								@else
									@foreach ($featuredJobs as $listing)
										<!-- Job Block -->
										<div class="job-block col-lg-12 col-md-12 col-sm-12">
											<div class="inner-box">
												<div class="content">
													<span class="company-logo"><img src="{{ $listing->employer->employerInfo->image ? asset($listing->employer->employerInfo->image) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
													<h4><a href="{{ route('pages.jobs.detail', ['uniqueId' => $listing->job_reference, 'titleSlug' => $listing->title_slug]) }}">{{ $listing->title }}</a></h4>
													<ul class="job-info">
														<li><span class="icon flaticon-briefcase"></span> {{ $listing->category->title }}</li>
														<li><span class="icon flaticon-map-locator"></span> {{ $listing->city }}, {{ $listing->country }}</li>
														<li><span class="icon flaticon-clock-3"></span> {{ $listing->created_at->diffForHumans() }}</li>
														<li><span class="icon flaticon-money"></span> {{ $listing->salary }}</li>
													</ul>
													<ul class="job-other-info">
														<li class="time">{{ Str::title($listing->contract_type) }}</li>
														<li class="required">{{ Str::ucfirst($listing->priority) }}</li>
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
	
				<div class="col-lg-6">
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
			</div>
        </div>
    </section>
    <!-- End Dashboard -->
@endsection
@section('script')
    <script>
		function delay(callback, ms) {
			var timer = 0;
			return function() {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
				callback.apply(context, args);
				}, ms || 0);
			};
		}
		function handleStatusChange(event) {
			const { value } = event.target;
			const { origin, pathname, search } = window.location;
			
			const urlParams = new URLSearchParams(search); // For GET request
			urlParams.append("status", value);
			
			const urlQueryString = new URLSearchParams(Object.fromEntries(urlParams)).toString();
			window.location.href = `${origin}${pathname}?${urlQueryString}`;
		}
        $(document).ready(function () {
			$('#title').keyup(delay(function (e) {
				window.location.href = `${window.location.origin}/jobs/search?title=${e.target.value}&location=`
			}, 1000));
        });
    </script>
@endsection