@extends('layouts.dashboard.app')
@section('content')
    <!-- Dashboard -->
    <section class="user-dashboard">
		<div class="dashboard-outer">
			<div class="upper-title-box">
				<h3>Recruiters</h3>
			</div>
  
			<div class="row">
				<div class="col-lg-12">
					<!-- Ls widget -->
					<div class="ls-widget">
						<div class="tabs-box">
							<div class="widget-title">
								<h4>Recruiters</h4>
                                <div class="chosen-outer">
                                    <!--Tabs Box-->
                                    <div class="search-box-one">
                                        <div class="form-group">
                                            <span class="icon flaticon-search-1"></span>
                                            <input type="search" name="name" value="{{ Request::query('name') }}" placeholder="Search" required="" id="name">
                                        </div>
                                    </div>
									<input type="hidden" value="{{ Request::query('status') ? Request::query('status') : 'all' }}" id="statusValue">
									<select class="chosen-select" onchange="handleSelectChange(event, 'status')" id="statusResult">
										<option value="all">All</option>
										<option value="active">Active</option>
										<option value="disabled">Disabled</option>
									</select>
								</div>
							</div>

                            <div class="widget-content">
                                <div class="table-outer">
                                    <table class="default-table manage-job-table">
                                        <thead>
                                            <tr>
                                                <th>Company Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Verified date</th>
                                                <th>Completion rate</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($recruiters->count() === 0)
												<tr>
													<td colspan="5">
														No records found.
													</td>
												</tr>
											@else
                                                @foreach ($recruiters as $recruiter)
                                                    <tr>
                                                        <td>
                                                            {{ $recruiter->name }}
                                                            <a href="{{ route('pages.recruiter.detail', ['uniqueId' => $recruiter->employerInfo->unique_id, 'name' => $recruiter->name ]) }}">
                                                                <button data-text="View Recruiter"><span class="la la-external-link-alt"></span></button>
                                                            </a>
                                                        </td>
                                                        <td>{{ $recruiter->email }}</td>
                                                        <td>
                                                            @if ($recruiter->status === 'active')
                                                                <span class="label label-success">Active</span>
                                                            @else
                                                                <span class="label label-danger">Disabled</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $recruiter->email_verified_at }}</td>
                                                        <td>
                                                            <div class="ls-show-more m-0">
                                                                <div class="bar m-0" style="width: 100px">
                                                                    <span class="bar-inner" style="width: {{ $recruiter->isComplete }}%"></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($recruiter->status === 'active')
                                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Deactivate Account" 
                                                                    onclick="handleUserStatus(event, '{{ openssl_encrypt($recruiter->id, 'AES-128-ECB', 'FP25Hg9KKNJx') }}', 'disabled')"
                                                                >
                                                                    <i class="la la-user-slash f2x ui-red"></i>
                                                                </a>
                                                            @else
                                                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="Activate Account" 
                                                                    onclick="handleUserStatus(event, '{{ openssl_encrypt($recruiter->id, 'AES-128-ECB', 'FP25Hg9KKNJx') }}', 'active')"
                                                                >
                                                                    <i class="la la-user-check f2x ui-green"></i>
                                                                </a>
                                                            @endif
                                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="Delete Account"
                                                                onclick="handleMemberDelete(event, '{{ openssl_encrypt($recruiter->id, 'AES-128-ECB', 'FP25Hg9KKNJx') }}')"
                                                            >
                                                                <i class="la la-trash colored"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <form method="post" action="{{ route('dashboard.admin.member.status') }}" id="update-status" style="display: none;">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="status" id="userStatus" value="">
                                        <input type="hidden" name="userId" id="userId" value="">
                                        <button class="theme-btn btn-style-three" type="submit">Submit</button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.admin.member.delete') }}" id="delete-member" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="userId" id="memberId" value="">
                                        <button class="theme-btn btn-style-three" type="submit">Submit</button>
                                    </form>
                                    <div class="mb-3">
                                        {{ $recruiters->links('pages.pagination') }}
									</div>
                                    <!-- Listing Show More -->
                                    @if ($recruiters->hasPages())
                                        <div class="ls-show-more mt-0">
                                            <p>Showing {{ number_format($recruiters->lastItem()) }} of {{ number_format($recruiters->total()) }} Recruiters</p>
                                        </div>
                                    @endif
                                </div>
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
        function delay(callback, ms) {
			var timer = 0;
			return function() {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
				callback.apply(context, args);
				}, ms || 0);
			};
		}
        $('#name').keyup(delay(function (e) {
			handleSelectChange(e, 'name')
		}, 1000));
        function handleUserStatus (event, userId, status) {
            event.preventDefault();
            document.getElementById('userId').value = userId;
            document.getElementById('userStatus').value = status;
            if (confirm("Are you sure you want to proceed?")) {
                document.getElementById('update-status').submit();
            }
        }
        function handleMemberDelete (event, userId) {
            event.preventDefault();
            document.getElementById('memberId').value = userId;
            if (confirm("Are you sure you want to proceed? This action cannot be undone")) {
                document.getElementById('delete-member').submit();
            }
        }
        $(document).ready(function () {
			const statusValueElement = document.getElementById("statusValue").value;

			// set the value
			$("#statusResult").val(statusValueElement).trigger("chosen:updated");
			
        });
    </script>
@endsection