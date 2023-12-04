@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Manage Applied Jobs</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
  
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>My Applied Jobs</h4>
								<div class="chosen-outer">
									<!--Tabs Box-->
									<input type="hidden" value="{{ Request::query('status') ? Str::lower(Request::query('status')) : 'all' }}" id="statusValue">
									<select class="chosen-select" onchange="handleStatusChange(event)" id="statusResult">
										<option value="all">All</option>
										<option value="submitted">Submitted</option>
										<option value="under-review">Under review</option>
										<option value="accepted">Accepted</option>
										<option value="rejected">Rejected</option>
										<option value="withdrawn">Withdrawn</option>
									</select>
								</div>
							</div>
		
							<div class="widget-content">
								<div class="table-outer">
									<table class="default-table manage-job-table">
										<thead>
											<tr>
												<th>Job Title</th>
												<th>Date Applied</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@if ($jobApplications->count() === 0)
												<tr>
													<td colspan="5">
														No records found. Choose a different status or create a job listing.
													</td>
												</tr>
											@else
												@foreach ($jobApplications as $listing)
													<tr>
														<td>
															<!-- Job Block -->
															<div class="job-block">
															<div class="inner-box">
																<div class="content">
																<span class="company-logo"><img src="{{ $listing->jobListing->employer->userImage() ? asset($listing->jobListing->employer->userImage()) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
																<h4><a href="#">{{ $listing->jobListing->title }}</a></h4>
																<ul class="job-info">
																	<li><span class="icon flaticon-briefcase"></span> {{ Str::title($listing->jobListing->contract_type) }}</li>
																	<li><span class="icon flaticon-map-locator"></span> {{ $listing->jobListing->city }}, {{ $listing->jobListing->country }}</li>
																</ul>
																</div>
															</div>
															</div>
														</td>
														<td>{{ date('d F, Y',strtotime($listing->created_at)) }}</td>
														<td class="status {{ Str::lower($listing->status) }}">{{ Str::ucfirst($listing->status) }}</td>
														<td>
															<div class="option-box">
																<ul class="option-list">
																	<li>
																		<a href="{{ route('pages.jobs.detail', ['uniqueId' => $listing->jobListing->job_reference, 'titleSlug' => $listing->jobListing->title_slug ]) }}">
																			<button data-text="View Application"><span class="la la-external-link-alt"></span></button>
																		</a>
																	</li>
																	@if (!in_array($listing->status, ['withdrawn', 'accepted', 'rejected', 'under-review']))
																		<li><button onclick="event.preventDefault(); document.getElementById('withdraw-application-{{ $listing->id }}').submit();" data-text="Withdraw Application"><span class="la la-undo-alt"></span></button></li>
																		<form method="post" action="{{ route('dashboard.candidate.job.withdraw', ['applicationId' => $listing->id]) }}" id="withdraw-application-{{ $listing->id }}"  style="display: none;">
																			@csrf
																			@method('POST')
																			<button class="theme-btn btn-style-three" type="submit">Submit</button>
																		</form>
																	@endif
																</ul>
															</div>
														</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
									<div class="mb-3">
										{{ $jobApplications->links('pages.pagination') }}
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