@extends('layouts.app')
@section('content')
    <!--Page Title-->
    <section class="page-title">
        <div class="auto-container">
			<div class="title-outer">
				<h1>About Us</h1>
				<ul class="page-breadcrumb">
					<li><a href="{{ route('pages.homepage') }}">Home</a></li>
					<li>About Us</li>
				</ul>
			</div>
        </div>
    </section>
    <!--End Page Title-->

    <!-- About Section Three -->
    <section class="about-section-three">
        <div class="auto-container">
			<div class="images-box">
				<div class="row">
					<div class="column col-lg-12 col-md-12 col-sm-12">
						<figure class="image"><img src="{{ asset('assets/images/resource/about-img-1.jpg') }}" alt=""></figure>
					</div>
				</div>
			</div>
  
			<div class="text-box mt-5">
				<h4>About {{ env('APP_NAME') }}</h4>
				<p>Welcome to {{ env('APP_NAME') }}, a platform designed to facilitate the connection between skilled job searchers with promising career prospects. Our organisation is committed to streamlining the process of searching for employment and allowing individuals to pursue fulfilling career trajectories, while also aiding employers in identifying the appropriate personnel to propel their organisations towards success.</p>
				<p>At {{ env('APP_NAME') }}, we possess a comprehensive understanding of the many issues and complexities that characterise the contemporary work market. The objective of our organisation is to establish an accessible and inclusive environment that facilitates the exploration of a wide array of employment opportunities from reputable firms spanning multiple sectors. Our primary objective is to offer a job search process that is smooth and effective, specifically designed to cater to the individual interests and objectives of every user. Our team is dedicated to cultivating a transparent and friendly atmosphere for both those seeking employment and employers.</p>
				<p>Discover our platform and have access to a multitude of captivating opportunities that are in line with your distinct abilities, objectives, and goals. We anticipate the opportunity to contribute to your professional trajectory of achievement</p>
				<p>
					Yours faithfully,
				</p>
				<p>
					<i>The team at {{ env('APP_NAME') }}</i>
				</p>
			</div>
        </div>
    </section>
    <!-- End About Section Three -->

    <!-- Call To Action Two -->
    <section class="call-to-action-two" style="background-image: url('assets/images/background/1.jpg');">
        <div class="auto-container">
          <div class="sec-title light text-center">
            <h2>Your Dream Jobs Are Waiting</h2>
            <div class="text">Over 1 million interactions, 50,000 success stories Make yours now.</div>
          </div>
  
          <div class="btn-box">
            <a href="{{ route('pages.search', ['title' => '', 'location' => '']) }}" class="theme-btn btn-style-three">Search Job</a>
          </div>
        </div>
    </section>
    <!-- End Call To Action -->

    <!-- Work Section -->
    <section class="work-section style-two">
        <div class="auto-container">
          <div class="sec-title text-center">
            <h2>How It Works?</h2>
            <div class="text">Job for anyone, anywhere</div>
          </div>
  
          <div class="row">
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
              <div class="inner-box">
                <figure class="image"><img src="{{ asset('assets/images/resource/work-1.png') }}" alt=""></figure>
                <h5>Search our job database</h5>
                <p>Filter through our job protal for jobs that suits your profile.</p>
              </div>
            </div>
  
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
              <div class="inner-box">
                <figure class="image"><img src="{{ asset('assets/images/resource/work-2.png') }}" alt=""></figure>
                <h5>Apply for Job</h5>
                <p>You can apply for a job with "One click" once profile is complete</p>
              </div>
            </div>
  
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
              <div class="inner-box">
                <figure class="image"><img src="{{ asset('assets/images/resource/work-3.png') }}" alt=""></figure>
                <h5>Await Acceptance</h5>
                <p>You get notified all through the steps of the recruitment process.</p>
              </div>
            </div>
  
          </div>
        </div>
    </section>
    <!-- End Work Section -->
@endsection