<?php
	use Illuminate\Support\Facades\Route;
	use App\Http\Controllers\Auth\Login;
	use App\Options;
	
	//Default values incase user is not logged in
	$user = Login::getUser();
	$tabList = array();
	$currentTab = "";
	$position = "";
	$name = "";
	$logoutUrl = "";
	$logoutText = "";

	//UTSC Header
	$utscHeader = file_get_contents("https://www.utsc.utoronto.ca/_includes/application/_header.html");

	if ($user !== false) {	
		//Generate main menu bar
		$permission = $user->permission;

		//Menu Bar
		$appURL = Config::get('app.url');
		$statsTrackingURL = Options::getStatsTrackingURL();

		//tabname => [displayname, URL, toDisplay]
		$tabList = array(
			"landing" => ["Home", $appURL, true],
			"labs" => ["Labs", $appURL . "/labs", $permission['lab_access']],
			"stats" => ["Stats", $statsTrackingURL, true],
			"infractions" => ["Infractions", $appURL . "/infractions", $permission['infractions_access']],
			"info" => ["Info", $appURL . "/info", $permission['info_access']],
			"ldap" => ["LDAP Lookup", $appURL . "/ldap", $permission['ldap_access']],
			"printing" => ["Printing Logs", $appURL . "/printing", $permission['printing_access']],
			"calendar" => ["Calendar", $appURL . "/calendar", $permission['calendar_access']],
			"administration" => ["Administration", $appURL . "/administration", $permission['administration_access']],
		);

		$currentTab = Route::getCurrentRoute()->getName();

		$name = $user->givennames . " " . $user->familyname;		
		$position = $user->permission["name"];

		$logoutUrl = Config::get('app.url') . "/logout";
		$logoutText = "Log Out";
	} else {
		$utscHeader = str_replace('<div class="profile">', '<div hidden class="profile">', $utscHeader);
	}

	if (App::environment('local', 'beta')) {
		$utscHeader .= "<script>$('body').addClass('demo')</script>";
	}

	$utscHeader = str_replace("[--NAME--]", $name, $utscHeader);
	$utscHeader = str_replace("[--POSITION--]", $position, $utscHeader);
	$utscHeader = str_replace("[--LOGOUT_URL--]", $logoutUrl, $utscHeader);
	$utscHeader = str_replace("[--LOGOUT_TEXT--]", $logoutText, $utscHeader);
	$utscHeader = str_replace("[--DROPDOWN--]", "", $utscHeader);
?>

@section("leftNav")
	@foreach($tabList as $tabName => $tabInfo)
		@if (strcmp($currentTab, $tabName) == 0)
			<li class="active"><a href="{{ $tabInfo[1] }}"><strong>{{ $tabInfo[0] }}</strong></a></li>
		@elseif ($tabInfo[2])
			<li><a href="{{ $tabInfo[1] }}"><strong>{{ $tabInfo[0] }}</strong></a></li>
		@endif
	@endforeach
@endsection

@section("rightNav")
@endsection

@section("header")
	<div class="utsc-header">
		{!! $utscHeader !!}
	</div>
	
	@if (!isset($isAdmin) || $isAdmin)
		<!-- Hide for small devices -->
		<nav class="menubar navbar navbar-default hidden-xs hidden-sm">
			<div class="container-fluid">
				<div class="nav navbar-nav">
					@yield("leftNav")
				</div>
				<div class="nav navbar-nav navbar-right">
					@yield("rightNav")
				</div>
			</div>
		</nav>
	
		<!-- Use dropdown menu for small devices -->
		<div class="menubar dropdown visible-xs visible-sm">
			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Main Menu
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				@yield("leftNav")
			</ul>
		</div>
	@endif
@endsection
