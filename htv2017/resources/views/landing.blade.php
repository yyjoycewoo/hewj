@extends("layouts.main")

@section("content")
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<h2>List of Courses</h2>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="header">Course Code</th>
						<th class="header">Session</th>
						<th class="header">Section Type</th>
						<th class="header">Section Number</th>
						<th class="header">Is Active</th>
						<th class="header">Actions</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($courses as $course)
						<tr>
							<td>{{ $course["course_code"] }}</td>
							<td>{{ $course["session"] }}</td>
							<td>{{ $course["session_type"] }}</td>
							<td>{{ $course["session_number"] }}</td>
							<td>{{ $course["is_active"] == 1 ? "Yes" : "No" }}</td>
							
							@if ($course["is_active"] == 0)
								<td><a class="btn btn-primary btn btn-xs" onclick="setCourseActive('{{ $course["session"] }}', '{{ $course["course_code"] }}', '{{ $course["session_type"] }}', '{{ $course["session_number"] }}')">Make Active</a></td>
							@else
								@foreach ($activatedCourses as $aCourse)
									<?php
										if (strcmp($aCourse["course_code"], $course["course_code"]) == 0 &&
											strcmp($aCourse["session"], $course["session"]) == 0 &&
											strcmp($aCourse["session_type"], $course["session_type"]) == 0 &&
											strcmp($aCourse["session_number"], $course["session_number"]) == 0) {
												$courseId = $aCourse["id"];
												break;
											}
												
									?>
								@endforeach
								<td>	
									<a href="courseAttendence?courseId={{ $courseId }}" class="btn-primary btn btn-xs">Course Attendence</a>
									<a href="courseQuestions?courseId={{ $courseId }}" class="btn-primary btn btn-xs">Questions</a>
								</td>
							@endif
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section("javascript")
	<script>
		function setCourseActive(session, course_code, session_type, session_number) {
			var param = { 
				'session' : session,
				'course_code' : course_code, 
				'session_type' : session_type,
				'session_number' : session_number,
			}
			
			param = $.param(param);
		
			$.get(BASE_URL + "addCourse?" + param, function() {
				location.reload();
			}).fail(function() {
				alert("Internal Server Error, Please try again later.");
			});
		}
	</script>
@endsection
