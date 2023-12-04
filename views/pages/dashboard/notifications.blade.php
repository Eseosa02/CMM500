@extends('layouts.dashboard.app')
@section('content')
	<!-- Dashboard -->
	<section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Notifications</h3>
			</div>

			<!-- Ls widget -->
			<div class="ls-widget">
				<div class="widget-title">
					<h4>Notifications</h4>
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
					<div class="table-outer">
						<table class="default-table manage-job-table">
							<thead>
								<tr>
									<th>Job Title</th>
									<th>Message</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
                                @foreach ($jobNotifications as $notification)
                                    <tr>
                                        <td>
                                            {{ $notification->jobListing->title }}
                                            <a href="{{ route('pages.jobs.detail', ['uniqueId' => $notification->jobListing->job_reference, 'titleSlug' => $notification->jobListing->title_slug ]) }}">
                                                <button data-text="View Listing"><span class="la la-external-link-alt"></span></button>
                                            </a>
                                        </td>
                                        <td>{{ $notification->message }}</td>
                                        <td>
                                            @if ($notification->status === 'unread') <span class="label label-notification">New</span> @endif
                                            @if ($notification->status === 'read') <span class="label label-success">Read</span> @endif
                                        </td>
                                        <td>
                                            <div class="option-box">
                                                <ul class="option-list">
                                                    @if ($notification->status === 'unread')
                                                        <li>
                                                            <a href="{{ route('dashboard.notification.update', ['mode' => 'read', 'notificationId' => $notification->id]) }}">
                                                                <button data-text="Mark as read"><span class="la la-book-open"></span></button>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="{{ route('dashboard.notification.update', ['mode' => 'delete', 'notificationId' => $notification->id]) }}">
                                                            <button data-text="Delete notification"><span class="la la-trash"></span></button>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
							</tbody>
						</table>
                        <div class="mb-3">
                            {{ $jobNotifications->links('pages.pagination') }}
                        </div>
                        <!-- Listing Show More -->
                        @if ($jobNotifications->hasPages())
                            <div class="ls-show-more mt-0">
                                <p>Showing {{ number_format($jobNotifications->lastItem()) }} of {{ number_format($jobNotifications->total()) }} Job notifications</p>
                            </div>
                        @endif
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Dashboard -->
@endsection