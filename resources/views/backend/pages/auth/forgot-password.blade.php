@extends(backendView('layouts.auth'))

@section('title', 'Password Reset')

@section('content')
<div class="container-xxl">

	<div class="row g-0">
		
		<div class="col-lg-12 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
			<div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
				<!-- Form -->
				<form class="row g-1 p-3 p-md-4" action="{{route('password.email')}}" method="POST">
					@csrf
					<div class="col-12 text-center mb-5">
						@if (Session::has('status'))
						<div class="alert alert-success">
							{{Session::get('status')}}
						</div>
					 @endif
					<div class="col-12 text-center mb-5">
						<img src="{{ asset('images/aacoe.jpeg') }}" class="w240 mb-4" alt="" />
						
						<h1>Forgot password?</h1>
						<span>Enter the email address you used when you joined and we'll send you instructions to reset your password.</span>
					</div>
					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Email address</label>
							<input type="email" class="form-control form-control-lg" placeholder="name@example.com" name="email">
							<span class="text-danger">
								@error('email')
									{{ $message }}
								@enderror</span>
						</div>
					</div>
					<div class="col-12 text-center mt-4">
						<button class="btn btn-lg btn-block btn-primary lift text-uppercase">SUBMIT</button>
					</div>
					<div class="col-12 text-center mt-4">
						<span class="text-muted"><a href="{{ route('login') }}" class="text-primary">Back to Sign in</a></span>
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