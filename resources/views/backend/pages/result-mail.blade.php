<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>          
	     
	         <img src="{{$logo}} " alt="logo" style="display: block;margin-left: auto;margin-right: auto;width: 100px;height: 100px;">
			<h2 style="text-align: center;">Adamu Augie College of Education, Argungu (AACOE)</h2>
			<h4 style="text-align: center;">P.M.B 1010, Argungu, Kebbi State</h4>
			<h4 style="text-align: center;">www.aacoe.edu.ng</h4>
			<h3 style="text-align: center;text-tranform:uppercase">OFFICIAL {{$session_name}} {{$semester_name}} Semester RESULTS</h3>
			<h3>Dear {{ucwords($student->name)}}</h3>
			<table  style="width: 100%;border-collapse:collapse;" border="1">
							<tr>
								<th>S/N</th>
								<th>Course Title</th>
								<th>Course Code</th>
								<th>Course Unit</th>
								<th>Score</th>
								<th>Grade</th>
								
							</tr>
							@foreach ($results as $registered_course)
						    <tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ucwords($registered_course->course->title)}}</td>
							<td>{{ucwords($registered_course->course->code)}}</td>
							<td>{{$registered_course->course->unit}}</td>
							<td>{{$registered_course->score}}</td>
							<td>{{$registered_course->grade}}</td>
							
							</tr>
							
						@endforeach
						
</body>
</html>
