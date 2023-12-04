@extends('layouts.auth.app')
@section('content')
    <!-- Info Section -->
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{ asset('assets/images/background/12.jpg') }});"></div>
        <div class="outer-box">
            <!-- Login Form -->
            <div class="login-form default-form">
                <div class="form-inner">
                    <h3>Hooray! Few more steps 👣 to go...</h3>
                    @if (\Session::has('message'))
                        <div class="message-box success">
                            <p class="m-0">{!! \Session::get('message') !!}</p>
                            <button class="close-btn"><span class="close_icon"></span></button>
                        </div>
                    @endif
                    <div class="mb-5 mt-5">
                        <p>Thank you for creating an account with us, just a few more steps.<br>Kindly click the link in the verification email sent to your registered email address.</p>
                        <cite>{{ env('APP_NAME') }}</cite>
                    </div>

                    <!--Login Form-->
                    <form method="post" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="form-group">
                        <button class="theme-btn btn-style-one" type="submit" name="email-resend">Resend Email Verification</button>
                        </div>
                </form>
                </div>
            </div>
            <!--End Login Form -->
        </div>
    </div>
    <!-- End Info Section -->
@endsection