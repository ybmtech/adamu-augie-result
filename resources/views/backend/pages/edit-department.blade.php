@extends(backendView('layouts.app'))

@section('title', 'Edit Department')

@section('content')
<div class="container-xxl">
	<div class="row align-items-center">
		<div class="border-0 mb-4">
			<div class="card-header py-1 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
				<h3 class="fw-bold mb-0">Edit Department</h3>
			</div>
		</div>
	</div> <!-- Row end  -->

	<div class="row align-item-center">
		<div class="col-md-12">
			<div class="card mb-3">
				<div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
					<h6 class="mb-0 fw-bold ">Edit Department</h6>
				</div>
                
				<div class="card-body">
                    <form action="{{route('department.edit')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                    <label for="department_name" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="department_name" name="department_name" value="{{ @old('department_name') ?? $department->name }}">
                    @error('department_name')
                    <span class="text-danger">{{ $message }}</span>	
                    @enderror
                </div>

    
                  <input type="hidden" value="{{$department->id}}" name="id">
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