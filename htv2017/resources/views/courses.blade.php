@extends("layouts.main")

@section("content")
		
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<h2>{{ $course["course_code"] }} {{ $course["session_type"] . $course["session_number"] }} {{ $course["session"] }}</h2>
			<hr>
		</div>
	</div>
		
	<div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			<span>Date: <input type="text" id="calenderDate" value="{{ $date or date('m/d/Y') }}"></span>
			<a onclick="clearDate()" class="btn btn-primary">Clear</a>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<table id="coursestuff" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="header">First Name</th>
						<th class="header">Last Name</th>
						<th class="header">Date</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($attendence as $x)
						<tr>
							<td>{{ $x["first_name"] }}</td>
							<td>{{ $x["last_name"] }}</td>
							<td>{{ $x["date"] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection

@section("javascript")
	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="assets/vendor/datatables.net-dt/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/vendor/datatables.net-buttons-dt/css/buttons.dataTables.min.css" />
	<script src="assets/vendor/jszip/dist/jszip.min.js"></script>
	<script src="assets/vendor/pdfmake/build/pdfmake.min.js"></script>
	<script src="assets/vendor/pdfmake/build/vfs_fonts.js"></script>
	<script src="assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="assets/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>

	<script>
		function reloadPage() {
			var courseId = {{ $course["id"] }};
			
			var currentDate = $("#calenderDate").datepicker("getDate");
			var date = currentDate.getFullYear() + "/" + (currentDate.getMonth() + 1) + "/" + currentDate.getDate();	
			
			window.location = BASE_URL + 'courseAttendence?courseId=' + courseId + "&date=" + date;
		}
		
		function clearDate() {
			var courseId = {{ $course["id"] }};
			window.location = BASE_URL + 'courseAttendence?courseId=' + courseId;
		}
	
		$(document).ready(function (){
			$("#coursestuff").DataTable({
				"autoWidth": false,
				dom: 'lBfrtip',
				buttons: ['copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
				paging: true,
				ordering: true
			});
			
			$("#calenderDate").datepicker({
				 onSelect: function() {	reloadPage(); }	
			});
		});		
	</script>
@endsection
