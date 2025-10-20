<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
	<link rel="icon" href="{{ url('/') }}/favicon.ico" type="image/x-icon"> <!-- Favicon-->

	@stack('styles')

	<!-- project css file  -->
	<link rel="stylesheet" href="{!! backendAssets('ebazar.style.min.css') !!}">

	@stack('custom_styles')
</head>

<body>
	<div id="ebazar-layout" class="theme-indigo">

		@include(backendView('includes.sidebar'))

		<!-- main body area -->
		<div class="main px-lg-4 px-md-4">

			@include(backendView('includes.header'))
			@include('sweetalert::alert')
			<!-- Body: Body -->
			<div class="body d-flex py-3">
				@yield('content')
			</div>

			@yield('footer')

			@stack('modals')

		</div>

	</div>

	<!-- Jquery Core Js -->
	<script src="{!! backendAssets('dist/assets/bundles/libscripts.bundle.js') !!}"></script>
	<script>
		$(function() {
	  // allow only numbers
	  var ctrlAltShift = false;
	  $(document).keydown(function(e) {
		  if (e.keyCode >= 16 && e.keyCode <= 18 ) ctrlAltShift = true;
	  }).keyup(function(e) {
		  if (e.keyCode >= 16 && e.keyCode <= 18 ) ctrlAltShift = false;
	  });
	  $("[data-type=numeric]").keydown( function(e) {
		  if( 
			  (
				  !ctrlAltShift && (
					  ( e.keyCode >= 48 && e.keyCode <= 57 ) ||
					  ( e.keyCode >= 96 && e.keyCode <= 105 ) ||
					  ( $.inArray(e.keyCode, [8, 9, 27, 35, 36, 37, 39, 46]) !== -1 )
				  ) 
			  ) ||
				  ctrlAltShift && e.keyCode == 9 
		  ) {
			  return;
		  }
		  else {
			  e.preventDefault();
		  }        
	  });
  
  
	  // allow only numbers with 2 decimals
	  $("[data-type=decimal]").keydown( function(e) {
		  if(
			  (
				  !ctrlAltShift && (
					  ( e.keyCode >= 48 && e.keyCode <= 57 ) ||
					  ( e.keyCode >= 96 && e.keyCode <= 105 ) ||
					  ( $.inArray(e.keyCode, [8, 9, 27, 35, 36, 37, 39, 46, 110, 190, 194]) !== -1 )
				  )
			  ) ||
				  ctrlAltShift && e.keyCode == 9 
		  ) {
			  if( $.inArray(e.keyCode, [110, 190, 194]) !== -1 ) {
				  e.preventDefault();
				  if( $(this).val().length != 0 && $(this).val().indexOf('.') == -1 ) {
					  $(this).val( $(this).val() + '.');
				  }
			  }
		  }
		  else {
			  e.preventDefault();
		  }
	  }).keyup(function(e) {
		  var value = $(this).val();
  
		  if( value.indexOf('.') != -1) { 
			  if( value.split(".")[1].length > 2 ) {
				  var newValue = parseFloat( Math.floor(value * 100) / 100).toFixed(2);
				  e.preventDefault();
				  $(this).val( newValue );
			  }
		  }        
	  });
  });
	   </script> 
	@stack('scripts')
	<!-- Jquery Page Js -->
	<script src="{!! backendAssets('dist/assets/js/template.js') !!}"></script>
	@stack('custom_scripts')
</body>

</html>
