@extends('layouts.app')
@section('content')
    <!-- TNC Section -->
    <section class="tnc-section">
        <div class="auto-container">
			<div class="sec-title text-center">
				<h2>Data Policy</h2>
				<div class="text">Home / Data Policy</div>
			</div>
			
			<div class="text-box">
				<p>
					<strong><i>Last updated: November, 2023</i></strong>
				</p>
			</div>

			<div class="text-box">
				<p>{{ env('APP_NAME') }} Ltd is the operator of a {{ env('APP_NAME') }} job application portal. </p>
				<p>
					This webpage provides information on our policies pertaining to the acquisition, utilisation, and dissemination of personal data when utilising our Service, as well as the options available to you in relation to said data.</p>
				<p>
					The data provided by users is utilised for the purpose of delivering and enhancing the Service. Upon utilising the Service, you hereby consent to the gathering and utilisation of data in accordance with the terms outlined in this policy.
				</p>
			</div>
	
			<div class="text-box">
				<h3>THE PROCESS OF GATHERING AND UTILISING DATA</h3>
				<p>We gather a diverse range of information for various objectives to deliver and enhance our Service to you.</p>
				<p>
					There are various categories of data that are collected, one of which is personal data. During the utilisation of our Service, it may be necessary for us to request specific personally identifiable information from you. This information is intended to facilitate communication with you or to establish your identity ("Personal Data"). The category of personally identifiable information encompasses a range of data points, which may include, but are not necessarily restricted to:
				</p>
				<p>
					The user's request pertains to the provision of an email address. <br>
					Given name and surname. <br>
					Contact Information: - Phone Number - Address (including State/Province, ZIP/Postal Code, and City) <br>Data Collection: - Cookies and Usage Data
				</p>
			</div>
  
			<div class="text-box">
				<h3>THE DATA THAT IS COLLECTED BY {{ env('APP_NAME') }}</h3>
				<p>
					Controllers are required to possess a lawful justification for the processing of information, as mandated by relevant data protection legislation in the European Economic Area (EEA). This signifies that our organisation utilises several legal foundations for the processing of your information, which is contingent upon the specific goal of processing as delineated in this Privacy Policy. 
				</p>
				<p>
					Below, we provide comprehensive information regarding the various categories of personal data that we acquire from individuals, the specific objectives for which we process this data, the operations involved in our processing activities, and a thorough account of the legal foundations on which we rely in accordance with the General Data Protection Regulation (GDPR).
				</p>
			</div>
  
  
			<div class="text-box">
				<h3>THE PRESERVATION OF YOUR INFORMATION</h3>
				<p>
					When {{ env('APP_NAME') }} assumes the role of a controller for your Personal Data, we will retain your data until it is no longer necessary to accomplish its intended purpose, as mandated by relevant legislation, or until you request its deletion.
				</p>
				<p>
					The duration for which we retain your information, pertaining to each specific purpose, is delineated in the subsequent section. When evaluating the suitable durations for retaining data, we consider the objectives for which we handle Personal Data and assess whether those objectives may be accomplished using alternative methods. Additionally, we consider the scope, characteristics, and confidentiality of Personal Data, as well as our legal responsibilities pertaining to data. To enhance our Sites, {{ env('APP_NAME') }} takes measures to anonymize or aggregate Personal Data, based on our legitimate interest. This ensures that the data can no longer be linked to or identify an individual user. In such cases, {{ env('APP_NAME') }} can proceed with further processing of the information. As an illustration, anonymised job seeker data, including resume or profile data, may be utilised to assess the precision of our products and services. An additional application of anonymized data involves ensuring equitable employment opportunities using technology.
				</p>
				<p>
					When {{ env('APP_NAME') }} assumes the role of a processor for your personal data, we retain this data until the controller instructs us to remove
				</p>
			</div>
        </div>
    </section>
    <!-- End TNC Section -->
@endsection