@include("layouts.header")
@include("layouts.notifications")
@include("layouts.footer")

<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	
	<!-- JQuery -->
	<script src="assets/vendor/jquery/dist/jquery.min.js"></script>

	<!-- Bootstrap -->
	<script src="assets/vendor/bootstrap/dist/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/dist/css/bootstrap.min.css">

	<!-- Jquery UI -->
	<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
	<link rel="stylesheet" href="assets/vendor/jquery-ui/themes/ui-lightness/jquery-ui.min.css">

	<!-- Application CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css', Config::get('app.secure')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css', Config::get('app.secure')) }}">
	<link rel="stylesheet" type="text/css" href="https://www.utsc.utoronto.ca/_includes/application/css/hf.css">
	
	<!-- Application Javascript -->
	<script src="js/atlas.js"></script>

	<script type="text/javascript">
		var BASE_URL = "{{ Config::get('app.url')}}/";
		var TOKEN = "{{ csrf_token() }}";
	</script>

	<title>Atlas</title>
</head>
<body style="max-width: 95%; overflow-x: hidden;" class="hold-transition skin-blue sidebar-mini">
	@yield("header")
	@yield("notifications")

	<div class="content-container">
		<div class="content" role="main">
			@yield("content")
		</div>
	</div>

	@yield("footer")
	@yield("javascript")
</body>
</html>
