@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
            <div class="upper-title-box">
                <h3>{{ $editModeJobReference ? 'Edit Job' : 'Post a New Job!' }}</h3>
                <div class="text">Ready to jump back in?</div>
            </div>
    
            <div class="row">
                <div class="col-lg-12">
                    <!-- Ls widget -->
                    <div class="ls-widget">
                        <div class="tabs-box">
                            @if (Auth::user()->isComplete < 100)
								<div class="message-box info">
									<p class="m-0">Complete your <a href="{{ route('dashboard.employer.profile.index') }}">"My Pofile"</a> to enable this page functionality.</p>
								</div>
							@endif
                            <div class="widget-title">
                                <h4>{{ $editModeJobReference ? 'Edit Job' : 'Post Job' }}</h4>
                            </div>
                            <div class="widget-content">
                                @if ($errors->count() > 0)
                                    <div class="message-box error">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button class="close-btn"><span class="close_icon"></span></button>
                                    </div>
                                @endif
                                @if (\Session::has('message'))
                                    <div class="message-box success">
                                        <p class="m-0">{!! \Session::get('message') !!}</p>
                                        <button class="close-btn"><span class="close_icon"></span></button>
                                    </div>
                                @endif
                                <form class="default-form" action="{{ route('dashboard.employer.job.create') }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Job Title <span class="required">*</span></label>
                                            <input type="text" name="title" value="{{ $editModeJobReference ? $employerJobListing->title : old('title') }}" placeholder="Title">
                                        </div>

                                        <!-- Search Select -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Job Category <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeJobReference ? $employerJobListing->category_id : old('category_id') }}" id="categoryId">
                                            <select class="chosen-search-select" name="category_id" id="categoryIdResult">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Search Select -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Contract Type <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeJobReference ? $employerJobListing->contract_type : old('contract_type') }}" id="contractType">
                                            <select class="chosen-select" name="contract_type" id="contractTypeResult">
                                                <option value="contract">Contract</option>
                                                <option value="full time">Fulltime</option>
                                                <option value="freelance">Freelance</option>
                                                <option value="internship">Internship</option>
                                                <option value="part time">Part time</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Job Description <span class="required">*</span></label>
                                            <textarea name="description" id="jobDescription" placeholder="">{{ $editModeJobReference ? $employerJobListing->description : old('description') }}</textarea>
                                        </div>

                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Skills <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeJobReference ? json_encode($employerJobListing->skills) : json_encode(old('skills')) }}" id="skills">
                                            <select class="chosen-select multiple" name="skills[]" multiple id="skillsResult">
                                                @foreach ($skills as $skill)
                                                    <option value="{{ $skill }}">{{ $skill }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                
                                        <!-- Search Select -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Priority <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeJobReference ? $employerJobListing->priority : old('priority') }}" id="priority">
                                            <select class="chosen-select" name="priority" id="priorityResult">
                                                <option value="low">Low</option>
                                                <option value="medium">Medium</option>
                                                <option value="urgent">Urgent</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Experience <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeJobReference ? json_encode($employerJobListing->experience) : json_encode(old('experience')) }}" id="experience">
                                            <select class="chosen-select multiple" name="experience[]" multiple id="experienceResult">
                                                <option value="0 - 2">0 - 2 years</option>
                                                <option value="2 - 4">2 - 4 years</option>
                                                <option value="5+">5+ years</option>
                                            </select>
                                        </div>
                
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Country <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeJobReference ? $employerJobListing->country : old('country') }}" id="country">
                                            <select class="chosen-search-select" name="country" id="countryResult" onchange="updateStates(event.target.value)">
                                                @foreach ($countries as $country)
                                                    <option>{{ $country['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>City <span class="required">*</span></label>
                                            <input type="text" value="{{ $editModeJobReference ? $employerJobListing->city : old('city') }}" id="city" style="display: none">
                                            <select class="chosen-select" name="city" id="cityResult">
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Salary</label>
                                            <input type="text" name="salary" value="{{ $editModeJobReference ? $employerJobListing->salary : old('salary') }}" placeholder="$35k - $45k">
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Hours per week</label>
                                            <input type="number" name="hours" value="{{ $editModeJobReference ? $employerJobListing->hours : old('hours') }}" placeholder="40">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Application Deadline Date</label>
                                            <input type="text" name="expiry_date" value="{{ $editModeJobReference ? Str::substr($employerJobListing->expiry_date, 0, 10) : old('expiry_date') }}" placeholder="DD/MM/YYYY">
                                        </div>

                                        @if ($editModeJobReference)
                                            <div class="form-group col-lg-6 col-md-12">
                                                <label>Status <span class="required">*</span></label>
                                                <input type="hidden" value="{{ $editModeJobReference ? $employerJobListing->status : old('status') }}" id="status">
                                                <select class="chosen-select" name="status" id="statusResult">
                                                    <option value="open">Open</option>
                                                    <option value="closed">Closed</option>
                                                    <option value="expired">Expired</option>
                                                    <option value="discarded">Discarded</option>
                                                </select>
                                            </div>
                                        @endif
                
                                        <!-- Input -->
                                        <div class="form-group col-lg-12 col-md-12 text-right">
                                            @if ($editModeJobReference)
                                                <input type="hidden" name="id" value="{{ $editModeJobReference }}">
                                                <button class="theme-btn btn-style-two" name="submit" value="edit">Update</button>
                                                <button class="theme-btn btn-style-four" name="submit" value="open">Save as new job</button>
                                            @else
                                                <button class="theme-btn btn-style-two" name="submit" value="draft">Save as Draft</button>
                                                <button class="theme-btn btn-style-four" name="submit" value="open">Save & Publish</button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
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
        var countryList = [];

        $.get('{{ asset("assets/countries.json") }}').done(function(res) {
            countryList = res;
            const country = document.getElementById("country").value;
            updateStates(country);
        });

        
        function updateStates(country) {
            const states = countryList.find(c => c.name === country)?.states

            if (!states) {
                return;
            }

            var cityOption = '';
            
            states.forEach((state, index) => {
                cityOption += `<option>${state}</option>`
            });

            $("#cityResult").html('').append(cityOption);
            $("#cityResult").trigger("chosen:updated");
            
            const city = document.getElementById("city").value;
            $("#cityResult").val(city).trigger("chosen:updated");
        }

        $(document).ready(function () {
			const categoryIdValueElement = document.getElementById("categoryId").value;
			const contractTypeValueElement = document.getElementById("contractType").value;
			const priorityValueElement = document.getElementById("priority").value;
			const experienceValueElement = document.getElementById("experience").value;
			const skillsValueElement = document.getElementById("skills").value;
            const country = document.getElementById("country").value;
			const city = document.getElementById("city").value;
			const status = document.getElementById("status") ? document.getElementById("status").value : '';
            
            // set the values
            $("#categoryIdResult").val(categoryIdValueElement).trigger("chosen:updated");
            $("#contractTypeResult").val(contractTypeValueElement).trigger("chosen:updated");
            $("#priorityResult").val(priorityValueElement).trigger("chosen:updated");
            $("#experienceResult").val(JSON.parse(experienceValueElement)).trigger("chosen:updated");
            $("#skillsResult").val(JSON.parse(skillsValueElement)).trigger("chosen:updated");
            $("#countryResult").val(country).trigger("chosen:updated");
            $("#statusResult").val(status).trigger("chosen:updated");

            $('textarea#jobDescription').tinymce({
                height: 500,
                menubar: 'edit view insert format tools table help',
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                    'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
                    'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                ],
                toolbar: 'undo redo | blocks | bold italic backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | removeformat | help'
            });
        });
    </script>
@endsection