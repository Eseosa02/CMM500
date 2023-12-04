@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
            <div class="upper-title-box">
                <h3>{{ Request::query('edit') ? 'Edit' : 'Create' }} Work Experience!</h3>
                <div class="text">Ready to jump back in?</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Ls widget -->
                    <div class="ls-widget">
                        <div class="tabs-box">
                            <div class="widget-title">
                                <h4>Work Experience</h4>
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
                                <form class="default-form" method="post" action="{{ route('dashboard.candidate.resume.experience.update') }}">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Title <span class="required">*</span></label>
                                            <input type="text" name="title" placeholder="Title" value="{{ $editModeId ? $candidateExperience->title : old('title') }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Company Name <span class="required">*</span></label>
                                            <input type="text" name="institution" placeholder="Institution" value="{{ $editModeId ? $candidateExperience->institution : old('institution') }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Start Date</label>
                                            <input type="text" name="start_date" value="{{ $editModeId ? Str::substr($candidateExperience->start_date,0, 10) : old('start_date') }}" placeholder="YYYY-MM-DD">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label style="display: flex; justify-content: space-between;">
                                                End Date
                                                <div class="form-group m-0">
                                                    <div class="field-outer">
                                                        <div class="input-group checkboxes square">
                                                        <input type="checkbox" name="is_present" @if ($editModeId ? $candidateExperience->is_present : old('title')) checked @endif id="is_present" onclick="handlePresentSwitch(event)">
                                                        <label for="is_present" class="remember"><span class="custom-checkbox"></span> I currently work here</label>
                                                        </div>
                                                        {{-- <a href="#" class="pwd">Forgot password?</a> --}}
                                                    </div>
                                                </div>
                                            </label>
                                            <input type="text" name="end_date" value="{{ $editModeId ? Str::substr($candidateExperience->end_date, 0, 10) : old('end_date') }}" placeholder="YYYY-MM-DD" id="end_date">
                                        </div>
                                        
                                        <!-- About Candidate -->
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Description <span class="required">*</span></label>
                                            <textarea name="description" placeholder="Brief Description">{{ $editModeId ? $candidateExperience->description : old('description') }}</textarea>
                                        </div>
                                        
                                        <input type="hidden" name="id" value="{{ $editModeId }}">
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <button class="theme-btn btn-style-one" type="submit" name="mode" value="{{ $editModeId ? 'edit' : 'create' }}">{{ $editModeId ? 'Update' : 'Save' }}</button>
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
        function handlePresentSwitch(event) {
            $('#end_date').prop('disabled', event.target.checked);
            if (event.target.checked) {
                document.getElementById('end_date').value = '';
            } else {
                document.getElementById('end_date').value = new Date().toISOString().slice(0, 10);
            }
        }
        $('#end_date').keyup(function (event) {
			if (event.target.value !== '') {
                $("#is_present").removeAttr('checked');
            } else {
                $("#is_present").attr("checked", true);
                $("#is_present").prop('checked', true);
                $('#end_date').prop('disabled', true);
            }
		});
        $(document).ready(function () { 
        });
    </script>
@endsection