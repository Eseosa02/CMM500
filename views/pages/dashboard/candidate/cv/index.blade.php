@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>CV Manager</h3>
				<div class="text">Ready to jump back in?</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<!-- CV Manager Widget -->
					<div class="cv-manager-widget ls-widget">
						@if (Auth::user()->isComplete < 90)
							<div class="message-box info">
								<p class="m-0">Complete your <a href="{{ route('dashboard.candidate.profile.index') }}">"My Resume"</a> to boost your profile up to 90% to enable CV Manager.</p>
							</div>
						@endif
						<div class="widget-content">
							<div class="files-outer pl-5">
								@if ($candidateCvs->count() === 0)
									<p class="pt-3">No CVs uploaded yet.</p>
								@else
									@foreach ($candidateCvs as $cv)
										<div class="file-edit-box mt-4">
											<span class="title">{{ $cv->title }} {{ $cv->is_default === 1 ? '(Default)' : '' }}</span>
											<div class="edit-btns">
												<a href="{{ asset($cv->attachment) }}" target="_blank"><span class="la la-external-link-alt"></span></a>
												@if ($cv->is_default !== 1)
												<a href="{{ route('dashboard.candidate.cv.update', ['is_default' => $cv->id]) }}"><span class="la la-star" data-toggle="tooltip" data-placement="bottom" title="Set as Default"></span></a>
												@endif
												<a href="#" onclick="event.preventDefault(); document.getElementById('cvDelete-form-{{ $cv->id }}').submit();"><span class="la la-trash"></span></a>
												<form method="post" action="{{ route('dashboard.candidate.cv.delete', ['cvId' => $cv->id]) }}" id="cvDelete-form-{{ $cv->id }}"  style="display: none;">
													@csrf
													@method('DELETE')
													<button class="theme-btn btn-style-three" type="submit">Delete CV</button>
												</form>
											</div>
										</div>
									@endforeach
								@endif
							</div>
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
							@if (Auth::user()->isComplete >= 90)
								<div class="widget-title p-0">
									<h4>Upload CV</h4>
								</div>
								<form class="default-form" action="{{ route('dashboard.candidate.cv.update') }}" method="POST" enctype="multipart/form-data">
									@csrf
									@method('POST')
									<div class="row">
										<!-- Input -->
										<div class="form-group col-lg-12 col-md-12">
											<label>Title <span class="required">*</span></label>
											<input type="text" name="title" value="{{ old('title') }}" placeholder="Title">
										</div>

										<div class="form-group col-lg-12 col-md-12">
											<div class="uploading-resume">
												<div class="uploadButton">
													<input class="uploadButton-input" type="file" name="attachment" accept="application/pdf" id="upload" />
													<label class="cv-uploadButton" for="upload">
														<span class="title">Drop files here to upload</span>
														<span class="text">To upload file size is (Max 5Mb) and allowed file types is .pdf</span>
														<span class="theme-btn btn-style-one">Upload Resume</span>
													</label>
													<span class="uploadButton-file-name"></span>
												</div>
											</div>
										</div>
										
										<!-- Input -->
										<div class="form-group col-lg-12 col-md-12">
											<ul class="switchbox">
												<li>
													<label class="switch">
														<input type="checkbox" name="is_default">
														<span class="slider round"></span>
														<span class="title">Use as default</span>
													</label>
												</li>
											</ul>
										</div>
										
										<!-- Input -->
										<div class="form-group col-lg-12 col-md-12">
											<button class="theme-btn btn-style-four" type="submit" name="submit">Upload & Save</button>
										</div>
									</div>
								</form>
							@endif
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
			
        });
    </script>
@endsection