@extends("layouts.main")

@section("content")
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<h2>List of courses</h2>

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
							<td></td>
						</tr>
					@endforeach
				</tbody>

			</table>

		</div>
	</div>
@endsection

@section("javascript")
@endsection
