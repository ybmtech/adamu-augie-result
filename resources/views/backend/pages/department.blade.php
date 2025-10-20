@extends(backendView('layouts.app'))

@section('title', 'Departments')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Departments</h3>
				<div class="col-auto d-flex w-sm-100">
					<button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#expadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Department</button>
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
							   <th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($departments as $department)
							<tr>
								<td>
									<strong>{{ $loop->iteration }}</strong>
								</td>
									<td class="font-weight-bold text-capitalize">
									{{ ucwords($department->name) }}
								</td>
								
								
							
								<td>
									<div class="btn-group" role="group" aria-label="Basic outlined example">
										<a href="{{route('department.show', str_shuffle('0123456789').$department->id )}}" class="btn btn-primary">Edit</a>
										<button title="Delete" type="button" id="{{ str_shuffle('0123456789').$department->id }}" class="btn btn-outline-info deleterow"><i class="icofont-ui-delete text-danger"></i>Delete</button>
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
      	$('#id').val(id);
    
		});


	});
</script>
@endpush

@push('modals')
<!-- Add Department-->
<div class="modal fade" id="expadd" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expaddLabel"> Add Department</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				
				<div class="deadline-form">
					<form action="{{ route('department.store') }}" method="POST">
                      @csrf
                        <div class="mb-3">
                            <label for="department_name" class="form-label">Department Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="department_name" name="department_name" value="{{ @old('department_name') }}">
							@error('department_name')
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


<!-- Delete Department-->
<div class="modal fade" id="expdel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expeditLabel"> Delete Department</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
             <p>Are you sure, you want to delete this department?</p>
				<div class="deadline-form">
					<form method="POST" action="{{ route('department.delete') }}">
						@csrf
						@method('DELETE')
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" id="id" name="id">
				<button type="submit" class="btn btn-primary" >Yes</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
			</form>
			</div>
		</div>
	</div>
</div>

@endpush