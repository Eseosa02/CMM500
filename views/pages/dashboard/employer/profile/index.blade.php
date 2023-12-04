@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
            <div class="upper-title-box">
                <h3>Company Profile!</h3>
                <div class="text">Ready to jump back in?</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Ls widget -->
                    <div class="ls-widget">
                        <div class="tabs-box">
                            <div class="widget-title">
                                <h4>My Profile</h4>
                                <div class="chosen-outer">
                                    @if (Auth::user()->isComplete == 100)
                                        <!--Tabs Box-->
                                        <a href="{{ route('pages.recruiter.detail', ['uniqueId' => $employer->employerInfo->unique_id, 'name' => $employer->name]) }}" target="_blank">
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
                                        <button class="close-btn"><span class="close_icon"></span></button>
                                    </div>
                                @endif
                                @if (\Session::has('message'))
                                    <div class="message-box success">
                                        <p class="m-0">{!! \Session::get('message') !!}</p>
                                        <button class="close-btn"><span class="close_icon"></span></button>
                                    </div>
                                @endif
                                <form class="default-form" method="post" action="{{ route('dashboard.employer.profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="uploading-outer">
                                        @if ($employer->employerInfo->image)
                                            <span class="company-logo"><img src="{{ asset($employer->employerInfo->image) }}" alt="" width="40%"></span>
                                        @endif
                                        <div class="uploadButton">
                                            <input class="uploadButton-input" type="file" name="image" accept="image/*" id="upload" />
                                            <label class="uploadButton-button ripple-effect" for="upload">Browse Logo</label>
                                            <span class="uploadButton-file-name"></span>
                                        </div>
                                        <div class="text">Max file size is 5MB, Minimum dimension: 330x300 And Suitable files are .jpg & .png</div>
                                    </div>
                                    <div class="uploading-outer">
                                        @if ($employer->employerInfo->document)
                                            <a href="{{ asset($employer->employerInfo->document) }}" target="_blank">
                                                <span class="company-logo">
                                                    <img src="{{ asset('assets/images/document.png') }}" alt="" width="40%">
                                                </span>
                                            </a>
                                        @endif
                                        <div style="display: flex; ">
                                            <span class="required">*</span>
                                            <input type="file" name="document" accept="application/pdf" id="document" />
                                        </div>
                                        <div class="text">Upload Tax document or utility bill or company registration, Max file size is 5MB & document type is .pdf</div>
                                    </div>
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Company name <span class="required">*</span></label>
                                            <input type="text" name="name" placeholder="Invisionn" value="{{ old('name') ? old('name') : $employer->name }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Email address <span class="required">*</span></label>
                                            <input type="email" placeholder="Email Address" value="{{ $employer->email }}" disabled>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="text" name="phone" placeholder="+234 0 123 456 7890" value="{{ old('phone') ? old('phone') : $employer->employerInfo->phone }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Website <span class="required">*</span></label>
                                            <input type="text" name="website" placeholder="{{ env('WEBSITE') }}" value="{{ old('website') ? old('website') : $employer->employerInfo->website }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Founded <span class="required">*</span></label>
                                            <input type="text" name="founded" placeholder="2023" value="{{ old('founded') ? old('founded') : $employer->employerInfo->founded }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Company Size <span class="required">*</span></label>
                                            <input type="hidden" value="{{ old('company_size') ? old('company_size') : $employer->employerInfo->company_size }}" id="companySize">
                                            <select class="chosen-select" name="company_size" id="companySizeResult">
                                                <option>50 - 100</option>
                                                <option>100 - 150</option>
                                                <option>200 - 250</option>
                                                <option>300 - 350</option>
                                                <option>500 - 1000</option>
                                            </select>
                                        </div>

                                        <!-- Search Select -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Industry <span class="required">*</span></label>
                                            <input type="hidden" value="{{ old('industry') ? json_encode(old('industry')) : json_encode($employer->employerInfo->industry) }}" id="industryValue">
                                            <select class="chosen-select multiple" name="industry[]" multiple tabindex="4" id="industryResult">
                                                @foreach ($industries as $industry)
                                                    <option value="{{ $industry }}">{{ $industry }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- About Company -->
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Company Description <span class="required">*</span></label>
                                            <textarea name="description" id="description" placeholder="About company">{{ old('description') ? old('description') : $employer->employerInfo->description }}</textarea>
                                        </div>

                                        <div class="tabs-box">
                                            <div class="widget-title -no-padding">
                                                <h4>Contact Information</h4>
                                            </div>
                
                                            <div class="row">
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Country <span class="required">*</span></label>
                                                    <input type="hidden" value="{{ old('country') ? old('country') : $employer->employerInfo->country }}" id="country">
                                                    <select class="chosen-select" name="country" id="countryResult" onchange="updateStates(event.target.value)">
                                                        @foreach ($countries as $country)
                                                            <option>{{ $country['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>City <span class="required">*</span></label>
                                                    <input type="hidden" value="{{ old('city') ? old('city') : $employer->employerInfo->city }}" id="city">
                                                    <select class="chosen-select" name="city" id="cityResult">
                                                    </select>
                                                </div>
                
                                                <!-- Input -->
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label>Complete Address <span class="required">*</span></label>
                                                    <input type="text" name="address" placeholder="Garthdee House, Garthdee Road, Aberdeen, AB10 7AQ"  value="{{ old('address') ? old('address') : $employer->employerInfo->address }}">
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
                                                    <input type="url" name="fb_link" value="{{ old('fb_link') ? old('fb_link') : $employer->employerInfo->fb_link }}">
                                                </div>
        
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Twitter</label>
                                                    <input type="url" name="tw_link" value="{{ old('tw_link') ? old('tw_link') : $employer->employerInfo->tw_link }}">
                                                </div>
        
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Linkedin</label>
                                                    <input type="url" name="linkedin_link" value="{{ old('linkedin_link') ? old('linkedin_link') : $employer->employerInfo->linkedin_link }}">
                                                </div>
        
                                                <!-- Input -->
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <label>Instagram</label>
                                                    <input type="url" name="in_link" value="{{ old('in_link') ? old('in_link') : $employer->employerInfo->in_link }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <button class="theme-btn btn-style-one" type="submit" name="option" value="about-employer">Save</button>
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
			const industryValueElement = document.getElementById("industryValue");
            const result = JSON.parse(industryValueElement.value);
			const companySize = document.getElementById("companySize").value;
			const country = document.getElementById("country").value;
			const city = document.getElementById("city").value;
            // set the values
            $("#industryResult").val(result).trigger("chosen:updated");
            $("#companySizeResult").val(companySize).trigger("chosen:updated");
            $("#countryResult").val(country).trigger("chosen:updated");

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