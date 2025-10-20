@extends(backendView('layouts.app'))

@section('title', 'Check Results')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-1 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Check Results</h3>
			</div>
		</div>
	</div> <!-- Row end  -->

	<div class="row align-item-center">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
					<h6 class="mb-0 fw-bold ">Check Results</h6>
				</div>
				<div class="card-body">
					<form method="GET" action="{{route('result.check')}}">
                      	<div class="row g-3 align-items-center">
                            
							<div class="col-md-4">
								<label for="session" class="form-label">Session</label>
								<select class="form-select" name="session" id="session" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($sessions as $session)
                                      <option value="{{$session->id}}" {{($session->active=="yes")? "selected" : ""}}>{{$session->name}}</option>  
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('session') {{ $message }}@enderror</span>
							</div>
							
							<div class="col-md-4">
								<label for="semester" class="form-label">Semester</label>
								<select class="form-select" name="semester" id="semester" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($semesters as $semester)
                                    <option value="{{$semester->id}}" {{($semester->active=="yes")? "selected" : ""}}>{{$semester->name}}</option>  
                                  @endforeach
                                </select>
                                <span class="text-danger">@error('semester') {{ $message }}@enderror</span>
							</div>


                            <div class="col-md-4">
								<label for="level" class="form-label">Level</label>
								<select class="form-select" name="level" id="level" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($levels as $level)
                                    <option value="{{$level->id}}" {{$current_level==$level->id ? "selected" : ""}}>{{ucwords($level->name)}}</option>  
                                  @endforeach
                                </select>
                                <span class="text-danger">@error('level') {{ $message }}@enderror</span>
							</div>
							
				
						</div>

						<center><button type="submit" class="btn btn-primary mt-4">Fetch</button></center>
					</form>
				</div>
			</div>
			

            <div class="card mb-3">
				<div class="card-header py-3  bg-transparent border-bottom-0">
					@if($seleted_session !==null && $seleted_semester!==null && $seleted_level!==null)<h6 class="mb-0 fw-bold text-center text-uppercase">{{$seleted_session->name}} {{$seleted_level->name}} Level {{$seleted_semester->name}} Semester Results</h6>@endif
					</div>
				<div class="card-body">
					<table id="myProjectTable" class="table table-hover align-middle mb-0" style="width: 100%;">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Course Title</th>
								<th>Course Code</th>
								<th>Course Unit</th>
								<th>Score</th>
								<th>Grade</th>
								
							</tr>
						</thead>
						<tbody>
							@forelse ($registered_student_courses as $registered_course)
						    <tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ucwords($registered_course->course->title)}}</td>
							<td>{{ucwords($registered_course->course->code)}}</td>
							<td>{{$registered_course->course->unit}}</td>
							<td>{{$registered_course->score}}</td>
							<td>{{$registered_course->grade}}</td>
							
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

			$("body").on('click','.edit', function(evenet) {
			$("#expedit").modal('show');
        let id = $(this).attr('id');
        let score = $(this).data('score');
      	$('#id').val(id);
      	$('#score').val(score);
    
		});
			
		$("body").on('click','.deleterow', function(evenet) {
			$("#expdel").modal('show');
        let id = $(this).attr('id');
      	$('#id2').val(id);
    
		});

		$("body").on('click','.status', function(evenet) {
			$("#expstatus").modal('show');
        let id = $(this).attr('id');
        let result_status = $(this).data('status');
		if(result_status=="release"){
			var status="pending";
		}
		else{
			var status="release";
		}
      	$('#id3').val(id);
		 $('.status-head').text(status + " Result");
		$('#status-message').text('Are you sure, you want to '+status+ ' this result');
      	$('#status').val(result_status);
    
		});
	});
</script>
@endpush

@push('modals')

<!-- Edit-->
<div class="modal fade" id="expedit" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expeditLabel"> Edit Result</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
            	<div class="deadline-form">
					<form method="POST" action="{{ route('result.edit') }}">
						@csrf
						@method('PUT')
						<div class="mb-3">
							<label for="score" class="form-label">Score <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="score" name="score" value="{{ @old('score') }}" data-type="decimal">
							@error('score')
							<span class="text-danger">{{ $message }}</span>	
							@enderror
						</div>
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" id="id" name="id">
				<button type="submit" class="btn btn-primary" >Update</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</form>
			</div>
		</div>
	</div>
</div>

<!-- Delete-->
<div class="modal fade" id="expdel" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title  fw-bold" id="expeditLabel"> Delete Result</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
             <p>Are you sure, you want to delete this result?</p>
				<div class="deadline-form">
					<form method="POST" action="{{ route('result.delete') }}">
						@csrf
						@method('DELETE')
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" id="id2" name="id">
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
					<form method="POST" action="{{ route('result.status') }}">
						@csrf
						@method('PUT')
				</div>

			</div>
			<div class="modal-footer">
				<input type="hidden" id="id3" name="id">
				<input type="hidden" id="status" name="status">
				<button type="submit" class="btn btn-primary text-capitalize" >Yes</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
			</form>
			</div>
		</div>
	</div>
</div>
@endpush