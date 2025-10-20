@extends(backendView('layouts.app'))

@section('title', 'Edit Student Information')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-1 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Edit Student Information</h3>
			</div>
		</div>
	</div> <!-- Row end  -->

	<div class="row align-item-center">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
					<h6 class="mb-0 fw-bold ">Edit Student Information</h6>
				</div>
                
				<div class="card-body">
                    <form action="{{route('user.edit')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ @old('name') ?? $student->name }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>	
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Admission Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="admission_number" name="admission_number" value="{{ @old('admission_number') ?? $student->profile->admission_no }}">
                    @error('admission_number')
                    <span class="text-danger">{{ $message }}</span>	
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ @old('email') ?? $student->email }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>	
                    @enderror
                </div>

                 <div class="mb-3">
                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ @old('phone') ?? $student->profile->phone }}">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>	
                    @enderror
                </div>
                

                <div class="mb-3">
                    <label for="department" class="form-label">Department<span class="text-danger">*</span></label>
                    <select class="form-select" id="department" name="department">
                    <option value="" selected disabled>Select</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{(@old('department') ?? $student->profile->department_id==$department->id) ? "selected" : "" }}>{{ $department->name }}</option>
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
                        <option value="{{ $level->id }}" {{(@old('level') ?? $student->profile->level_id==$level->id) ? "selected" : "" }}>{{ $level->name }}</option>
                        @endforeach
                    </select>
                    @error('level')
                    <span class="text-danger">{{ $message }}</span>	
                    @enderror
                </div>
                
                  <input type="hidden" value="{{$student->id}}" name="id">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
            </form>
        </div>

    </div>
    
        
   
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