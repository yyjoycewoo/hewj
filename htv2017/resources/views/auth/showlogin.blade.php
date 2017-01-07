@extends("layouts.main")

@section("content")
	<div class="login-form">
		<br>
		<h2>Login</h2>
		{!! Form::open() !!}
		<div>
			{!! Form::label("username", "UTORid/UTSCid") !!}
			{!! Form::text("username", Input::old("username") ? : "", array('autofocus')) !!}
		</div>
		<div>
			{!! Form::label("password", "Password") !!}
			{!! Form::password("password") !!}
		</div>
		<div>
			{!! Form::submit("Log In", array('class' => 'btn btn-primary')) !!}
		</div>
		{!! Form::close() !!}
	</div>
@endsection

@section("javascript")
	<script>
		$(".menubar").html("");
		$(".menubar").hide();
	</script>
@endsection
