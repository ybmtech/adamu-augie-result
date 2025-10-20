@extends(backendView('layouts.app'))

@section('title', 'Register Course')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-1 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Register Course</h3>
			</div>
		</div>
	</div> <!-- Row end  -->

	<div class="row align-item-center">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
					<h6 class="mb-0 fw-bold ">Register Course</h6>
				</div>
				<div class="card-body">
					<form method="POST" action="{{route('student-courses.store')}}">
                        @csrf
                     	<div class="row g-3 align-items-center">
                            
                            <div class="col-md-4">
								<label for="course" class="form-label">Course</label>
								<select class="form-select" name="course" id="course" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($courses as $course)
                                    <option value="{{$course->id}}" data-unit="{{$course->unit}}" data-code="{{$course->code}}">{{ucwords($course->title)}}</option>  
                                  @endforeach
                                </select>
                                <span class="text-danger">@error('course') {{ $message }}@enderror</span>
							</div>

                            <div class="col-md-4">
								 <label for="course_unit" class="form-label">Course Code</label>
								<input type="text" class="form-control"  id="course_code" readonly>
							</div>

                            <div class="col-md-4">
								<label for="course_unit" class="form-label">Course Unit</label>
								<input type="text" class="form-control"  id="course_unit" readonly>
							</div>

                            <div class="col-md-12">
								<label for="semester" class="form-label">Semester</label>
								<select class="form-select" name="semester" id="semester" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->id}}">{{$semester->name}}</option>  
                                  @endforeach
                                </select>
                                <span class="text-danger">@error('semester') {{ $message }}@enderror</span>
							</div>
							
				
						</div>

						<center><button type="submit" class="btn btn-primary mt-4">Add Course</button></center>
					</form>
				</div>
			</div>
			

            <div class="card mb-3">
				<div class="card-header py-3  bg-transparent border-bottom-0">
					<h6 class="mb-0 fw-bold text-center text-uppercase">Registered Courses</h6>
				</div>
				<div class="card-body">
					<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width: 100%;">
						<thead>
							<tr>
								<th>#</th>
								<th>Course Title</th>
								<th>Course Code</th>
								<th>Course Unit</th>
								<th>Semester</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						@forelse ($student_courses as $student_course)
                           <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ucwords($student_course->course->title)}}</td>
                            <td>{{$student_course->course->code}}</td>
                            <td>{{$student_course->course->unit}}</td>
                            <td>{{$student_course->semester->name}}</td>
                            <td><button title="Delete" type="button" id="{{ str_shuffle('0123456789').$student_course->id }}" class="btn btn-outline-info deleterow"><i class="icofont-ui-delete text-danger"></i></button>
							</td>
                            </tr> 
                        @empty
                            
                        @endforelse
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div><!-- Row end  -->

</div>
@endsection

@push('styles')
<!-- plugin css file  -->
<link rel="stylesheet" href="{!! backendAssets('dist/assets/plugin/parsleyjs/css/parsley.css') !!}">
<!-- plugin css file  -->
<link rel="stylesheet" href="{!! backendAssets('dist/assets/plugin/datatables/responsive.dataTables.min.css') !!}">
<link rel="stylesheet" href="{!! backendAssets('dist/assets/plugin/datatables/dataTables.bootstrap5.min.css') !!}">
@endpush

@push('custom_styles')
@endpush

@push('scripts')
<!-- Plugin Js-->
<script src="{!! backendAssets('dist/assets/bundles/dataTables.bundle.js') !!}"></script>
<script src="{!! backendAssets('dist/assets/plugin/parsleyjs/js/parsley.js') !!}"></script>
@endpush

@push('custom_scripts')
<script>
	$(function() {
		// initialize after multiselect
		$('#basic-form').parsley();
	});
</script>

<script>
	$(document).ready(function() {
		$('#myProjectTable')
			.addClass('nowrap')
			.dataTable({
				responsive: true,
				columnDefs: [{
					targets: [-1, -3],
					className: 'dt-body-right'
				}]
			});

            $("body").on('click','.deleterow', function(evenet) {
			$("#expdel").modal('show');
        let id = $(this).attr('id');
      	$('#id').val(id);
    
		});

            $('#course').on('change',function(){
                var code=$("select#course").children("option:selected").data('code');
                var unit=$("select#course").children("option:selected").data('unit');
                $("#course_code").val(code);
                $("#course_unit").val(unit);
             
            });

	});
</script>
@endpush

@push('modals')
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
					<form method="POST" action="{{ route('student-courses.delete') }}">
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