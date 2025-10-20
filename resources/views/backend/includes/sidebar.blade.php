<!-- sidebar -->
<div class="sidebar px-4 py-4 py-md-4 me-0">
	<div class="d-flex flex-column h-100">
		<a href="{!! backendRoutePut('home') !!}" class="mb-0 brand-icon">
			<span class="logo-icon">
				<img src="{{ asset('images/university-logo.png') }}" width="80%" alt="" />
			</span>
			
		</a>
		<!-- Menu: main ul -->
		<ul class="menu-list flex-grow-1 mt-3">

			<li><a class="m-link {{ (request()->is('dashboard')) ? "active":"" }}" href="{{ route('dashboard') }}"><i class="icofont-home fs-5"></i> <span>Dashboard</span></a></li>

			@if (Auth::user()->roles->pluck('name')[0]=="examiner")

			<li><a class="m-link {{ (request()->is('course/add')) ? "active":"" }}" href="{{ route('course.add') }}"><i class="icofont-book fs-5"></i> <span>Courses</span></a></li>

			<li><a class="m-link {{ (request()->is('department/add')) ? "active":"" }}" href="{{ route('department.add') }}"><i class="icofont-list fs-5"></i> <span>Departments</span></a></li>
		
			<li class="collapsed">
				<?php
				$isChildActive = (
				request()->is('result/add') || request()->is('result/upload') || request()->is('result/manage')
				)
				 ? 1 : 0;
				?>
				<a class="m-link {!! $isChildActive ? 'active' : '' !!}" data-bs-toggle="collapse" data-bs-target="#result" href="#">
					<i class="icofont-notepad fs-5"></i> <span>Result</span> <span class="arrow icofont-rounded-down ms-auto text-end fs-5"></span></a>
				<!-- Menu: Sub menu ul -->
				<ul class="sub-menu collapse {!! $isChildActive ? 'show' : '' !!}" id="result">
					<li><a class="ms-link {{ (request()->is('result/add')) ? "active":"" }}" href="{{route('result.add.view')}}">Add</a></li>
					<li><a class="ms-link {{ (request()->is('result/upload')) ? "active":"" }}" href="{{route('result.upload')}}">Upload</a></li>
					<li><a class="ms-link {{ (request()->is('result/manage')) ? "active":"" }}" href="{{route('result.manage')}}">Manage</a></li>
						</ul>
			</li>
			<li><a class="m-link {{ (request()->is('student/lists')) ? "active":"" }}" href="{{ route('user.lists') }}"><i class="icofont-users fs-5"></i> <span>Students</span></a></li>

			<li><a class="m-link {{ (request()->is('settings')) ? "active":"" }}" href="{{ route('settings') }}"><i class="icofont-settings fs-5"></i> <span>Settings</span></a></li>
		
			@else
			<li><a class="m-link {{ (request()->is('register-course')) ? "active":"" }}" href="{{ route('student-courses.add') }}"><i class="icofont-book fs-5"></i> <span>Register Courses</span></a></li>

			<li><a class="m-link {{ (request()->is('register-course')) ? "active":"" }}" href="{{ route('result.check') }}"><i class="icofont-notepad fs-5"></i> <span>Check Result</span></a></li>
		

			@endif
		

		</ul>

		<!-- Menu: menu collepce btn -->
		<div class="list-group m-2 ">
			<form method="POST" action="{{ route('logout') }}">
			@csrf
			@method('DELETE')
		<button type="submit" class="list-group-item list-group-item-action border-0 "><i class="icofont-logout fs-5 me-3"></i>Logout</button>
		</form>
	</div>

	</div>
</div>