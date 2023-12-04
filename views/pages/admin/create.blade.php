@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
            <div class="upper-title-box">
                <h3>{{ Request::query('edit') ? 'Edit' : 'Create' }} Admin!</h3>
                <div class="text">Ready to jump back in?</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Ls widget -->
                    <div class="ls-widget">
                        <div class="tabs-box">
                            <div class="widget-title">
                                <h4>Admin</h4>
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
                                <form class="default-form" method="post" action="{{ route('dashboard.admin.create') }}">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Name <span class="required">*</span></label>
                                            <input type="text" name="name" placeholder="Name" value="{{ $editModeId ? $admin->name : old('name') }}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Email <span class="required">*</span></label>
                                            <input type="email" name="email" placeholder="Email" value="{{ $editModeId ? $admin->email : old('email') }}" @if($editModeId) disabled @endif>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="text" name="phone" placeholder="Phone" value="{{ $editModeId ? $admin->phone : old('phone') }}">
                                        </div>

                                        <!-- Search Status -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Status <span class="required">*</span></label>
                                            <input type="hidden" value="{{ $editModeId ? $admin->status : old('status') }}" id="status">
                                            <select class="chosen-select" name="status" id="statusResult">
                                                <option value="active">Active</option>
                                                <option value="disabled">Disabled</option>
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
            const statusValueElement = document.getElementById("status").value;

            $("#statusResult").val(statusValueElement).trigger("chosen:updated");
        });
    </script>
@endsection