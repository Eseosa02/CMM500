@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Ls widget -->
                    <div class="ls-widget">
                        <div class="tabs-box">
                            <div class="widget-title">
                                <h4>Applicant(s) for {{ $jobListing->title }}</h4>
            
                                <div class="chosen-outer">
                                    <!--Tabs Box-->
                                    <input type="hidden" value="{{ Request::query('status') ? Str::lower(Request::query('status')) : 'all' }}" id="statusValue">
                                    <select class="chosen-select" onchange="handleStatusChange(event)" id="statusResult">
                                        <option value="all">All Status</option>
                                        <option value="under-review">Under Review</option>
                                        <option value="accepted">Approved</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="withdrawn">Withdrawn</option>
                                    </select>
                                </div>
                            </div>
        
                            <div class="widget-content">
            
                                <div class="tabs-box">
                                    <div class="aplicants-upper-bar">
                                        <h6>{{ $jobListing->title }}</h6>
                                        <ul class="aplicantion-status tab-buttons clearfix">
                                        <li class="tab-btn active-btn totals" data-tab="#totals" onclick="handleTabChange('all')">Total(s): {{ $jobListingApplicationsCount }}</li>
                                        <li class="tab-btn under-review" onclick="handleTabChange('under-review')">Under Review: {{ $stats['under-review'] }}</li>
                                        <li class="tab-btn approved" onclick="handleTabChange('accepted')">Approved: {{ $stats['approved'] }}</li>
                                        <li class="tab-btn rejected" onclick="handleTabChange('rejected')">Rejected(s): {{ $stats['rejected'] }}</li>
                                        <li class="tab-btn withdrawn" onclick="handleTabChange('withdrawn')">Withdrawn(s): {{ $stats['withdrawn'] }}</li>
                                        </ul>
                                    </div>
                
                                    <div class="tabs-content">
                                        <!--Tab-->
                                        <div class="tab active-tab" id="totals">
                                            @if ($errors->count() > 0)
                                                <div class="message-box error">
                                                    <p class="m-0">{{ $errors->first() }}</p>
                                                    <button class="close-btn"><span class="close_icon"></span></button>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <p><i class="las la-star gold"></i> <i>System recommended top picks based on job requirement.</i></p>
                                                </div>
                                                @foreach ($jobListingApplications as $application)
                                                    <!-- Candidate block three -->
                                                    <div class="candidate-block-three col-lg-6 col-md-12 col-sm-12">
                                                        <div class="inner-box">
                                                            <div class="content">
                                                                <figure class="image"><img src="{{ $application->user->userImage() ? asset($application->user->userImage()) : asset('assets/images/resource/candidate-1.png') }}" alt=""></figure>
                                                                <h4 class="name" style="position: relative; display: flex; flex-wrap: wrap;">
                                                                    <a href="#">{{ $application->user->name }}</a>
                                                                    <div class="job-other-info" style="position: relative; display: flex; flex-wrap: wrap;">
                                                                        <li class="time status {{ $application->status }} m-0 mx-2">{{ Str::replaceFirst('-', ' ', Str::title($application->status)) }}</li>
                                                                    </div>
                                                                    @if (in_array($application->id, $starApplicants)) <i class="las la-star gold"></i> @endif
                                                                </h4>
                                                                <ul class="candidate-info">
                                                                    <li class="designation">{{ $application->candidateInfo->title }}</li>
                                                                    <li><span class="icon flaticon-map-locator"></span>{{ $application->candidateInfo->city }}, {{ $application->candidateInfo->country }}</li>
                                                                    <li><span class="icon flaticon-briefcase"></span> {{ $application->candidateInfo->experience }} Years</li>
                                                                </ul>
                                                                {{-- <ul class="job-other-info" style="position: relative; display: flex; flex-wrap: wrap;">
                                                                    <li class="time status {{ $application->status }}">{{ Str::replaceFirst('-', ' ', Str::title($application->status)) }}</li>
                                                                </ul> --}}
                                                                @if (count($application->candidateInfo->skills) > 0)
                                                                    <ul class="post-tags">
                                                                        @foreach ($application->candidateInfo->skills as $key => $skill)
                                                                            @if ($key < 3)
                                                                                <li><a href="#">{{ Str::ucfirst($skill) }} - {{ $application->candidateInfo->rating[$skill] }} <i class="las la-star gold small"></i></a></li>
                                                                            @endif
                                                                        @endforeach
                                                                        @if (count($application->candidateInfo->skills) - 3 > 0)
                                                                            {{ count($application->candidateInfo->skills) - 3 }} +
                                                                        @endif
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                            <div class="option-box">
                                                                <ul class="option-list">
                                                                    <li>
                                                                        <a href="{{ route('pages.candidate.detail', ['uniqueId' => $application->candidateInfo->unique_id, 'applicationId' => openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx"), 'joblistingId' => openssl_encrypt($application->jobListing->id, "AES-128-ECB", "FP25Hg9KKNJx")]) }}">
                                                                            <button data-text="View Application"><span class="la la-eye"></span></button>
                                                                        </a>
                                                                    </li>
                                                                    @if (!in_array($application->status, ['rejected', 'withdrawn']))
                                                                        @if ($application->status === "under-review")
                                                                            <li>
                                                                                <a href="#" onclick="event.preventDefault(); document.getElementById('approve-form-{{ $application->id }}').submit();">
                                                                                    <button data-text="Approve Application" class="approve"><span class="la la-check approve"></span></button></li>
                                                                                </a>
                                                                                <form method="post" action="{{ route('dashboard.employer.job.manage.decision') }}" id="approve-form-{{ $application->id }}"  style="display: none;">
                                                                                    @csrf
                                                                                    @method('POST')
                                                                                    <input type="hidden" name="applicationId" value="{{ openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx") }}">
                                                                                    <input type="hidden" name="status" value="accepted">
                                                                                    <button class="theme-btn btn-style-three" type="submit">Approve Application</button>
                                                                                </form>
                                                                        @else
                                                                            @if ($application->status !== "accepted")
                                                                                <li>
                                                                                    <a href="#" onclick="event.preventDefault(); document.getElementById('under-review-form-{{ $application->id }}').submit();">
                                                                                        <button data-text="Move to Review" class="under-review"><span class="la la-plus under-review"></span></button>
                                                                                    </a>
                                                                                    <form method="post" action="{{ route('dashboard.employer.job.manage.decision') }}" id="under-review-form-{{ $application->id }}"  style="display: none;">
                                                                                        @csrf
                                                                                        @method('POST')
                                                                                        <input type="hidden" name="applicationId" value="{{ openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx") }}">
                                                                                        <input type="hidden" name="status" value="under-review">
                                                                                        <button class="theme-btn btn-style-three" type="submit">Review Application</button>
                                                                                    </form>
                                                                                </li>
                                                                            @endif
                                                                        @endif
                                                                        <li>
                                                                            <a href="#" onclick="event.preventDefault(); document.getElementById('rejected-form-{{ $application->id }}').submit();">
                                                                                <button data-text="Reject Application" class="reject"><span class="la la-times-circle reject"></span></button>
                                                                            </a>
                                                                            <form method="post" action="{{ route('dashboard.employer.job.manage.decision') }}" id="rejected-form-{{ $application->id }}"  style="display: none;">
                                                                                @csrf
                                                                                @method('POST')
                                                                                <input type="hidden" name="applicationId" value="{{ openssl_encrypt($application->id, "AES-128-ECB", "FP25Hg9KKNJx") }}">
                                                                                <input type="hidden" name="status" value="rejected">
                                                                                <button class="theme-btn btn-style-three" type="submit">Review Application</button>
                                                                            </form>
                                                                        </li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
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
        function handleStatusChange(event) {
			const { value } = event.target;
			const { origin, pathname, search } = window.location;

			const urlParams = new URLSearchParams(search); // For GET request
			urlParams.append("status", value);

			const urlQueryString = new URLSearchParams(Object.fromEntries(urlParams)).toString();
			window.location.href = `${origin}${pathname}?${urlQueryString}`;
		}
        function handleTabChange(value) {
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