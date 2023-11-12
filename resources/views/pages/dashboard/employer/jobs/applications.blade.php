@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Manage Applications</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
	
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>Manage Applications</h4>
			
								<div class="chosen-outer">
									<!--Tabs Box-->
									<input type="hidden" value="{{ Request::query('status') ? Request::query('status') : 'all' }}" id="statusValue">
									<select class="chosen-select" onchange="handleStatusChange(event)" id="statusResult">
										<option value="all">All</option>
										<option value="submitted">Submitted</option>
										<option value="under-review">Under Review</option>
										<option value="accepted">Accepted</option>
										<option value="rejected">Rejected</option>
										<option value="withdrawn">Withdrawn</option>
									</select>
								</div>
							</div>
		
						<div class="widget-content">
							@if (\Session::has('message'))
								<div class="message-box success">
									<p class="m-0">{!! \Session::get('message') !!}</p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							<div class="table-outer">
								<table class="default-table manage-job-table">
									<thead>
										<tr>
											<th>Job Title</th>
											<th>Jobseeker</th>
											<th>CV</th>
											<th>Status</th>
											<th>Date Submitted</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if ($jobsPostedApplications->count() === 0)
											<tr>
												<td colspan="5">
													No records found. Choose a different status or create a job listing.
												</td>
											</tr>
										@else
											@foreach ($jobsPostedApplications as $application)
												<tr>
													<td>
														<h6>{{ $application->jobListing->title }}</h6>
													</td>
													<td>{{ $application->user->name }}</td>
													<td>
														@if ($application->candidateCV)
															@if ($application->candidateCV->attachment)
																<a href="{{ asset($application->candidateCV->attachment) }}" target="_blank">
																	{{ $application->candidateCV->title }}
																	<button data-text="View jobseeker CV"><span class="la la-external-link-alt"></span></button>
																</a>
															@else
																{{ $application->candidateCV->title }}
															@endif
														@else
															No CV attached
														@endif
                                                    </td>
													<td class="status {{ Str::lower($application->status) }}">
														{{ Str::ucfirst($application->status) }}
													</td>
                                                    <td>{{ date('d M,Y',strtotime($application->created_at)) }}</td>
													<td>
														<div class="option-box">
															<ul class="option-list">
																<li>
																	<a href="{{ route('dashboard.employer.job.manage.applicant', ['jobReference' => $application->jobListing->job_reference]) }}">
																		<button data-text="View Applications"><span class="la la-eye"></span></button>
																	</a>
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
									{{ $jobsPostedApplications->links('pages.pagination') }}
								</div>
								<!-- Listing Show More -->
								@if ($jobsPostedApplications->hasPages())
									<div class="ls-show-more mt-0">
										<p>Showing {{ number_format($jobsPostedApplications->lastItem()) }} of {{ number_format($jobsPostedApplications->total()) }} Job Applications</p>
									</div>
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