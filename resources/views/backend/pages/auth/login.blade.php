@extends(backendView('layouts.auth'))

@section('title', 'Signin')

@section('content')
<div class="container-xxl">

		<div class="col-lg-12 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
			
			<div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
			     
				<!-- Form -->
				<form action="{{ route('login.store') }}" method="POST" class="row g-1 p-3 p-md-4">
					@csrf
					<div class="col-12 text-center mb-5">
						
					 
						<img src="{{ asset('images/aacoe.jpeg') }}" class="w240 mb-4" alt="" />
					
						<h1>Login</h1>
							@if (Session::has('error'))
						<p class="text-danger">
							{{Session::get('error')}}
						</p>
					 @endif
					 @if (Session::has('status'))
						<p class="text-success">
							{{Session::get('status')}}
						</p>
					 @endif
					</div>
					
					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Username</label>
							<input type="text" name="username"  class="form-control form-control-lg" placeholder="Username" value="{{ @old('username') }}">
						    <span class="text-danger">
							@error('username')
								{{ $message }}
							@enderror</span>
						</div>
					</div>
					<div class="col-12">
						<div class="mb-2">
							<div class="form-label">
								<span class="d-flex justify-content-between align-items-center">
									Password
									<a class="text-secondary" href="{{ route('password.request') }}">Forgot Password?</a>
								</span>
							</div>
							<input type="password" name="password" class="form-control form-control-lg">
							@error('password')
							<span class="text-danger">
								{{ $message }}
							</span>
							@enderror
						</div>
					</div>
					<div class="col-12">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="remember" id="remember">
							<label class="form-check-label" for="remember">
								Remember me
							</label>
						</div>
					</div>
					<div class="col-12 text-center mt-4">
						<button type="submit" class="btn btn-lg btn-block btn-primary lift text-uppercase">LOGIN</button>
					</div>
					<div class="col-12 text-center mt-4">
						<span>Don't have an account yet? <a href="{{ route('register') }}" class="text-primary">Sign up here</a></span>
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