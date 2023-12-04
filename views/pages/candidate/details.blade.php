@extends('layouts.app')
@section('content')
    <!-- Candidate Detail Section -->
    <section class="candidate-detail-section">
        <div class="candidate-detail-outer">
            <div class="auto-container">
                <div class="row">
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        <!-- Candidate block Five -->
                        <div class="candidate-block-five">
                            <div class="inner-box">
                                <div class="content">
                                    <figure class="image"><img src="{{ $candidateInfo->image ? asset($candidateInfo->image) : asset('assets/images/resource/candidate-4.png') }}" alt=""></figure>
                                    <h4 class="name"><a href="#">{{ $candidate->name }}</a></h4>
                                    <ul class="candidate-info">
                                        <li class="designation">{{ $candidateInfo->title }}</li>
                                        <li><span class="icon flaticon-map-locator"></span> {{ $candidateInfo->city }}, {{ $candidateInfo->country }}</li>
                                        <li><span class="icon flaticon-clock"></span> Member Since, {{ $candidate->created_at->format('M d, Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="job-detail">
                            <h4>Candidates About</h4>
                            {!! $candidateInfo->description !!}

                            @if ($jobApplication && $jobApplication->message)
                                <!-- Message to Recruiter -->
                                <div class="resume-outer theme-blue">
                                    <div class="upper-title">
                                        <h4>Message to Recruiter</h4>
                                    </div>
                                    {!! $jobApplication->message !!}
                                </div>
                            @endif
            
                            <!-- Resume / Education -->
                            <div class="resume-outer mt-5">
                                <div class="upper-title">
                                    <h4>Education</h4>
                                </div>
                                @if ($candidateEducations->count() === 0)
                                    No educational history added.
                                    @if (Auth::check() && Auth::user()->isCandidate())
                                        <a href="{{ route('dashboard.candidate.resume.education.index') }}" class="add-info-btn">
                                            <span class="icon flaticon-plus"></span> Add Education
                                        </a>
                                    @endif
                                @else
                                    @foreach ($candidateEducations as $education)
                                        <!-- Resume BLock -->
                                        <div class="resume-block">
                                            <div class="inner">
                                                <span class="name">{{ Str::ucfirst(Str::substr($education->institution,0, 1)) }}</span>
                                                <div class="title-box">
                                                    <div class="info-box">
                                                        <h3>{{ $education->title }}</h3>
                                                        <span>{{ Str::title($education->institution) }}</span>
                                                    </div>
                                                    <div class="edit-box">
                                                        <span class="year">{{ $education->start_date->format('Y') }} - {{ $education->end_date->format('Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="text">{{ Str::ucfirst($education->grade) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
            
                            <!-- Resume / Work & Experience -->
                            <div class="resume-outer theme-blue">
                                <div class="upper-title">
                                    <h4>Work & Experience</h4>
                                </div>
                                @if ($candidateExperiences->count() === 0)
                                    No work experience history added.
                                    @if (Auth::check() && Auth::user()->isCandidate())
                                        <a href="{{ route('dashboard.candidate.resume.experience.index') }}" class="add-info-btn">
                                            <span class="icon flaticon-plus"></span> Add Work Experience
                                        </a>
                                    @endif
                                @else
                                    @foreach ($candidateExperiences as $experience)
                                        <div class="resume-block">
                                            <div class="inner">
                                                <span class="name">{{ Str::ucfirst(Str::substr($experience->institution,0, 1)) }}</span>
                                                <div class="title-box">
                                                    <div class="info-box">
                                                        <h3>{{ $experience->title }}</h3>
                                                        <span>{{ Str::title($experience->institution) }}</span>
                                                    </div>
                                                    <div class="edit-box">
                                                        <span class="year">{{ $experience->start_date->format('Y') }} - {{ $experience->is_present ? 'Present' : $experience->end_date->format('Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="text">{{ $experience->description }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                        <aside class="sidebar">
                            <div class="btn-box">
                                <a href="{{ $candidateCV ? asset($candidateCV->attachment) : '#' }}" class="theme-btn btn-style-one" @if ($candidateCV) target="_blank" @else data-toggle="tooltip" data-placement="bottom" title="No CV Uploaded yet" disabled @endif>Download CV</a>
                            </div>
                            <div class="sidebar-widget">
                                <div class="widget-content">
                                    <ul class="job-overview">
                                        <li>
                                            <i class="icon icon-calendar"></i>
                                            <h5>Experience:</h5>
                                            <span>{{ $candidateInfo->experience }} Years</span>
                                        </li>
                
                                        <li>
                                            <i class="icon icon-user-2"></i>
                                            <h5>Gender:</h5>
                                            <span>{{ Str::ucfirst($candidateInfo->gender) }}</span>
                                        </li>

                                        <li>
                                            <i class="icon icon-degree"></i>
                                            <h5>Education Level:</h5>
                                            <span>{{ $candidateInfo->education }}</span>
                                        </li>

                                        <li>
                                            <i class="la la-transgender"></i>
                                            <h5>Sexual orientation:</h5>
                                            <span>{{ $candidateInfo->sexuality }}</span>
                                        </li>

                                        <li>
                                            <i class="la la-wheelchair"></i>
                                            <h5>Disability:</h5>
                                            <span>{{ $candidateInfo->disability }}</span>
                                        </li>

                                        <li>
                                            <i class="la la-pray"></i>
                                            <h5>Religious Denomination:</h5>
                                            <span>{{ $candidateInfo->religion }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-widget social-media-widget">
                                <h4 class="widget-title">Social media</h4>
                                <div class="widget-content">
                                    <div class="social-links">
                                        <a href="{{ $candidateInfo->fb_link ? $candidateInfo->fb_link : '#' }}" @if ($candidateInfo->fb_link) target="_blank" @endif><i class="fab fa-facebook-f"></i></a>
                                        <a href="{{ $candidateInfo->tw_link ? $candidateInfo->tw_link : '#' }}" @if ($candidateInfo->tw_link) target="_blank" @endif><i class="fab fa-twitter"></i></a>
                                        <a href="{{ $candidateInfo->in_link ? $candidateInfo->in_link : '#' }}" @if ($candidateInfo->in_link) target="_blank" @endif><i class="fab fa-instagram"></i></a>
                                        <a href="{{ $candidateInfo->linkedin_link ? $candidateInfo->linkedin_link : '#' }}" @if ($candidateInfo->linkedin_link) target="_blank" @endif><i class="fab fa-linkedin-in"></i></a>
                                        <a href="{{ $candidateInfo->website ? $candidateInfo->website : '#' }}" @if ($candidateInfo->website) target="_blank" @endif><i class="fab fa-github"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="sidebar-widget">
                                <!-- Job Skills -->
                                <h4 class="widget-title">Professional Skills & Rating</h4>
                                <div class="widget-content">
                                    @if ($candidateInfo->skills)
                                        <ul class="job-skills">
                                            @foreach($candidateInfo->skills as $item)
                                                <li><a href="#">{{ $item }} - {!! str_repeat('<span><i class="las la-star gold"></i></span>', $candidateInfo->rating[$item]) !!}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            @if (Auth::check() && Auth::user()->isEmployer() && $jobListing)
                                <div class="sidebar-widget">
                                    <!-- Job Skills -->
                                    <h4 class="widget-title">{{ env('APP_NAME') }} Skills Match</h4>
                                    <div class="widget-content">
                                        @if ($jobListing->skills)
                                            <ul class="job-skills">
                                                <li>
                                                    {!! str_repeat('<span><i class="las la-star gold"></i></span>', count(array_intersect($jobListing->skills, $candidateInfo->skills))) !!}
                                                    @if (count(array_intersect($jobListing->skills, $candidateInfo->skills)) === 0)
                                                        This jobseeker doesn't have any skillset that matches the required job skills.
                                                    @else
                                                        : This jobseeker skills matches <b>{{ count(array_intersect($jobListing->skills, $candidateInfo->skills)) }}</b> of the required job skills
                                                    @endif
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End candidate Detail Section -->
@endsection