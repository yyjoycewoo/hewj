<?php
namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Auth\Login;
use Input;
use Redirect;
use Session;

class LoginController extends Controller {

	private static function redirectIfNeeded() {
		if (Login::isLoggedIn()) {
			return Redirect::to("/");
		}

		return null;
	}

	public function showLogin() {
		$check = LoginController::redirectIfNeeded();
		if ($check != null) {
			return $check;
		}

		//Check to see if user is already logged in via the intranet
		$cookie_name = App::environment('local', 'beta') ? "DEMOUTSCwebPHPSESSID" : "UTSCwebPHPSESSID";

		//Check if cookie exists
		if (isset($_COOKIE[$cookie_name])) {
			$cookie = $_COOKIE[$cookie_name];

			//Try to log in via cookie
			$login = Login::Instance();
			if ($login->AuthenticateViaCookie($cookie)) {
				//Make sure the cookie is in the session so we can log out after
				Session::put('INTRANET_SESSION_ID', $cookie); ;

				//Redirect to landing page
				$check = LoginController::redirectIfNeeded();

				if ($check != null) {
					return $check;
				}
			}
		}

		return view('auth.showlogin');
	}
	
	public function postLogin() {
		$utorId  = Input::get('username');
		$password = Input::get('password');
	
		$login = Login::Instance();
		$ret = $login->Authenticate($utorId, $password);
		
		// Failed credential
		if ($ret == false) {
			return Redirect::to('login')->withInput();
		}

		return Redirect::intended('/');
	}

	private static function logOffUser($message, $type) {
		$login = Login::Instance();
		$login->logOff();

		Session::flash($type, $message);
		return Redirect::to('login');
	}
	
	public function logOff() {
		return LoginController::logOffUser('You have successfully logged out.', 'success');
	}
}
