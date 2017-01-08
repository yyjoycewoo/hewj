@extends("layouts.main")

@section("content")
		
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<h2>{{ $course["course_code"] }} {{ $course["session_type"] . $course["session_number"] }} {{ $course["session"] }}</h2>
			<hr>
		</div>
	</div>
		
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
			<table id="coursestuff" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="header">Question</th>
						<th class="header">Answers</th>
						<th class="header">Date</th>
					</tr>
				</thead>

				<tbody>
					@foreach($questions as $question)
						<tr>
							<td>{{ $question["question"] }}</td>
							<td>{{ implode(", ", $question["answers"]) }}</td>
							<td>{{ $question["date"] }}</td>
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
		$(document).ready(function (){
			$("#coursestuff").DataTable({
				"autoWidth": false,
				dom: 'lBfrtip',
				buttons: ['copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'print' ],
				paging: true,
				ordering: true
			});
		});		
	</script>
@endsection
