@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
        <div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>My Resume</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
  
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							@if (Auth::user()->isComplete < 50)
								<div class="message-box info">
									<p class="m-0">Complete your <a href="{{ route('dashboard.candidate.profile.index') }}">"My Pofile"</a> to enable this page functionality.</p>
								</div>
							@endif
							<div class="widget-title">
								<h4>My Profile</h4>
							</div>
		
							<div class="widget-content">
								@if (\Session::has('message'))
									<div class="message-box success">
										<p class="m-0">{!! \Session::get('message') !!}</p>
										<button class="close-btn"><span class="close_icon"></span></button>
									</div>
                                @endif
								@if ($errors->count() > 0)
									<div class="message-box error">
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
                                @endif
								<div class="row">
									<div class="form-group col-lg-12 col-md-12">
										<!-- Resume / Education -->
										<div class="resume-outer">
											<div class="upper-title">
												<h4>Education</h4>
												@if (Auth::user()->isComplete >= 50)
													<a href="{{ route('dashboard.candidate.resume.education.index') }}" class="add-info-btn">
														<span class="icon flaticon-plus"></span> Add Education
													</a>
												@endif
											</div>
											@if ($candidateEducations->count() === 0)
												No educational history added.
											@else
												@foreach ($candidateEducations as $education)
													<!-- Resume BLock -->
													<div class="resume-block">
														<div class="inner">
															<span class="name">{{ Str::ucfirst(Str::substr($education->institution,0, 1)) }}</span>
															<div class="title-box">
																<div class="info-box">
																	<h3>{{ $education->title }}</h3>
																	<span>{{ $education->institution }}</span>
																</div>
																<div class="edit-box">
																	<span class="year">{{ $education->start_date->format('Y') }} - {{ $education->end_date->format('Y') }}</span>
																	<div class="edit-btns">
																		<a href="{{ route('dashboard.candidate.resume.education.index', ['edit' => $education->id]) }}">
																			<button><span class="la la-pencil"></span></button>
																		</a>
																		<a href="{{ route('dashboard.candidate.resume.education.index', ['trash' => $education->id]) }}">
																			<button><span class="la la-trash"></span></button>
																		</a>
																	</div>
																</div>
															</div>
															<div class="text">{{ Str::ucfirst($education->grade) }}</div>
														</div>
													</div>
												@endforeach
											@endif
										</div>
			
										<!-- Resume / Work & Experience -->
										<div class="resume-outer theme-blue">
											<div class="upper-title">
												<h4>Work & Experience</h4>
												@if (Auth::user()->isComplete >= 50)
													<a href="{{ route('dashboard.candidate.resume.experience.index') }}" class="add-info-btn">
														<span class="icon flaticon-plus"></span> Add Work Experience
													</a>
												@endif
											</div>
											@if ($candidateExperiences->count() === 0)
												No work experience history added.
											@else
												@foreach ($candidateExperiences as $experience)
													<!-- Resume BLock -->
													<div class="resume-block">
														<div class="inner">
															<span class="name">{{ Str::ucfirst(Str::substr($experience->institution,0, 1)) }}</span>
															<div class="title-box">
																<div class="info-box">
																	<h3>{{ $experience->title }}</h3>
																	<span>{{ $experience->institution }}</span>
																</div>
																<div class="edit-box">
																	<span class="year">{{ $experience->start_date->format('Y') }} - {{ $experience->is_present ? 'Present' : $experience->end_date->format('Y') }}</span>
																	<div class="edit-btns">
																		<a href="{{ route('dashboard.candidate.resume.experience.index', ['edit' => $experience->id]) }}">
																			<button><span class="la la-pencil"></span></button>
																		</a>
																		<a href="{{ route('dashboard.candidate.resume.experience.index', ['trash' => $experience->id]) }}">
																			<button><span class="la la-trash"></span></button>
																		</a>
																	</div>
																</div>
															</div>
															<div class="text">{{ $experience->description }}</div>
														</div>
													</div>
												@endforeach
											@endif
										</div>
									</div>
								</div>
								@if ($skillsRating)
									<form class="default-form" method="post" action="{{ route('dashboard.candidate.resume.update') }}">
										@csrf
										@method('POST')
										<div class="row">
											<div class="tabs-box">
												<div class="widget-title -no-padding">
													<h4>Skills</h4>
												</div>
											</div>
											<input type="hidden" id="ratings" value="{{ json_encode($skillsRating) }}">
											@foreach ($skillsRating as $key => $skill)
												<!-- Input -->
												<div class="form-group col-lg-6 col-md-12">
													<input type="hidden" name="skills[]" value="{{ $key }}">
													<input type="text" value="{{ $key }}" disabled>
												</div>
												<!-- Select -->
												<div class="form-group col-lg-6 col-md-12">
													<input type="hidden" value="{{ $skill }}" id="skillValue-{{ $key }}">
													<select class="chosen-select" name="ratings[]" value="{{ $skill }}" id="skillResult-{{ $key }}">
														<option value="1">⭐️</option>
														<option value="2">⭐️⭐️</option>
														<option value="3">⭐️⭐️⭐️</option>
														<option value="4">⭐️⭐️⭐️⭐️</option>
														<option value="5">⭐️⭐️⭐️⭐️⭐️</option>
													</select>
												</div>
											@endforeach
										</div>
										<!-- Input -->
										<div class="form-group col-lg-12 col-md-12">
											<button class="theme-btn btn-style-one" type="submit">Save</button>
										</div>
									</form>
								@endif
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
			const ratings = JSON.parse(document.getElementById("ratings").value);
			const ratingsKey = Object.keys(ratings)
			
			ratingsKey.forEach(element => {
				const rating = document.getElementById(`skillValue-${element}`).value;
				$(`#skillResult-${element}`).val(rating).trigger("chosen:updated");
			});
        });
    </script>
@endsection