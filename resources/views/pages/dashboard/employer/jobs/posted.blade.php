@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Posted Jobs</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
	
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>My Posted Jobs</h4>
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
											<th>Created & Expired</th>
										</tr>
									</thead>
									<tbody>
										@if ($jobListings->count() === 0)
											<tr>
												<td colspan="5">
													No records found.
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
													<td>{{ date('d F,Y',strtotime($listing->created_at)) }} <br>{{ date('d F,Y',strtotime($listing->expiry_date)) }}</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
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
        $(document).ready(function () {});
    </script>
@endsection