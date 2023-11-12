@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
            <div class="upper-title-box">
                <h3>My Profile!</h3>
                <div class="text">Ready to jump back in?</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Ls widget -->
                    <div class="ls-widget">
                        @if (Auth::user()->isComplete == 0)
							<div class="message-box info">
								<p class="m-0">Complete your profile to enable other pages.</p>
							</div>
						@endif
                        <div class="tabs-box">
                            <div class="widget-title">
                                <h4>My Profile</h4>
                                <div class="chosen-outer">
                                    <!--Tabs Box-->
                                    @if (Auth::user()->isComplete >= 50)
                                        <a href="{{ route('pages.candidate.detail', ['uniqueId' => $candidateInfo->unique_id]) }}">
                                            <button type="button" class="theme-btn btn-style-three small">View Profile &nbsp;<i class="las la-external-link-alt"></i></button>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="widget-content">
                                <!-- Profile Error message -->
                                @if ($errors->count() > 0)
                                    <div class="message-box error">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (\Session::has('message'))
                                    <div class="message-box success">
                                        <p class="m-0">{!! \Session::get('message') !!}</p>
                                        <button class="close-btn"><span class="close_icon"></span></button>
                                    </div>
                                @endif
                                <form class="default-form" method="post" action="{{ route('dashboard.candidate.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="uploading-outer">
                                        @if ($candidateInfo->image)
                                            <span class="company-logo"><img src="{{ asset($candidateInfo->image) }}" alt="" width="40%"></span>
                                        @endif
                                        <div class="uploadButton">
                                            <input class="uploadButton-input" type="file" name="image" accept="image/*" id="upload" />
                                            <label class="uploadButton-button ripple-effect" for="upload">Browse Logo</label>
                                            <span class="uploadButton-file-name"></span>
                                        </div>
                                        <div class="text">Max file size is 5MB, Minimum dimension: 330x300 And Suitable files are .jpg & .png</div>
                                    </div>
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Full Name <span class="required">*</span></label>
                                            <input type="text" name="name" placeholder="Full Name" value="{{ old('name') ? old('name') : $candidate->name }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Job Title <span class="required">*</span></label>
                                            <input type="text" name="title" placeholder="Job Title" value="{{ old('title') ? old('title') : $candidateInfo->title }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Email address <span class="required">*</span></label>
                                            <input type="email" placeholder="Email Address" value="{{ $candidate->email }}" disabled>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="text" name="phone" placeholder="+234 0 123 456 7890" value="{{ old('phone') ? old('phone') : $candidateInfo->phone }}">
                                        </div>

                                        <!-- Select -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Gender <span class="required">*</span></label>
                                            <input type="hidden" value="{{ old('gender') ? old('gender') : $candidateInfo->gender }}" id="gender">
                                            <select class="chosen-select" name="gender" id="genderResult">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Date of Birth</label>
                                            <input type="text" name="dob" value="{{ old('dob') ? old('dob') : $candidateInfo->dob }}" placeholder="DD/MM/YYYY">
                                        </div>

                                        <!-- Search Select -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Education Level <span class="required">*</span></label>
                                            <input type="hidden" value="{{ old('education') ? old('education') : $candidateInfo->education }}" id="education">
                                            <select class="chosen-select" name="education" id="educationResult">
                                                <option value="Bachelor of Science">Bachelor of Science</option>
                                                <option value="Master of Science">Master of Science</option>
                                                <option value="Doctor of Philosophy">Doctor of Philosophy</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Experience <span class="required">*</span></label>
                                            <input type="hidden" value="{{ old('experience') ? old('experience') : $candidateInfo->experience  }}" id="experience">
                                            <select class="chosen-select" name="experience" id="experienceResult">
                                                <option value="0 - 2">0 - 2 years</option>
                                                <option value="2 - 4">2 - 4 years</option>
                                                <option value="5+">5+ years</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Skills <span class="required">*</span></label>
                                            <input type="hidden" value="{{ old('skills') ? json_encode(old('skills')) : json_encode($candidateInfo->skills) }}" id="skills">
                                            <select class="chosen-select multiple" name="skills[]" multiple id="skillsResult">
                                                @foreach ($skills as $skill)
                                                    <option value="{{ $skill }}">{{ $skill }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Github URL</label>
                                            <input type="text" name="website" value="{{ old('website') ? old('website') : $candidateInfo->website }}">
                                        </div>

                                        <!-- About Candidate -->
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Profile Description <span class="required">*</span></label>
                                            <textarea name="description" id="description" placeholder="Profile Description">{{ old('description') ? old('description') : $candidateInfo->description }}</textarea>
                                        </div>

                                        <div class="tabs-box">
                                            <div class="widget-title -no-padding">
                                                <h4>Equal Opportunity</h4>
                                            </div>
                
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>What is your sexual orientation? <span class="required">*</span></label>
                                                    <input type="hidden" value="{{ old('sexuality') ? old('sexuality') : $candidateInfo->sexuality }}" id="sexuality">
                                                    <select class="chosen-select" name="sexuality" id="sexualityResult">
                                                        <option value="Heterosexual">Heterosexual</option>
                                                        <option value="Gay">Gay</option>
                                                        <option value="Lesbian">Lesbian</option>
                                                        <option value="Bisexual">Bisexual</option>
                                                        <option value="Prefer not to say">Prefer not to say</option>
                                                    </select>
                                                </div>
        
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Do you consider yourself a disability? <span class="required">*</span></label>
                                                    <input type="hidden" value="{{ old('disability') ? old('disability') : $candidateInfo->disability }}" id="disability">
                                                    <select class="chosen-select" name="disability" id="disabilityResult">
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                        <option value="Prefer not to say">Prefer not to say</option>
                                                    </select>
                                                </div>
        
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>To which religious denomination do you belong? <span class="required">*</span></label>
                                                    <input type="hidden" value="{{ old('religion') ? old('religion') : $candidateInfo->religion }}" id="religion">
                                                    <select class="chosen-select" name="religion" id="religionResult">
                                                        <option value="Christianity">Christianity</option>
                                                        <option value="Buddhist">Buddhist</option>
                                                        <option value="Muslim">Muslim</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Other">Other</option>
                                                        <option value="Prefer not to say">Prefer not to say</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tabs-box">
                                            <div class="widget-title -no-padding">
                                                <h4>Contact Information</h4>
                                            </div>
                
                                            <div class="row">
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Country <span class="required">*</span></label>
                                                    <input type="hidden" value="{{ old('country') ? old('country') : $candidateInfo->country }}" id="country">
                                                    <select class="chosen-search-select" name="country" id="countryResult" onchange="updateStates(event.target.value)">
                                                        @foreach ($countries as $country)
                                                            <option>{{ $country['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>City <span class="required">*</span></label>
                                                    <input type="hidden" value="{{ old('city') ? old('city') : $candidateInfo->city }}" id="city">
                                                    <select class="chosen-select" name="city" id="cityResult">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tabs-box">
                                            <div class="widget-title -no-padding">
                                                <h4>Social Network</h4>
                                            </div>
                
                                            <div class="row">
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Facebook</label>
                                                    <input type="url" name="fb_link" value="{{ old('fb_link') ? old('fb_link') : $candidateInfo->fb_link }}">
                                                </div>
        
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Twitter</label>
                                                    <input type="url" name="tw_link" value="{{ old('tw_link') ? old('tw_link') : $candidateInfo->tw_link }}">
                                                </div>
        
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Linkedin</label>
                                                    <input type="url" name="linkedin_link" value="{{ old('linkedin_link') ? old('linkedin_link') : $candidateInfo->linkedin_link }}">
                                                </div>
        
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Instagram</label>
                                                    <input type="url" name="in_link" value="{{ old('in_link') ? old('in_link') : $candidateInfo->in_link }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <button class="theme-btn btn-style-one" type="submit" value="about-candidate">Save</button>
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
			const genderValueElement = document.getElementById("gender").value;
			const educationValueElement = document.getElementById("education").value;
			const experienceValueElement = document.getElementById("experience").value;
            const skillsValueElement = document.getElementById("skills").value;
            const sexualityValueElement = document.getElementById("sexuality").value;
            const disabilityValueElement = document.getElementById("disability").value;
            const religionValueElement = document.getElementById("religion").value;
			const country = document.getElementById("country").value;
			const city = document.getElementById("city").value;
            // set the values
            $("#genderResult").val(genderValueElement).trigger("chosen:updated");
            $("#educationResult").val(educationValueElement).trigger("chosen:updated");
            $("#experienceResult").val(experienceValueElement).trigger("chosen:updated");
            $("#skillsResult").val(JSON.parse(skillsValueElement)).trigger("chosen:updated");
            $("#sexualityResult").val(sexualityValueElement).trigger("chosen:updated");
            $("#disabilityResult").val(disabilityValueElement).trigger("chosen:updated");
            $("#religionResult").val(religionValueElement).trigger("chosen:updated");
            $("#countryResult").val(country).trigger("chosen:updated")

            $('textarea#description').tinymce({
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