@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Feedback</h3>
			</div>
  
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>Submitted Feedback</h4>
                                <div class="chosen-outer">
									<!--Tabs Box-->
									<input type="hidden" value="{{ Request::query('rating') ? Str::ucfirst(Request::query('rating')) : 'all' }}" id="ratingValue">
									<select class="chosen-select" onchange="handleRatingChange(event)" id="ratingResult">
										<option value="all">All</option>
										<option value="1">1 star rating</option>
										<option value="2">2 star rating</option>
										<option value="3">3 star rating</option>
										<option value="4">4 star rating</option>
										<option value="5">5 star rating</option>
									</select>
								</div>
							</div>

                            <div class="widget-content">
                                <div class="table-outer">
                                    <table class="default-table manage-job-table">
                                        <thead>
                                            <tr>
                                                <th>Job Title</th>
                                                <th>Jobseeker</th>
                                                <th>Rating</th>
                                                <th>Message</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($feedbacks->count() === 0)
												<tr>
													<td colspan="5">
														No records found.
													</td>
												</tr>
											@else
                                                @foreach ($feedbacks as $feedback)
                                                    <tr>
                                                        <td>
                                                            {{ $feedback->jobListing->title }}
                                                            <a href="{{ route('pages.jobs.detail', ['uniqueId' => $feedback->jobListing->job_reference, 'titleSlug' => $feedback->jobListing->title_slug ]) }}">
                                                                <button data-text="View Listing"><span class="la la-external-link-alt"></span></button>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $feedback->candidate->name }}
                                                            <a href="{{ route('pages.candidate.detail', ['uniqueId' => $feedback->candidate->candidateInfo->unique_id ]) }}">
                                                                <button data-text="View Jobseeker"><span class="la la-external-link-alt"></span></button>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {!! str_repeat('<span><i class="las la-star gold small"></i></span>', $feedback->rating) !!}
                                                        </td>
                                                        <td>{!! $feedback->message !!}</td>
                                                        <td>
                                                            <a href="#" 
                                                                onclick="handleUserFeedbackDelete(event, '{{ openssl_encrypt($feedback->id, 'AES-128-ECB', 'FP25Hg9KKNJx') }}')"
                                                            >
                                                                <i class="la la-trash colored"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <form method="POST" action="{{ route('dashboard.admin.feedbacks.delete') }}" id="delete-feedback" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="feedbackId" id="feedbackId" value="">
                                        <button class="theme-btn btn-style-three" type="submit">Submit</button>
                                    </form>
                                    <div class="mb-3">
										{{ $feedbacks->links('pages.pagination') }}
									</div>
                                    <!-- Listing Show More -->
                                    @if ($feedbacks->hasPages())
                                        <div class="ls-show-more mt-0">
                                            <p>Showing {{ number_format($feedbacks->lastItem()) }} of {{ number_format($feedbacks->total()) }} Feedbacks</p>
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
        function handleRatingChange(event) {
			const { value } = event.target;
			const { origin, pathname, search } = window.location;

			const urlParams = new URLSearchParams(search); // For GET request
			urlParams.append("rating", value);
			urlParams.append("page", 1);

			const urlQueryString = new URLSearchParams(Object.fromEntries(urlParams)).toString();
			window.location.href = `${origin}${pathname}?${urlQueryString}`;
		}
        function handleUserFeedbackDelete (event, feedbackId) {
            event.preventDefault();
            document.getElementById('feedbackId').value = feedbackId;
            if (confirm("Are you sure you want to proceed?")) {
                document.getElementById('delete-feedback').submit();
            }
        }
        $(document).ready(function () {
			const ratingValueElement = document.getElementById("ratingValue").value;

			// set the value
			$("#ratingResult").val(ratingValueElement).trigger("chosen:updated");
			
        });
    </script>
@endsection