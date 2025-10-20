@extends(backendView('layouts.auth'))

@section('title', 'Reset Password')

@section('content')
<div class="container-xxl">

	<div class="row g-0">
		<div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
			<div style="max-width: 25rem;">
				<div class="text-center mb-5">
					<i class="icofont-education  text-primary" style="font-size: 90px;"></i>
				</div>
				<div class="mb-5">
					<h2 class="color-900 text-center">A few clicks is all it takes.</h2>
				</div>
				
			</div>
		</div>

		<div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
			<div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
				<!-- Form -->
				<form method="POST" class="row g-1 p-3 p-md-4" action="{{ route('password.store') }}">
					@csrf		
					<div class="col-12 text-center mb-5">
						<img src="{{ asset('images/aacoe.jpeg') }}" class="w240 mb-4" alt="" />
						<h1>Reset Password</h1>
					</div>
					
					
					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Password</label>
							<input type="password" class="form-control form-control-lg" name="password">
							<span class="text-danger">
								@error('password')
								<span class="text-danger">{{ $message }}</span>	
								@enderror</span>
						</div>
					</div>

					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Confirm Password</label>
							<input type="password" class="form-control form-control-lg" name="password_confirmation">
							<span class="text-danger">
								@error('password_confirmation')
								<span class="text-danger">{{ $message }}</span>	
								@enderror</span>
						</div>
					</div>
					<div class="col-12 text-center mt-4">
						<input type="hidden" name="email" value="{{$request->email}}">
						<input type="hidden" name="token" value="{{ $request->route('token') }}">
						<button class="btn btn-lg btn-block btn-primary lift text-uppercase">Reset Password</button>
					</div>
					
					
					<div class="col-12 text-center mt-4">
						<span>Remember Password <a href="{{route('login')}}" class="text-primary">Login</a></span>
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