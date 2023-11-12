@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Manage Saved Jobs</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
  
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>My Saved Jobs</h4>
							</div>
		
							<div class="widget-content">
								<div class="table-outer">
									<table class="default-table manage-job-table">
										<thead>
											<tr>
												<th>Job Title</th>
												<th>Job Posted</th>
												<th>Job Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if ($savedJobs->count() === 0)
												<tr>
													<td colspan="5">
														No records found.
													</td>
												</tr>
											@else
												@foreach ($savedJobs as $job)
													<tr>
														<td>
															<!-- Job Block -->
															<div class="job-block">
																<div class="inner-box">
																	<div class="content">
																		<span class="company-logo"><img src="{{ $job->jobListing->employer->userImage() ? asset($job->jobListing->employer->userImage()) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
																		<h4><a href="#">{{ $job->jobListing->title }}</a></h4>
																		<ul class="job-info">
																			<li><span class="icon flaticon-briefcase"></span> {{ Str::title($job->jobListing->contract_type) }}</li>
																			<li><span class="icon flaticon-map-locator"></span> {{ $job->jobListing->city }}, {{ $job->jobListing->country }}</li>
																		</ul>
																	</div>
																</div>
															</div>
														</td>
														<td>{{ date('d F, Y',strtotime($job->jobListing->created_at)) }}</td>
														<td class="status {{ Str::lower($job->jobListing->status) }}">{{ Str::ucfirst($job->jobListing->status) }}</td>
														<td>
															<div class="option-box">
																<ul class="option-list">
																	<li>
																		<a href="{{ route('pages.jobs.detail', ['uniqueId' => $job->jobListing->job_reference, 'titleSlug' => $job->jobListing->title_slug ]) }}">
																			<button data-text="View Job listing"><span class="la la-external-link-alt"></span></button>
																		</a>
																	</li>
																	<li>
																		<a href="#" onclick="event.preventDefault(); document.getElementById('bookmark-remove-{{ $job->job_listing_id }}').submit();">
																			<button class="bookmark-btn remove" data-text="Remove Saved Job"><i class="flaticon-bookmark"></i></button>
																		</a>
																		<form method="post" action="{{ route('dashboard.candidate.bookmark.remove', ['jobId' => $job->job_listing_id]) }}" id="bookmark-remove-{{ $job->job_listing_id }}"  style="display: none;">
																			@csrf
																			@method('POST')
																			<button class="theme-btn btn-style-three" type="submit" name="bookmark-remove">Submit</button>
																		</form>
																	</li>
																</ul>
															</div>
														</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
									<div class="mb-3">
										{{ $savedJobs->links('pages.pagination') }}
									</div>
								</div>
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
        $('#name').keyup(delay(function (e) {
			handleSelectChange(e, 'name')
		}, 1000));
		function handleStatusChange(event) {
			const { value } = event.target;
			const { origin, pathname, search } = window.location;

			const urlParams = new URLSearchParams(search); // For GET request
			urlParams.append("status", value);

			const urlQueryString = new URLSearchParams(Object.fromEntries(urlParams)).toString();
			window.location.href = `${origin}${pathname}?${urlQueryString}`;
		}
        $(document).ready(function () {
			const statusValueElement = document.getElementById("statusValue").value;

			// set the value
			$("#statusResult").val(statusValueElement).trigger("chosen:updated");
			
        });
    </script>
@endsection