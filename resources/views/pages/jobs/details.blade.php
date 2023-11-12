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
								@if (in_array($jobDetail->status, ['closed', 'discarded']) || $isExpired)
                                	<li class="closed">{{ $isExpired ? 'Expired' : Str::ucfirst($jobDetail->status) }}</li>
								@endif
                            </ul>
                        </div>
                        @if (!in_array($jobDetail->status, ['closed', 'discarded']) && !$isExpired && !Auth::guard('admin')->check() && (!Auth::check() || !Auth::user()->isEmployer()))
                            <div class="btn-box">
								@if (count($isApplied) > 0 && $jobApplication && $jobApplication->status !== 'withdrawn')
									@if ($jobApplication->status === 'submitted')
										<a href="#" onclick="event.preventDefault(); document.getElementById('withdraw-application').submit();" class="theme-btn btn-style-one withdraw">
											Withdraw Application
										</a>
										<form method="post" action="{{ route('dashboard.candidate.job.withdraw', ['applicationId' => $jobApplicationId]) }}" id="withdraw-application"  style="display: none;">
											@csrf
											@method('POST')
											<button class="theme-btn btn-style-three" type="submit">Submit</button>
										</form>
									@endif
								@else
									<a href="{{ route('pages.jobs.apply', ['uniqueId' => $jobDetail->job_reference]) }}" class="theme-btn btn-style-one">
										{{ $jobApplication && $jobApplication->status === 'withdrawn' ? 'Resubmit application' : 'Apply For Job' }}
									</a>
								@endif
								@if (Auth::check())
									@if ($isBookmarked)
										<a href="#" onclick="event.preventDefault(); document.getElementById('bookmark-remove').submit();">
											<button class="bookmark-btn remove" data-toggle="tooltip" data-placement="bottom" title="Remove Saved Job"><i class="flaticon-bookmark"></i></button>
										</a>
									@else
										<a href="#" onclick="event.preventDefault(); document.getElementById('bookmark-add').submit();">
											<button class="bookmark-btn" data-toggle="tooltip" data-placement="bottom" title="Save Job for Later"><i class="flaticon-bookmark"></i></button>
										</a>
									@endif
									<form method="post" action="{{ route('dashboard.candidate.bookmark.add', ['jobId' => $jobDetail->id]) }}" id="bookmark-add"  style="display: none;">
										@csrf
										@method('POST')
										<button class="theme-btn btn-style-three" type="submit" name="bookmark-add">Submit</button>
									</form>
									<form method="post" action="{{ route('dashboard.candidate.bookmark.remove', ['jobId' => $jobDetail->id]) }}" id="bookmark-remove"  style="display: none;">
										@csrf
										@method('POST')
										<button class="theme-btn btn-style-three" type="submit" name="bookmark-remove">Submit</button>
									</form>
								@endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
  
        <div class="job-detail-outer">
          <div class="auto-container">
            <div class="row">
              <div class="content-column col-lg-8 col-md-12 col-sm-12">
				@if ($isApplied->count() > 0)
					@if ($isApplied->first()->status === 'under-review')
						<div class="message-box info">
							<p class="m-0">You are likely to hear from {{ $employer->name }} on this job listing soonest.</p>
						</div>
					@endif
					@if ($isApplied->first()->status === 'rejected')
						<div class="message-box error">
							<p class="m-0">Sorry, your application to {{ $employer->name }} on this job listing has been rejected.</p>
						</div>
					@endif
					@if ($isApplied->first()->status === 'accepted')
						<div class="message-box success">
							<p class="m-0">Congratulations 🎉, your application to {{ $employer->name }} for this job listing was accepted.</p>
						</div>
					@endif
				@endif
                <div class="job-detail">
                  {!! $jobDetail->description !!}
                </div>
  
                @if (!Auth::check() || !Auth::user()->isEmployer())
					<!-- Related Jobs -->
					<div class="related-jobs mt-5">
						<div class="title-box">
						  <h3>Featured Jobs</h3>
						</div>
						@if ($relatedJobs->count() === 0)
							Featured jobs not available at the moment.
						@else
							@foreach ($relatedJobs as $job)
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
												<li class="required">{{ Str::ucfirst($job->priority) }}</li>
												@if (in_array($job->status, ['closed', 'discarded']))
													<li class="closed">{{ Str::ucfirst($job->status) }}</li>
												@endif
											</ul>
										</div>
									</div>
								</div>
							@endforeach
						@endif
					</div>
				@endif
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
  
                  <div class="sidebar-widget company-widget">
                    <div class="widget-content">
						<div class="company-title">
							<div class="company-logo"><img src="{{ $employer->userImage() ? asset($employer->userImage()) : asset('assets/images/resource/company-7.png') }}" alt=""></div>
							<h5 class="company-name">{{ $employer->name }}</h5>
							<a href="{{ route('pages.recruiter.detail', ['uniqueId' => $employerInfo->unique_id, 'name' => $employer->name]) }}" class="profile-link">View company profile</a>
						</div>
  
						<ul class="company-info">
							@if ($employerInfo->industry)
								<li>Primary industry: <span>{{ $employerInfo->industry[0] }}</span></li>
							@endif
							<li>Company size: <span>{{ $employerInfo->company_size }}</span></li>
							<li>Founded in: <span>{{ $employerInfo->founded }}</span></li>
							<li>Phone: <span>{{ $employerInfo->phone }}</span></li>
							<li>Email: <span>{{ $employer->email }}</span></li>
							<li>Location: <span>{{ $employerInfo->city }}, {{ $employerInfo->country }}</span></li>
							<li>Social media:
								<div class="social-links">
									<a href="{{ $employerInfo->fb_link ? $employerInfo->fb_link : '#' }}" @if ($employerInfo->fb_link) target="_blank" @endif><i class="fab fa-facebook-f"></i></a>
									<a href="{{ $employerInfo->tw_link ? $employerInfo->tw_link : '#' }}" @if ($employerInfo->tw_link) target="_blank" @endif><i class="fab fa-twitter"></i></a>
									<a href="{{ $employerInfo->in_link ? $employerInfo->in_link : '#' }}" @if ($employerInfo->in_link) target="_blank" @endif><i class="fab fa-instagram"></i></a>
									<a href="{{ $employerInfo->linkedin_link ? $employerInfo->linkedin_link : '#' }}" @if ($employerInfo->linkedin_link) target="_blank" @endif><i class="fab fa-linkedin-in"></i></a>
								</div>
							</li>
						</ul>
	
						<div class="btn-box"><a href="{{ $employerInfo->website }}" target="_blank"  class="theme-btn btn-style-three">{{ Str::substr($employerInfo->website, 0, 35) . '...' }}</a></div>
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