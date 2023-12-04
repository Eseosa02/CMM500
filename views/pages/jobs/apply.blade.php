@extends('layouts.app')
@section('content')
    <!-- Job Detail Section -->
    <section class="job-detail-section">
        <!-- Upper Box -->
        <div class="upper-box">
            <div class="auto-container">
                <div class="job-block-seven">
                    <div class="inner-box">
                        <div class="content">
                            <span class="company-logo"><img src="{{ $employer->userImage() ? asset($employer->userImage()) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
                            <h4><a href="#">{{ $jobDetail->title }}</a></h4>
                            <ul class="job-info">
                                <li><span class="icon flaticon-briefcase"></span> {{ $jobDetail->category->title }}</li>
                                <li><span class="icon flaticon-map-locator"></span> {{ $jobDetail->city }}, {{ $jobDetail->country }}</li>
                                <li><span class="icon flaticon-clock-3"></span> {{ $jobDetail->created_at->diffForHumans() }}</li>
                                <li><span class="icon flaticon-money"></span> {{ $jobDetail->salary }}</li>
                            </ul>
                            <ul class="job-other-info">
                                <li class="time">{{ Str::title($jobDetail->contract_type) }}</li>
                                <li class="required">{{ Str::ucfirst($jobDetail->priority) }}</li>
								@if (in_array($jobDetail->status, ['closed', 'discarded']))
                                	<li class="closed">{{ Str::ucfirst($jobDetail->status) }}</li>
								@endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  
        <div class="job-detail-outer">
			<div class="auto-container">
				<div class="row">
					<div class="content-column col-lg-8 col-md-12 col-sm-12">
						<div class="job-detail">
							@if ($errors->count() > 0)
								<div class="message-box error">
									<p class="m-0">{{ $errors->first() }}</p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							@if (!Auth::check())
								<div class="message-box info">
									<p class="m-0">You must <a href="{{ route('login', ['jobId' => $jobDetail->job_reference]) }}">login</a> or <a href="{{ route('register') }}">register</a> to apply for a job.</p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							@if (Auth::check() && Auth::user()->isComplete == 0)
								<div class="message-box info">
									<p class="m-0">Complete your <a href="{{ route('dashboard.candidate.profile.index') }}">profile</a> to apply for a job.</p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							@if (Auth::check() && (Auth::user()->isComplete >= 60 && Auth::user()->isComplete < 90))
								<div class="message-box info">
									<p class="m-0">Complete your <a href="{{ route('dashboard.candidate.profile.index') }}">"My Resume"</a> to boost your profile up to 90% to enable job application.</p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							@if (Auth::check() && Auth::user()->isComplete == 90)
								<div class="message-box info">
									<p class="m-0">Upload at least one CV on <a href="{{ route('dashboard.candidate.profile.index') }}">"CV Manager"</a> to complete your profile to enable application.</p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							@if (Auth::check() && $isApplied && $jobApplication && $jobApplication->status !== 'withdrawn' && !\Session::has('message'))
								<div class="message-box info">
									<p class="m-0">You have submitted an application already. View appplication <a href="{{ route('dashboard.candidate.job.manage') }}">status</a></p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							@if (\Session::has('message'))
								<div class="message-box success">
									<p class="m-0">{!! \Session::get('message') !!}</p>
									<button class="close-btn"><span class="close_icon"></span></button>
								</div>
							@endif
							@if (Auth::check() && (!$isApplied || $isApplied && $jobApplication && $jobApplication->status == 'withdrawn'))
								<form class="default-form" action="{{ route('dashboard.candidate.job.apply') }}" method="post">
									@csrf
									@method('POST')
									<div class="form-group col-lg-12 col-md-12">
										<label>My CVs <span class="required">*</span></label>
										<input type="hidden" value="{{ $defaultCVId ? $defaultCVId->id : old('cv_id') }}" id="cv">
										<select class="chosen-select" name="cv_id" id="cvResult">
											@foreach ($candidateCvs as $cv)
												<option value="{{ $cv->id }}">{{ $cv->title }} {{ $defaultCVId && ($defaultCVId->id == $cv->id) ? '(Default)' : '' }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-lg-12 col-md-12">
										<label>Message (Optional)</label>
										<textarea name="message" placeholder="">{{ old('message') }}</textarea>
									</div>
									<input type="hidden" name="job_listing_id" value="{{ $jobDetail->id }}">
									@if (Auth::check())
										<!-- Input -->
										<div class="form-group col-lg-12 col-md-12 text-right">
											<button class="theme-btn btn-style-four" name="submit" @if (in_array($jobDetail->status, ['closed', 'discarded']) || ($isApplied && $jobApplication && $jobApplication->status !== 'withdrawn') || Auth::user()->isComplete != 100) disabled @endif>Submit Application</button>
										</div>
									@endif
								</form>
							@endif
							@if (Auth::check() && $isApplied && \Session::has('message') && !$hasFeedback)
								<div class="title-box">
									<h4>Submit Feedback</h4>
								</div>
								<form class="default-form" action="{{ route('dashboard.candidate.job.feedback') }}" method="post">
									@csrf
									@method('POST')
									<div class="form-group col-lg-12 col-md-12">
										<input type="hidden" id="rating" name="rating" value="0">
										<label>Rating <span class="required">*</span></label>
										<div class="rating">
											<span class="star" data-value="1">★</span>
											<span class="star" data-value="2">★</span>
											<span class="star" data-value="3">★</span>
											<span class="star" data-value="4">★</span>
											<span class="star" data-value="5">★</span>
										</div>
									</div>
									<div class="form-group col-lg-12 col-md-12">
										<label>Message (Optional)</label>
										<textarea name="message" placeholder="" rows="5">{{ old('message') }}</textarea>
									</div>
									<input type="hidden" name="job_listing_id" value="{{ $jobDetail->id }}">
									@if (Auth::check())
										<!-- Input -->
										<div class="form-group col-lg-12 col-md-12 text-right">
											<button class="theme-btn btn-style-four" name="submit" id="feedbackBtn" disabled>Send Feedback</button>
										</div>
									@endif
								</form>
							@endif
						</div>
					</div>
	
					<div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
						<aside class="sidebar">
							<div class="sidebar-widget">
								<!-- Job Overview -->
								<h4 class="widget-title">Job Overview</h4>
								<div class="widget-content">
									<ul class="job-overview">
										<li>
											<i class="icon icon-calendar"></i>
											<h5>Date Posted:</h5>
											<span>Posted {{ $jobDetail->created_at->diffForHumans() }}</span>
										</li>
										@if ($jobDetail->expiry_date)
											<li>
												<i class="icon icon-expiry"></i>
												<h5>Expiration date:</h5>
												<span>{{ date('d F,Y',strtotime($jobDetail->expiry_date)) }}</span>
											</li>
										@endif
										<li>
											<i class="icon icon-location"></i>
											<h5>Location:</h5>
											<span>{{ $jobDetail->city }}, {{ $jobDetail->country }}</span>
										</li>
										<li>
											<i class="icon icon-user-2"></i>
											<h5>Job Title:</h5>
											<span>{{ $jobDetail->skills[0] }}</span>
										</li>
										@if ($jobDetail->hours)
											<li>
												<i class="icon icon-clock"></i>
												<h5>Hours:</h5>
												<span>{{ $jobDetail->hours }}h / week</span>
											</li>
										@endif
										@if ($jobDetail->salary)
											<li>
												<i class="icon icon-salary"></i>
												<h5>Salary:</h5>
												<span>{{ $jobDetail->salary }}</span>
											</li>
										@endif
										<li>
											<i class="icon icon-salary"></i>
											<h5>Views:</h5>
											<span>{{ $jobDetail->views > 1000 ? number_format($jobDetail->views/1000, 1) . 'k' : $jobDetail->views }}</span>
										</li>
									</ul>
								</div>
			
								<!-- Job Skills -->
								<h4 class="widget-title">Job Skills</h4>
								<div class="widget-content">
									<ul class="job-skills">
										@foreach ($jobDetail->skills as $skill)
											<li><a href="#">{{ Str::lower($skill) }}</a></li>
										@endforeach
									</ul>
								</div>
							</div>
						</aside>
					</div>
				</div>
			</div>
        </div>
    </section>
    <!-- End Job Detail Section -->
@endsection
@section('script')
    <script>
		const stars = document.querySelectorAll(".star");
		const ratingValue = document.getElementById("rating");
		const feedbackBtn = document.getElementById("feedbackBtn");
		let currentRating = 0;

		stars.forEach((star) => {
			star.addEventListener("click", () => {
				const value = parseInt(star.getAttribute("data-value"));
				currentRating = value;
				updateRating();
			});

			star.addEventListener("mouseover", () => {
				const value = parseInt(star.getAttribute("data-value"));
				highlightStars(value);
			});

			star.addEventListener("mouseout", () => {
				highlightStars(currentRating);
			});
		});

		function highlightStars(value) {
			stars.forEach((star) => {
				const starValue = parseInt(star.getAttribute("data-value"));
				if (starValue <= value) {
					star.classList.add("selected");
				} else {
					star.classList.remove("selected");
				}
			});
		}

		function updateRating() {
			ratingValue.value = `${currentRating}`;
			if (currentRating > 0) {
				feedbackBtn.removeAttribute('disabled');
			} else {
				feedbackBtn.disabled = true;
			}
		}

        $(document).ready(function () {
			const cvValueElement = document.getElementById("cv").value;

            // set the values
            $("#cvResult").val(cvValueElement).trigger("chosen:updated");
        });
    </script>
@endsection