@extends('layouts.app')
@section('content')
    <!--Page Title-->
    <section class="page-title">
		<div class="auto-container">
			<div class="title-outer">
				<h1>Find Jobs</h1>
				<ul class="page-breadcrumb">
					<li><a href="{{ route('pages.homepage') }}">Home</a></li>
					<li>Jobs</li>
				</ul>
			</div>
		</div>
	</section>
	<!--End Page Title-->
  
	<!-- Listing Section -->
	<section class="ls-section">
		<div class="auto-container">
		  	<div class="filters-backdrop"></div>
  
			<div class="row">
				<!-- Filters Column -->
				<div class="filters-column col-lg-4 col-md-12 col-sm-12">
					<div class="inner-column">
						<div class="filters-outer">
							<button type="button" class="theme-btn close-filters">X</button>
		
							<!-- Filter Block -->
							<div class="filter-block">
								<h4>Search by Keywords</h4>
								<div class="form-group">
									<input type="text" name="listing-search" value="{{ Request::query('title') }}" placeholder="Job title, keywords, or company" id="title">
									<span class="icon flaticon-search-3"></span>
								</div>
							</div>
		
							<!-- Filter Block -->
							<div class="filter-block">
								<h4>Location</h4>
								<div class="form-group">
									<input type="text" name="listing-search" value="{{ Request::query('location') }}" placeholder="City or postcode" id="location">
									<span class="icon flaticon-map-locator"></span>
								</div>
							</div>
		
							<!-- Filter Block -->
							<div class="filter-block">
								<h4>Category</h4>
								<div class="form-group">
									<input type="hidden" name="category" id="category" value="{{ Request::query('category') }}">
									<select class="chosen-select" onchange="handleSelectChange(event, 'category')" id="categoryResult">
										<option value="">Choose a category</option>
										@foreach ($categories as $category)
											<option value="{{ openssl_encrypt($category->id, "AES-128-ECB", "FP25Hg9KKNJx") }}">{{ $category->title }}</option>
										@endforeach
									</select>
									<span class="icon flaticon-briefcase"></span>
								</div>
							</div>
		
							<!-- Checkboxes Ouer -->
							{{-- <div class="checkbox-outer">
								<h4>Date Posted</h4>
								<ul class="checkboxes">
									<li>
										<input id="check-f" type="checkbox" name="check">
										<label for="check-f">All</label>
									</li>
									<li>
										<input id="check-a" type="checkbox" name="check">
										<label for="check-a">Last Hour</label>
									</li>
									<li>
										<input id="check-b" type="checkbox" name="check">
										<label for="check-b">Last 24 Hours</label>
									</li>
									<li>
										<input id="check-c" type="checkbox" name="check">
										<label for="check-c">Last 7 Days</label>
									</li>
									<li>
										<input id="check-d" type="checkbox" name="check">
										<label for="check-d">Last 14 Days</label>
									</li>
									<li>
										<input id="check-e" type="checkbox" name="check">
										<label for="check-e">Last 30 Days</label>
									</li>
								</ul>
							</div> --}}
						</div>
		
						<!-- Call To Action -->
						<div class="call-to-action-four">
							<h5>Recruiting?</h5>
							<p>Advertise your jobs to millions of monthly users and search 15.8 million profiles in our database.</p>
							<a href="{{ route('register', ['category' => 'employer']) }}" class="theme-btn btn-style-one bg-blue"><span class="btn-title">Start Recruiting Now</span></a>
							<div class="image" style="background-image: url({{ asset('assets/images/resource/ads-bg-4.png') }});"></div>
						</div>
						<!-- End Call To Action -->
					</div>
				</div>
	
				<!-- Content Column -->
				<div class="content-column col-lg-8 col-md-12 col-sm-12">
					<div class="ls-outer">
						<button type="button" class="theme-btn btn-style-two toggle-filters">Show Filters</button>
		
						<!-- ls Switcher -->
						<div class="ls-switcher">
							<div class="showing-result">
								<div class="text">Showing <strong>{{ $jobListings->firstItem() }} - {{ $jobListings->lastItem() }}</strong> of <strong>{{ $jobListings->total() }}</strong> jobs</div>
							</div>
							<div class="sort-by">
								<input type="hidden" name="filter" id="filter" value="{{ Request::query('filter') ?? 'all' }}" id="filter">
								<select class="chosen-select" onchange="handleSelectChange(event, 'filter')" id="filterResult">
									<option value="all">All</option>
									<option value="contract">Contract</option>
									<option value="full time">Fulltime</option>
									<option value="freelance">Freelance</option>
									<option value="internship">Internship</option>
									<option value="part time">Part time</option>
								</select>
								
								<input type="hidden" name="limit" id="limit" value="{{ Request::query('limit') ?? '10' }}" id="limit">
								<select class="chosen-select" onchange="handleSelectChange(event, 'limit')" id="limitResult">
									<option value="10">Show 10</option>
									<option value="20">Show 20</option>
									<option value="30">Show 30</option>
									<option value="40">Show 40</option>
									<option value="50">Show 50</option>
									<option value="60">Show 60</option>
								</select>
							</div>
						</div>

						@foreach ($jobListings as $job)
							<!-- Job Block -->
							<div class="job-block">
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
											<li class="required {{ Str::lower($job->priority) }}">{{ Str::ucfirst($job->priority) }}</li>
											<li class="green">{{ implode(' years, ', $job->experience) }} years</li>
											@if (in_array($job->status, ['closed', 'discarded']))
												<li class="closed">{{ Str::ucfirst($job->status) }}</li>
											@endif
										</ul>
									</div>
								</div>
							</div>
						@endforeach
		
						<!-- Listing Show More -->
						@if ($jobListings->hasPages())
							<div class="ls-show-more">
								<p>Showing {{ $jobListings->lastItem() }} of {{ $jobListings->total() }} Jobs</p>
								@if ($jobListings->total() > 0)
									<div class="bar"><span class="bar-inner" style="width: {{ number_format(($jobListings->lastItem() * 100) / $jobListings->total()) }}%"></span></div>
								@endif
							</div>
						@endif
						{{ $jobListings->links('pages.pagination') }}
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End Listing Page Section -->
@endsection
@section('script')
    <script>
		function handleSelectChange(event, type, pageId = null) {
			const { value } = event.target;
			const { origin, pathname, search } = window.location;

			const urlParams = new URLSearchParams(search); // For GET request
			if (type === 'category') {
				urlParams.append("category", value);
			} else if (type === 'filter') {
				urlParams.append("filter", value);
			} else if (type === 'limit') {
				urlParams.append("limit", value);
			} else if (type === 'title') {
				urlParams.append("title", value);
			} else if (type === 'location') {
				urlParams.append("location", value);
			} else if (type === 'page') {
				urlParams.append("page", pageId);
			} else {
				return;
			}

			if (type !== 'page') {
				urlParams.append("page", 1);
			}

			const urlQueryString = new URLSearchParams(Object.fromEntries(urlParams)).toString();
			window.location.href = `${origin}${pathname}?${urlQueryString}`;
		}

		function handlePagination(event, button) {
			let element = event.target;
			if (button === 'arrow') {
				element = event.target.parentElement;
			}
			const href = element.href;
			const pageUrl = href.split('?page=');
			const pageId = pageUrl[pageUrl.length - 1];
			handleSelectChange(event, 'page', pageId)
		}
		
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

		$('#title').keyup(delay(function (e) {
			handleSelectChange(e, 'title')
		}, 1000));

		$('#location').keyup(delay(function (e) {
			handleSelectChange(e, 'location')
		}, 1000));

        $(document).ready(function () {
			const categoyValueElement = document.getElementById("category").value;
			const filterValueElement = document.getElementById("filter").value;
			const limitValueElement = document.getElementById("limit").value;

            // set the values
            $("#categoryResult").val(categoyValueElement).trigger("chosen:updated");
            $("#filterResult").val(filterValueElement).trigger("chosen:updated");
            $("#limitResult").val(limitValueElement).trigger("chosen:updated");
        });
    </script>
@endsection