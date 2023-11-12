@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Job Listings</h3>
			</div>
  
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>Job Listings</h4>
                                <div class="chosen-outer">
                                    <!--Tabs Box-->
                                    <div class="search-box-one">
                                        <div class="form-group">
                                            <span class="icon flaticon-search-1"></span>
                                            <input type="search" name="title" value="{{ Request::query('title') }}" placeholder="Search" required="" id="title">
                                        </div>
                                    </div>
									<input type="hidden" value="{{ Request::query('status') ? Request::query('status') : 'all' }}" id="statusValue">
									<select class="chosen-select" onchange="handleSelectChange(event, 'status')" id="statusResult">
										<option value="all">All</option>
										<option value="draft">Draft</option>
										<option value="open">Open</option>
										<option value="closed">Closed</option>
										<option value="expired">Expired</option>
									</select>
								</div>
							</div>

                            <div class="widget-content">
                                <div class="table-outer">
                                    <table class="default-table manage-job-table">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Contract type</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($joblistings->count() === 0)
												<tr>
													<td colspan="5">
														No records found.
													</td>
												</tr>
											@else
                                                @foreach ($joblistings as $listing)
                                                    <tr>
                                                        <td>
                                                            {{ $listing->title }}
                                                        </td>
                                                        <td>{{ $listing->category->title }}</td>
                                                        <td>
                                                            {{ Str::title($listing->contract_type) }}
                                                        </td>
                                                        <td>{{ $listing->city }}, {{ $listing->country }}</td>
                                                        <td>
                                                            @if ($listing->status === 'open')
                                                                <span class="label label-success">Open</span>
                                                            @elseif (in_array($listing->status, ['closed', 'expired']))
                                                                <span class="label label-danger">{{ Str::title($listing->status) }}</span>
                                                            @else
                                                                <span class="label label-info">{{ Str::title($listing->status) }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('pages.jobs.detail', ['uniqueId' => $listing->job_reference, 'titleSlug' => $listing->title_slug ]) }}">
                                                                <button data-text="View listing"><span class="la la-external-link-alt"></span></button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="mb-3">
                                        {{ $joblistings->links('pages.pagination') }}
									</div>
                                    <!-- Listing Show More -->
                                    @if ($joblistings->hasPages())
                                        <div class="ls-show-more mt-0">
                                            <p>Showing {{ number_format($joblistings->lastItem()) }} of {{ number_format($joblistings->total()) }} Job listings</p>
                                        </div>
                                    @endif
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
        $('#title').keyup(delay(function (e) {
			handleSelectChange(e, 'title')
		}, 1000));
        $(document).ready(function () {
			const statusValueElement = document.getElementById("statusValue").value;

			// set the value
			$("#statusResult").val(statusValueElement).trigger("chosen:updated");
        });
    </script>
@endsection