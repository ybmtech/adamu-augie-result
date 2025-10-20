@extends(backendView('layouts.app'))

@section('title', 'Students')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Students</h3>
				<div class="col-auto d-flex w-sm-100">
					<button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#expadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Student</button>
				</div>
			</div>
		</div>
	</div> <!-- Row end  -->
	<div class="row clearfix g-3">
		<div class="col-sm-12">
			<div class="card mb-3">
				<div class="card-body">
                    <div class="table-responsive">
					<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Name</th>
								<th>Admission No.</th>
								<th>Department</th>
								<th>Level</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Status</th>
								<th>Registered Date</th>
								<th>Last Updated Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($students as $student)
							<tr>
								<td>
									<strong>{{ $loop->iteration }}</strong>
								</td>
									<td class="font-weight-bold text-capitalize">
									{{ ucwords($student->name) }}
								</td>
								<td>
									{{ $student->profile->admission_no }}
								</td>

								<td>
									{{ $student->profile->department->name }}
								</td>
								<td>
									{{ $student->profile->level->name }}
								</td>
								
								<td>
									{{ $student->email }}
								</td>

								<td>
									{{ $student->profile->phone }}
								</td>

								<td>
									@if($student->status=="active")
									<span class="badge bg-success">{{ $student->status }}</span>
									@else
									<span class="badge bg-danger">{{ $student->status }}</span>
									@endif
								</td>
								
								<td>
									{{ date('l d F Y',strtotime($student->created_at)) }}
								</td>
								<td>
									{{ date('l d F Y',strtotime($student->updated_at)) }}
								</td>
							
								<td>
									<div class="btn-group" role="group" aria-label="Basic outlined example">
										<a href="{{route('user.show', str_shuffle('0123456789').$student->id )}}" class="btn btn-outline-primary">Edit</a>
										<button title="{{ ($student->status=="active") ? "Disable Student" : "Enable Student" }}" type="button" id="{{ str_shuffle('0123456789').$student->id }}" data-status="{{ $student->status }}" class="btn btn-outline-secondary status">{!! ($student->status=='active') ? '<i class="icofont-ui-lock text-warning"></i>Disable' : '<i class="icofont-ui-check text-success"></i> Active' !!}</button>
								
										<button title="Delete" type="button" id="{{ str_shuffle('0123456789').$student->id }}" class="btn btn-outline-info deleterow"><i class="icofont-ui-delete text-danger"></i>Delete</button>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
                </div>
				</div>
			</div>
		</div>
	</div><!-- Row End -->
</div>
@endsection

@push('styles')
<!-- plugin css file  -->
<link rel="stylesheet" href="{!! backendAssets('dist/assets/plugin/datatables/responsive.dataTables.min.css') !!}">
<link rel="stylesheet" href="{!! backendAssets('dist/assets/plugin/datatables/dataTables.bootstrap5.min.css') !!}">
@endpush

@push('custom_styles')
@endpush

@push('scripts')
<!-- Plugin Js-->
<script src="{!! backendAssets('dist/assets/bundles/dataTables.bundle.js') !!}"></script>
@endpush

@push('custom_scripts')
<script>
	// project data table
	$(document).ready(function() {
		$('#myProjectTable').dataTable();

		$("body").on('click','.deleterow', function(evenet) {
			$("#expdel").modal('show');
        let id = $(this).attr('id');
      	$('#id2').val(id);
    
		});

		$("body").on('click','.status', function(evenet) {
			$("#expstatus").modal('show');
        let id = $(this).attr('id');
        let user_status = $(this).data('status');
		if(user_status=="active"){
			var status="disable";
		}
		else{
			var status="active";
		}
      	$('#id3').val(id);
		 $('.status-head').text(status + " Student");
		$('#status-message').text('Are you sure, you want to '+status+ ' this student');
      	$('#status').val(user_status);
    
		});

	});
</script>
@endpush

@push('modals')
<!-- Add student-->
<div class="modal fade" id="expadd" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expaddLabel"> Add Student</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				
				<div class="deadline-form">
					<form action="{{ route('user.store') }}" method="POST">
                      @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ @old('name') }}">
							@error('name')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Admission Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="admission_number" name="admission_number" value="{{ @old('admission_number') }}">
							@error('admission_number')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>


						<div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ @old('email') }}">
							@error('email')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>

							<div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ @old('phone') }}">
							@error('phone')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>
						
						 <div class="mb-3">
                            <label for="department" class="form-label">Department<span class="text-danger">*</span></label>
                            <select class="form-select" id="department" name="department">
                            <option value="" selected disabled>Select</option>
							@foreach($departments as $department)
								<option value="{{ $department->id }}" {{(@old('department')==$department->id) ? "selected" : "" }}>{{ $department->name }}</option>
								@endforeach
                            </select>
							@error('department')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>

                        <div class="mb-3">
                            <label for="level" class="form-label">Level<span class="text-danger">*</span></label>
                            <select class="form-select" id="level" name="level">
                            <option value="" selected disabled>Select</option>
							@foreach($levels as $level)
								<option value="{{ $level->id }}" {{(@old('level')==$level->id) ? "selected" : "" }}>{{ $level->name }}</option>
								@endforeach
                            </select>
							@error('level')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>

						<div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password">
							@error('password')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>

						<div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm password<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
							@error('password_confirmation')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>
                    
					
				</div>

			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Add</button>
			</form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- Delete Student-->
<div class="modal fade" id="expdel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expeditLabel"> Delete Student</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
             <p>Are you sure, you want to delete this student?</p>
				<div class="deadline-form">
					<form method="POST" action="{{ route('user.delete') }}">
						@csrf
						@method('DELETE')
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" id="id2" name="user_id">
				<button type="submit" class="btn btn-primary" >Yes</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
			</form>
			</div>
		</div>
	</div>
</div>


<!-- Change Status -->
<div class="modal fade" id="expstatus" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold status-head text-capitalize" id="expeditLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
             <p id="status-message"></p>
				<div class="deadline-form">
					<form method="POST" action="{{ route('user.status') }}">
						@csrf
						@method('PUT')
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" id="id3" name="user_id">
				<input type="hidden" id="status" name="status">
				<button type="submit" class="btn btn-primary text-capitalize" >Yes</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
			</form>
			</div>
		</div>
	</div>
</div>
@endpush