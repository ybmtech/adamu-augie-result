@extends(backendView('layouts.app'))

@section('title', 'Courses')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Courses</h3>
				<div class="col-auto d-flex w-sm-100">
					<button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#expadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Course</button>
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
								<th>Title</th>
								<th>Code</th>
								<th>Unit</th>
							   <th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($courses as $course)
							<tr>
								<td>
									<strong>{{ $loop->iteration }}</strong>
								</td>
									<td class="font-weight-bold text-capitalize">
									{{ ucwords($course->title) }}
								</td>
								<td>
									{{ ucwords($course->code)}}
								</td>

								<td>
									{{ $course->unit}}
								</td>
								
							
								<td>
									<div class="btn-group" role="group" aria-label="Basic outlined example">
										<a href="{{route('course.show', str_shuffle('0123456789').$course->id )}}" class="btn btn-primary">Edit</a>
										<button title="Delete" type="button" id="{{ str_shuffle('0123456789').$course->id }}" class="btn btn-outline-info deleterow"><i class="icofont-ui-delete text-danger"></i>Delete</button>
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
<!-- Add course-->
<div class="modal fade" id="expadd" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expaddLabel"> Add Course</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				
				<div class="deadline-form">
					<form action="{{ route('course.store') }}" method="POST">
                      @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ @old('title') }}">
							@error('title')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Code<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code" value="{{ @old('code') }}">
							@error('code')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Unit<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="unit" name="unit" value="{{ @old('unit') }}">
							@error('unit')
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


<!-- Delete Course-->
<div class="modal fade" id="expdel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expeditLabel"> Delete Course</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
             <p>Are you sure, you want to delete this course?</p>
				<div class="deadline-form">
					<form method="POST" action="{{ route('course.delete') }}">
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