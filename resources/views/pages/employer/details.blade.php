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
                            <span class="company-logo"><img src="{{ $employerDetails->image ? asset($employerDetails->image) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
                            <h4><a href="#">{{ $employerDetails->employer->name }}</a></h4>
                            <ul class="job-info">
                                <li><span class="icon flaticon-map-locator"></span> {{ $employerDetails->city }}, {{ $employerDetails->country }}</li>
                                <li><span class="icon flaticon-briefcase"></span> Accounting / Finance</li>
                                <li><span class="icon flaticon-telephone-1"></span> {{ $employerDetails->phone }}</li>
                                <li><span class="icon flaticon-mail"></span> {{ $employerDetails->employer->email }}</li>
                            </ul>
                            <ul class="job-other-info">
                                <li class="time">Open Jobs – {{ $openJobsCount }}</li>
                            </ul>
                        </div>
                        @if (Auth::check() && Auth::user()->isEmployer())
                            <div class="btn-box">
                                <a href="{{ route('dashboard.employer.job.manage') }}" class="theme-btn btn-style-one">View more jobs</a>
                            </div>
                        @endif
                        @if (Auth::guard('admin')->check() && Auth::guard('admin')->user())
                            <div class="btn-box">
                                @if (in_array($employerDetails->approval, ['unverified', 'rejected']))
                                    <a href="{{ route('employer.verification.update', ['employerId' => $employerDetails->unique_id, 'status' => 'verified']) }}" class="theme-btn btn-style-four admin-approve-btn px-2">Approve Profile</a>
                                @endif
                                @if (in_array($employerDetails->approval, ['unverified', 'verified']))
                                    <a href="{{ route('employer.verification.update', ['employerId' => $employerDetails->unique_id, 'status' => 'rejected']) }}" class="theme-btn btn-style-two admin-approve-btn danger">Reject Profile</a>
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
                        <div class="job-detail">
                            <h4>About Company</h4>
                            {!! $employerDetails->description !!}
                            <p></p>
                        </div>
        
                        <!-- Related Jobs -->
                        <div class="related-jobs">
                            <div class="title-box">
                                <h3>Recent jobs at {{ $employerDetails->employer->name}}</h3>
                            </div>
                            @if ($recentJobs->count() === 0)
                                No jobs posted yet.
                            @else
                                @foreach ($recentJobs as $job)
                                    <!-- Job Block -->
                                    <div class="job-block">
                                        <div class="inner-box">
                                            <div class="content">
                                                <span class="company-logo"><img src="{{ $employerDetails->image ? asset($employerDetails->image) : asset('assets/images/resource/company-logo/5-1.png') }}" alt=""></span>
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
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
    
                    <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                        <aside class="sidebar">
                            @if (Auth::guard('admin')->check() && Auth::guard('admin')->user())
                                <div class="btn-box">
                                    <a href="{{ $employerDetails->document ? asset($employerDetails->document) : '#' }}" class="theme-btn btn-style-one" @if ($employerDetails->document) target="_blank" @else data-toggle="tooltip" data-placement="bottom" title="No Document Uploaded yet" disabled @endif>Download Attachment</a>
                                </div>
                            @endif
                            <div class="sidebar-widget company-widget">
                                <div class="widget-content">
                                    <ul class="company-info mt-0">
                                        @if ($employerDetails->industry)
                                            <li>Primary industry: <span>{{ $employerDetails->industry[0] }}</span></li>
                                        @endif
                                        <li>Company size: <span>{{ $employerDetails->company_size }}</span></li>
                                        <li>Founded in: <span>{{ $employerDetails->founded }}</span></li>
                                        <li>Phone: <span>{{ $employerDetails->phone }}</span></li>
                                        <li>Email: <span>{{ $employerDetails->employer->email }}</span></li>
                                        <li>Location: <span>{{ $employerDetails->city }}, {{ $employerDetails->country }}</span></li>
                                        <li>Social media:
                                            <div class="social-links">
                                                <a href="{{ $employerDetails->fb_link ? $employerDetails->fb_link : '#' }}" @if ($employerDetails->fb_link) target="_blank" @endif><i class="fab fa-facebook-f"></i></a>
                                                <a href="{{ $employerDetails->tw_link ? $employerDetails->tw_link : '#' }}" @if ($employerDetails->tw_link) target="_blank" @endif><i class="fab fa-twitter"></i></a>
                                                <a href="{{ $employerDetails->in_link ? $employerDetails->in_link : '#' }}" @if ($employerDetails->in_link) target="_blank" @endif><i class="fab fa-instagram"></i></a>
                                                <a href="{{ $employerDetails->linkedin_link ? $employerDetails->linkedin_link : '#' }}" @if ($employerDetails->linkedin_link) target="_blank" @endif><i class="fab fa-linkedin-in"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="btn-box"><a href="{{ $employerDetails->website }}" target="_blank" class="theme-btn btn-style-three">{{ $employerDetails->website }}</a></div>
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