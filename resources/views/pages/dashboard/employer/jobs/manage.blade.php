@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Manage Jobs</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
	
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>My Job Listings</h4>
			
								<div class="chosen-outer">
									<!--Tabs Box-->
									<input type="hidden" value="{{ Request::query('status') ? Str::ucfirst(Request::query('status')) : 'All' }}" id="statusValue">
									<select class="chosen-select" onchange="handleStatusChange(event)" id="statusResult">
										<option>All</option>
										<option>Draft</option>
										<option>Open</option>
										<option>Closed</option>
										<option>Discarded</option>
										<option>Expired</option>
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
											<th>Title</th>
											<th>Applications</th>
											<th>Created & Expired</th>
											<th>Views</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if ($jobListings->count() === 0)
											<tr>
												<td colspan="5">
													No records found. Choose a different status or create a job listing.
												</td>
											</tr>
										@else
											@foreach ($jobListings as $listing)
												<tr>
													<td>
														<h6>{{ $listing->title }} ({{ Str::title($listing->contract_type) }})</h6>
														<span class="info"><i class="icon flaticon-briefcase"></i> {{ $listing->category->title }}</span>
														<span class="info"><i class="icon flaticon-map-locator"></i> {{ $listing->city}}, {{ $listing->country }}</span>
													</td>
													<td class="applied"><a href="{{ $listing->jobApplications->count() > 0 ? route('dashboard.employer.job.manage.applicant', ['jobReference' => $listing->job_reference]) : '#' }}">{{ $listing->jobApplications->count() }} Applied</a></td>
													<td>{{ date('d F,Y',strtotime($listing->created_at)) }} <br>{{ date('d F,Y',strtotime($listing->expiry_date)) }}</td>
													<td>{{ number_format($listing->views) }}</td>
													<td class="status {{ Str::lower($listing->status) }}">
														{{ Str::ucfirst($listing->status) }}
													</td>
													<td>
														<div class="option-box">
															<ul class="option-list">
																<li>
																	<a href="{{ route('pages.jobs.detail', ['uniqueId' => $listing->job_reference, 'titleSlug' => $listing->title_slug ]) }}">
																		<button data-text="View Job"><span class="la la-external-link-alt"></span></button>
																	</a>
																</li>
																@if (!in_array($listing->status, ['discarded']))
																	<li>
																		<a href="{{ route('dashboard.employer.job.index', ['edit' => $listing->job_reference ]) }}">
																			<button data-text="Edit Job"><span class="la la-pencil"></span></button>
																		</a>
																	</li>
																@endif
																<li>
																	<a href="#"
																		onclick="handleJobListingDelete(event, '{{ openssl_encrypt($listing->id, 'AES-128-ECB', 'FP25Hg9KKNJx') }}')"
																	>
																		<button data-text="Delete Job Listing"><span class="la la-trash"></span></button>
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
								<form method="POST" action="{{ route('dashboard.employer.job.delete') }}" id="delete-job-listing" style="display: none;">
									@csrf
									@method('DELETE')
									<input type="hidden" name="listingId" id="listingId" value="">
									<button class="theme-btn btn-style-three" type="submit">Submit</button>
								</form>
								<div class="mb-3">
									{{ $jobListings->links('pages.pagination') }}
								</div>
								<!-- Listing Show More -->
								@if ($jobListings->hasPages())
									<div class="ls-show-more mt-0">
										<p>Showing {{ number_format($jobListings->lastItem()) }} of {{ number_format($jobListings->total()) }} Job Listings</p>
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
		function handleJobListingDelete (event, listingId) {
            event.preventDefault();
            document.getElementById('listingId').value = listingId;
            if (confirm("Are you sure you want to proceed? This action cannot be undone")) {
                document.getElementById('delete-job-listing').submit();
            }
        }
        $(document).ready(function () {
			const statusValueElement = document.getElementById("statusValue").value;

			// set the value
			$("#statusResult").val(statusValueElement).trigger("chosen:updated");
			
        });
    </script>
@endsection