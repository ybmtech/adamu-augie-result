@extends(backendView('layouts.app'))

@section('title', 'Upload Result')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-1 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Upload Result</h3>
			</div>
		</div>
	</div> <!-- Row end  -->

	<div class="row align-item-center">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
					<h6 class="mb-0 fw-bold ">Upload Result</h6>
				</div>
				<div class="card-body">
					<form method="POST" action="{{route('result.upload.process')}}" enctype="multipart/form-data">
                        @csrf
                     	<div class="row g-3 align-items-center">
                            
							<div class="col-md-6">
								<label for="firstname" class="form-label">Session</label>
								<select class="form-select" name="session" required>
                                    <option value="" selected disabled>Select</option>
                                    @foreach ($sessions as $session)
                                      <option value="{{$session->id}}" {{($session->active=="yes")? "selected" : ""}}>{{$session->name}}</option>  
                                    @endforeach
                                </select>
                                <span class="text-danger">@error('session') {{ $message }}@enderror</span>
							</div>
							
							<div class="col-md-6">
								<label for="firstname" class="form-label">Semester</label>
								<select class="form-select" name="semester" required>
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

                            <div class="col-md-6">
								<label for="result" class="form-label">Result (csv)</label>
								<input class="form-control" type="file" name="result" id="result" accept=".csv" required>
                             <span class="text-danger">@error('result') {{ $message }}@enderror</span>
							</div>
							
				
						</div>

						<center><button type="submit" class="btn btn-primary mt-4">Upload</button></center>
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
@endpush

@push('custom_styles')
@endpush

@push('scripts')
<!-- Plugin Js-->
<script src="{!! backendAssets('dist/assets/plugin/parsleyjs/js/parsley.js') !!}"></script>
@endpush

@push('custom_scripts')
<script>
	$(function() {
		// initialize after multiselect
		$('#basic-form').parsley();
	});
</script>
@endpush

@push('modals')
@endpush