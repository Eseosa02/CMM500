@extends('layouts.app')
@section('content')
  <!-- Banner Section-->
	<section class="banner-section">
		<div class="auto-container">
			<div class="row">
				<div class="content-column col-lg-7 col-md-12 col-sm-12">
					<div class="inner-column wow fadeInUp" data-wow-delay="1000ms">
						<div class="title-box">
							<h3>There Are <span class="colored">{{ $jobsCount }}</span> Postings Here<br> For you!</h3>
							<div class="text">Find Jobs, Employment & Career Opportunities</div>
						</div>

						<!-- Job Search Form -->
						<div class="job-search-form">
							<form method="get" action="{{ route('pages.search') }}" id="findJobs">
								<div class="row">
									<div class="form-group col-lg-5 col-md-12 col-sm-12">
										<span class="icon flaticon-search-1"></span>
										<input type="text" name="title" placeholder="Job title, keywords, or company">
									</div>
									<!-- Form Group -->
									<div class="form-group col-lg-4 col-md-12 col-sm-12 location">
										<span class="icon flaticon-map-locator"></span>
										<input type="text" name="location" placeholder="City or Country">
									</div>
									<!-- Form Group -->
									<div class="form-group col-lg-3 col-md-12 col-sm-12 btn-box">
										<button type="submit" class="theme-btn btn-style-one"><span class="btn-title">Find Jobs</span></button>
									</div>
								</div>
							</form>
						</div>
						<!-- Job Search Form -->
					</div>
				</div>

				<div class="image-column col-lg-5 col-md-12">
					<div class="image-box">
						<figure class="main-image wow fadeIn" data-wow-delay="500ms"><img src="{{ asset('assets/images/resource/banner-img-1.png') }}" alt=""></figure>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Section-->

	<!-- Job Categories -->
	<section class="job-categories">
		<div class="auto-container">
			<div class="sec-title text-center">
				<h2>Popular Job Categories</h2>
				<div class="text">2020 jobs live - 293 added today.</div>
			</div>

			<div class="row wow fadeInUp">
				@foreach($categories as $category)
					<div class="category-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<div class="content">
								<span class="icon flaticon-money-1"></span>
								<h4><a href="{{ route('pages.search', ['category' => openssl_encrypt($category->id, "AES-128-ECB", "FP25Hg9KKNJx")]) }}">{{ $category->title }}</a></h4>
								<p>({{ $category->jobCategoryListing->count() }} open positions)</p>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>
	<!-- End Job Categories -->

	<!-- Job Section -->
	<section class="job-section">
		<div class="auto-container">
			<div class="sec-title text-center">
				<h2>Featured Jobs</h2>
				<div class="text">Know your worth and find the job that qualify your life</div>
			</div>

			<div class="row wow fadeInUp">
				@foreach ($featuredJobs as $job)
					<!-- Job Block -->
					<div class="job-block col-lg-6 col-md-12 col-sm-12">
						<div class="inner-box">
							<div class="content">
								<span class="company-logo"><img src="{{ $job->employer->employerInfo->image ? asset($job->employer->employerInfo->image) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
								<h4><a href="{{ route('pages.jobs.detail', ['uniqueId' => $job->job_reference, 'titleSlug' => $job->title_slug]) }}">{{ $job->title }}</a></h4>
								<ul class="job-info">
									<li><span class="icon flaticon-briefcase"></span> {{ $job->category->title }}</li>
									<li><span class="icon flaticon-map-locator"></span> {{ $job->city }}, {{ $job->country }}</li>
									<li><span class="icon flaticon-clock-3"></span> {{ $job->created_at->diffForHumans() }}</li>
									<li><span class="icon flaticon-money"></span> {{ $job->salary }}</li>
								</ul>
								<ul class="job-other-info">
									<li class="time">{{ Str::title($job->contract_type) }}</li>
									<li class="required">{{ Str::ucfirst($job->priority) }}</li>
									@if (in_array($job->status, ['closed', 'discarded']))
										<li class="closed">{{ Str::ucfirst($job->status) }}</li>
									@endif
								</ul>
							</div>
						</div>
					</div>
				@endforeach
			</div>

			<div class="btn-box">
				<a href="#" onclick="event.preventDefault(); document.getElementById('findJobs').submit();" class="theme-btn btn-style-one bg-blue"><span class="btn-title">Load More Listing</span></a>
			</div>
		</div>
	</section>
	<!-- End Job Section -->

  	<!-- About Section -->
	<section class="about-section">
		<div class="auto-container">
			<div class="row">
				<!-- Content Column -->
				<div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
					<div class="inner-column wow fadeInUp">
						<div class="sec-title">
							<h2>Millions of Jobs. Find the one that suits you.</h2>
							<div class="text">Search all the open positions on the web. Get your own personalized salary estimate. Read reviews on over 600,000 companies worldwide.</div>
						</div>
						<ul class="list-style-one">
							<li>Bring to the table win-win survival</li>
							<li>Capitalize on low hanging fruit to identify</li>
							<li>But I must explain to you how all this</li>
						</ul>
						<a href="{{ route('register') }}" class="theme-btn btn-style-one bg-blue"><span class="btn-title">Get Started</span></a>
					</div>
				</div>

				<!-- Image Column -->
				<div class="image-column col-lg-6 col-md-12 col-sm-12">
					<figure class="image wow fadeInLeft"><img src="{{ asset('assets/images/resource/image-2.jpg') }}" alt=""></figure>

					<!-- Count Employers -->
					<div class="count-employers wow fadeInUp">
						<div class="check-box"><span class="flaticon-tick"></span></div>
						<span class="title">300k+ Employers</span>
						<figure class="image"><img src="{{ asset('assets/images/resource/multi-logo.png') }}" alt=""></figure>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End About Section -->

  @include('_partials.main.callToAction')

@endsection