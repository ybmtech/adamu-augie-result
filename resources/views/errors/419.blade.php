@extends(backendView('layouts.auth'))

@section('title', '419 Page expired')
@section('content')
<div class="container-xxl">

	<div class="row g-0">
		<div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
			<div style="max-width: 25rem;">
				<div class="text-center mb-5">
					<i class="text-primary" style="font-size: 90px;"></i>
				</div>
				<div class="mb-5">
					<h2 class="color-900 text-center"></h2>
				</div>
				<!-- Image block -->
				<div class="">
					<img src="{{ asset('images/university-logo.png') }}" width="70%" alt="login-img">
				</div>
			</div>
		</div>

		<div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
			<div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
				<!-- Form -->
				<form class="row g-1 p-3 p-md-4">
					<div class="col-12 text-center mb-4">
						<img src="{!! backendAssets('dist/assets/images/not_found.svg') !!}" class="w240 mb-4" alt="" />
						<h5>OOP! PAGE EXPIRED</h5>
						<span class="">Sorry, the page you're looking has expired, if error persist clear your browser cookies and try again.</span>
					</div>
                    <div class="col-12 text-center">
						<a href="{{ route('login') }}" title="" class="btn btn-lg btn-block btn-primary lift text-uppercase">Back to home</a>
				</div>
				</form>
				<!-- End Form -->
			</div>
		</div>
	</div> <!-- End Row -->

</div>
@endsection

@push('styles')
@endpush

@push('custom_styles')
@endpush

@push('scripts')
@endpush

@push('custom_scripts')
@endpush

@push('modals')
@endpush