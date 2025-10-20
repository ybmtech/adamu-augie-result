@extends(backendView('layouts.app'))

@section('title', 'Dashboard')

@section('content')
<div class="container-xxl">


	<div class="row g-3">
		<div class="col-lg-12 col-md-12">
         <h3 class="text-uppercase">WELCOME TO Adamu Augie College of Education RESULT PORTAL</h3>
		 
		 @hasrole('student')
          
		 <h4>Name: {{ucwords(auth()->user()->name)}}</h4>

		 <h4>Admission No: {{auth()->user()->username}}</h4>

		 <h4>Department: {{ucwords(auth()->user()->profile->department->name)}}</h4>
		 
		 <h4>Level: {{ucwords(auth()->user()->profile->level->name)}}</h4>
		 
		 <h4>Email: {{auth()->user()->email}}</h4>

		 <h4>Email: {{auth()->user()->profile->phone}}</h4>

		 @endhasrole

		</div>
	</div><!-- Row end  -->

	



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
<!-- Plugin Js -->
<script src="{!! backendAssets('dist/assets/bundles/apexcharts.bundle.js') !!}"></script>
<script src="{!! backendAssets('dist/assets/bundles/dataTables.bundle.js') !!}"></script>
<script src="{!! backendAssets('dist/assets/js/page/index.js') !!}"></script>
@endpush

@push('custom_scripts')
<script>
	$('#myDataTable')
		.addClass('nowrap')
		.dataTable({
			responsive: true,
			columnDefs: [{
				targets: [-1, -3],
				className: 'dt-body-right'
			}]
		});
</script>
@endpush