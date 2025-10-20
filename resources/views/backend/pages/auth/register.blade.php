@extends(backendView('layouts.auth'))

@section('title', 'Sign up')
@section('content')
<div class="container-xxl">

	<div class="row g-0">
		

		<div class="col-lg-12 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h190">
			<div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
				<div class="">
				<center><img src="{{ asset('images/aacoe.jpeg') }}" width="70%"></center>
				</div>
				<!-- Form -->
				<form class="row g-1 p-3 p-md-4" method="POST" action="{{route('register.store')}}">
					@csrf
					<div class="col-12 text-center mb-5">
						<h1>Welcome</h1>
						<span>Create account to continue</span>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label class="form-label">Name *</label>
							<input class="form-control form-control-lg" type="text"value="{{ old('name') }}" name="name" id="name">
							<span class="text-danger">@error('name') {{ $message }}@enderror</span>
						</div>
					</div>

                    <div class="col-sm-12">
						<div class="form-group">
							<label class="form-label">Admission Number *</label>
							<input class="form-control form-control-lg" type="text"value="{{ old('admission_number') }}" name="admission_number" id="admission_number">
							<span class="text-danger">@error('admission_number') {{ $message }}@enderror</span>
						</div>
					</div>
				
				
					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Email Address *</label>
							<input type="email" class="form-control form-control-lg" value="{{ old('email') }}" name="email" id="email">
							<span class="text-danger">@error('email') {{ $message }}@enderror</span>
						</div>
					</div>

					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Phone Number *</label>
							<input type="text" class="form-control form-control-lg" value="{{ old('phone') }}" name="phone" id="phone">
							<span class="text-danger">@error('phone') {{ $message }}@enderror</span>
						</div>
					</div>

					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Department *</label>
							<select  class="form-select form-select-lg" name="department" id="department">
								<option selected disabled>Select</option>
								@foreach($departments as $department)
								<option value="{{ $department->id }}" {{(@old('department')==$department->id) ? "selected" : "" }}>{{ $department->name }}</option>
								@endforeach
								
							</select>
							<span class="text-danger">@error('department') {{ $message }}@enderror</span>
						</div>
					</div>
					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Level *</label>
							<select  class="form-select form-select-lg" name="level" id="level">
								<option selected disabled>Select</option>
								@foreach($levels as $level)
								<option value="{{ $level->id }}" {{(@old('level')==$level->id) ? "selected" : "" }}>{{ $level->name }}</option>
								@endforeach
								
							</select>
							<span class="text-danger">@error('level') {{ $message }}@enderror</span>
						</div>
					</div>
					<div class="col-12">
						<div class="mb-2">
						<label class="form-label">Password *</label>
							<input type="password" class="form-control form-control-lg"  value="{{ old('password') }}" placeholder="8+ characters required" name="password" id="password">
							<span class="text-danger">@error('password') {{ $message }}@enderror</span>
							
						</div>
					</div>
					<div class="col-12">
						<div class="mb-2">
							<label class="form-label">Confirm password *</label>
							<input type="password" class="form-control form-control-lg" placeholder="8+ characters required" name="password_confirmation" id="password_confirmation">
							<span class="text-danger">@error('password_confirmation') {{ $message }}@enderror</span>
						</div>
					</div>
					
					<div class="col-12 text-center mt-4">
						<button  type="submit" class="btn btn-lg btn-block bg-primary lift text-uppercase">SIGN UP</button>
					</div>
					<div class="col-12 text-center mt-4">
						<span>Already have an account? <a href="{{ route('login') }}" title="Sign in" class="text-primary">Sign in here</a></span>
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

@push('custom_scripts')
@endpush
