@extends(backendView('layouts.app'))

@section('title', 'Add Result')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-1 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Add Result</h3>
			</div>
		</div>
	</div> <!-- Row end  -->

	<div class="row align-item-center">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
					<h6 class="mb-0 fw-bold ">Add Result</h6>
				</div>
				<div class="card-body">
					<form method="GET" action="{{route('result.add.view')}}">
                       	<div class="row g-3 align-items-center">
                            
							<div class="col-md-3">
								<label for="session" class="form-label">Session</label>
								<select class="form-select" name="session" id="session" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($sessions as $session)
                                      <option value="{{$session->id}}" {{($session->active=="yes")? "selected" : ""}}>{{$session->name}}</option>  
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('session') {{ $message }}@enderror</span>
							</div>
							
							<div class="col-md-3">
								<label for="semester" class="form-label">Semester</label>
								<select class="form-select" name="semester" id="semester" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->id}}" {{($semester->active=="yes")? "selected" : ""}}>{{$semester->name}}</option>  
                                  @endforeach
                                </select>
                                <span class="text-danger">@error('semester') {{ $message }}@enderror</span>
							</div>

                            <div class="col-md-6">
								<label for="course" class="form-label">Course</label>
								<select class="form-select" name="course" id="course" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($courses as $course)
                                    <option value="{{$course->id}}">{{ucwords($course->title)." - ".$course->code}}</option>  
                                  @endforeach
                                </select>
                                <span class="text-danger">@error('course') {{ $message }}@enderror</span>
							</div>
							
				
						</div>

						<center><button type="submit" class="btn btn-primary mt-4">Fetch</button></center>
					</form>
				</div>
			</div>
			

            <div class="card mb-3">
				<div class="card-header py-3  bg-transparent border-bottom-0">
					@if($seleted_session !==null && $seleted_semester!==null && $seleted_course!==null)<h6 class="mb-0 fw-bold text-center text-uppercase">Add {{$seleted_session->name}} {{$seleted_semester->name}} Semester {{$seleted_course->code}} Results</h6>@endif
				</div>
				<div class="card-body">
					<form action="{{route('result.add')}}" method="POST">
						@csrf
					<table id="myProjectTables" class="table table-hover align-middle mb-0" style="width: 100%;">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Student Name</th>
								<th>Admission No.</th>
								<th>Level</th>
								<th>Score</th>
							</tr>
						</thead>
						<tbody>
						@forelse ($registered_student_courses as $registered_course)
						    <tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ucwords($registered_course->user->name)}}</td>
							<td>{{ucwords($registered_course->user->profile->admission_no)}}</td>
							<td>{{$registered_course->user->profile->level->name}}</td>
							<td><input type="text" name="score[]" data-type="decimal" value="{{$registered_course->score}}" autocomplete="off"></td>
							<input type="hidden" name="id[]" value="{{$registered_course->id}}">
							</tr>
						@empty
							
						@endforelse
						</tbody>
					</table>
					@if(count($registered_student_courses) > 0)<center><button type="submit" class="btn btn-primary mt-4">Add</button></center>@endif
					</form>
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
	});
</script>
@endpush

@push('modals')
@endpush