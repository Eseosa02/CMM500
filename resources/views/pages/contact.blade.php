@extends('layouts.app')
@section('content')
    <!-- Map Section -->
    <section class="map-section">
        <div class="map-outer">
			<div class="map-canvas" data-zoom="12" data-lat="-37.817085" data-lng="144.955631" data-type="roadmap" data-hue="#ffc400" data-title="Envato" data-icon-path="{{ asset('assets/images/icons/contact-map-marker.png') }}" data-content="Melbourne VIC 3000, Australia<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
			</div>
        </div>
    </section>
    <!-- End Map Section -->
  
    <!-- Contact Section -->
    <section class="contact-section">
        <div class="auto-container">
			<div class="upper-box">
				<div class="row">
					<div class="contact-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon"><img src="{{ asset('assets/images/icons/placeholder.svg') }}" alt=""></span>
							<h4>Address</h4>
							<p>Garthdee House, Garthdee Road, <br>Aberdeen, AB10 7AQ.</p>
						</div>
					</div>
					<div class="contact-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon"><img src="{{ asset('assets/images/icons/smartphone.svg') }}" alt=""></span>
							<h4>Call Us</h4>
							<p><a href="#" class="phone">123 456 7890</a></p>
						</div>
					</div>
					<div class="contact-block col-lg-4 col-md-6 col-sm-12">
						<div class="inner-box">
							<span class="icon"><img src="{{ asset('assets/images/icons/letter.svg') }}" alt=""></span>
							<h4>Email</h4>
							<p><a href="#">{{ env('SUPPORT_EMAIL') }}</a></p>
						</div>
					</div>
				</div>
			</div>
  
  
          <!-- Contact Form -->
			<div class="contact-form default-form">
				<h3>Leave A Message</h3>
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
				<!--Contact Form-->
				<form method="post" action="{{ route('pages.contact.create') }}" id="email-form">
					@csrf
					@method('POST')
					<div class="row">
						<div class="col-lg-6 col-md-12 col-sm-12 form-group">
							<label>Your Name</label>
							<input type="text" name="name" class="username" placeholder="Your Name*" value="{{ old('name') }}" required>
						</div>
		
						<div class="col-lg-6 col-md-12 col-sm-12 form-group">
							<label>Your Email</label>
							<input type="email" name="email" class="email" placeholder="Your Email*" value="{{ old('name') }}" required>
						</div>
		
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<label>Subject</label>
							<input type="text" name="subject" class="subject" placeholder="Subject *" value="{{ old('name') }}" required>
						</div>
		
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<label>Your Message</label>
							<textarea name="message" placeholder="Write your message..." required>{{ old('message') }}</textarea>
						</div>
		
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<button class="theme-btn btn-style-one" type="submit" id="submit">Send Message</button>
						</div>
					</div>
				</form>
			</div>
			<!--End Contact Form -->
        </div>
    </section>
    <!-- Contact Section -->

    @include('_partials.main.callToAction')
@endsection