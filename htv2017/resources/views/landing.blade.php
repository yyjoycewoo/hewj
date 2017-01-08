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
								<td><a onclick="setCourseActive('{{ $course["session"] }}', '{{ $course["course_code"] }}', '{{ $course["session_type"] }}', '{{ $course["session_number"] }}')">Make Active</a></td>
							@else
								<td></td>
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
		
			$.get(BASE_URL + "addCourse?" + param);
			location.reload();
		}
	</script>
@endsection
