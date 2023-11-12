@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
            <div class="upper-title-box">
                <h3>{{ Request::query('edit') ? 'Edit' : 'Create' }} Education!</h3>
                <div class="text">Ready to jump back in?</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Ls widget -->
                    <div class="ls-widget">
                        <div class="tabs-box">
                            <div class="widget-title">
                                <h4>Education</h4>
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
                                <form class="default-form" method="post" action="{{ route('dashboard.candidate.resume.education.update') }}">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Title <span class="required">*</span></label>
                                            <input type="text" name="title" placeholder="Title" value="{{ $editModeId ? $candidateEducation->title : old('title') }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Institution <span class="required">*</span></label>
                                            <input type="text" name="institution" placeholder="Institution" value="{{ $editModeId ? $candidateEducation->institution : old('institution') }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Start Date</label>
                                            <input type="text" name="start_date" value="{{ $editModeId ? Str::substr($candidateEducation->start_date,0, 10) : old('start_date') }}" placeholder="YYYY-MM-DD">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>End Date</label>
                                            <input type="text" name="end_date" value="{{ $editModeId ? Str::substr($candidateEducation->end_date,0, 10) : old('end_date') }}" placeholder="YYYY-MM-DD">
                                        </div>

                                        <!-- Search Grade -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Grade <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeId ? $candidateEducation->grade : old('grade') }}" id="grade">
                                            <select class="chosen-select" name="grade" id="gradeResult">
                                                <option value="distinct">Distinct</option>
                                                <option value="merit">Merit</option>
                                                <option value="pass">Pass</option>
                                            </select>
                                        </div>
                                        
                                        <input type="hidden" name="id" value="{{ $editModeId }}">
                                        <!-- Input -->
                                        <div class="form-group col-lg-12 col-md-12">
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
        $(document).ready(function () {
            const gradeValueElement = document.getElementById("grade").value;

            $("#gradeResult").val(gradeValueElement).trigger("chosen:updated");
        });
    </script>
@endsection