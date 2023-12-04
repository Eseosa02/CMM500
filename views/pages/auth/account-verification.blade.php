@extends('layouts.auth.app')
@section('content')
    <!-- Info Section -->
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{ asset('assets/images/background/12.jpg') }});"></div>
        <div class="outer-box">
            <!-- Employer Verfification Form -->
            <div class="login-form default-form">
                <div class="form-inner">
                    <div class="mb-5 mt-5">
                        @if (Auth::check() && Auth::user()->role === 'employer' && Auth::user()->employerInfo->approval === 'rejected')
                            <h3>Hello, an update on your account verification...</h3>
                            <div class="message-box warning">
                                <p class="m-0">
                                    Hi {{ Auth::user()->name }}, <br><br>
                                    We refer to your recent account approval submission. <br><br>
                                    Your account approval has been rejected, If you feel this decision is inaccurate, please send an email with a query addressed to <a href="mailto:{{ env('SUPPORT_EMAIL') }}"><strong>{{ env('SUPPORT_EMAIL') }}</strong></a>. <br><br>
                                    Please include your Company Name, Address and Email Addres and let us know it relates to an account unverification.<br><br>
                                    We will then contact you by email to help you with your query.
                                    <br><br>
                                    <cite>Regards</cite><br>
                                    <cite>{{ env('APP_NAME') }} Team</cite>
                                </p>
                            </div>
                        @endif
                        @if (Auth::check() && Auth::user()->role === 'employer' && Auth::user()->employerInfo->approval === 'unverified')
                            <h3>Hello, your account is currently under review...</h3>
                            <p>
                                Thank you for completing your account profile, your account is currently under review by an admin. Once a decision on your account has been reached, full access will be granted.
                            </p>
                            <br>
                            <cite>{{ env('APP_NAME') }} Team</cite>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Info Section -->
@endsection