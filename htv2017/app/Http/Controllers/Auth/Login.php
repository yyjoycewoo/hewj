<?php
namespace App\Http\Controllers\Auth;

use App;
use App\Options;
use App\User;
use Eloquent;
use Session;
use Redirect;

/**
 * Class Login dealing with communication to the intranet and webserivces to authenticate UTSC users.
 *
 * @package App\Http\Controllers\Auth
 */
class Login extends Eloquent {
	// Interfaces
	private $user;

	/**
	 * Creates a new Login instance.
	 *
	 * @return Login
	 */
	static function Instance() {
		return new Login();
	}

	/**
	 * Saves the current login params to the session.
	 */
	protected function saveAllSessions() {
		if ($this->user == null) {
			return;
		}
	
		$temp = new User();
		$temp->user_id = $this->user->user_id;
		$temp->familyname = $this->user->familyname;
		$temp->givennames = $this->user->givennames;
		$temp->studentNumber = $this->user->studentNumber;
		$temp->peopleID = $this->user->peopleID;
		$temp->utorId = $this->user->utorId;
		$temp->email = $this->user->email;

		$this->user = $temp;

		Session::put('user', $this->user);
	}

	/**
	 * Processes the profile given and sets up a user.
	 *
	 * @param $profile The user's profile from the intranet
	 */
	protected function setUserCredential($profile) {
		if ($profile->peopleID) {							
			$user_id = User::getPrimaryKey($profile->utorid);
			
			//Not auth, kick them out
			if ($user_id == null) {
				return null;
			}
		
			$this->user = new User();
			$this->user->user_id = $user_id;
			
			$this->user->familyname = $profile->familyname;
			$this->user->givennames = $profile->givennames;
			
			$this->user->studentNumber = $profile->studentID;
			$this->user->peopleID = $profile->peopleID;
			$this->user->utorId = $profile->utorid;
			$this->user->email = $profile->email;
		}
	}

	/**
	 * Return whether the current user is logged in.
	 *
	 * @return boolean true if the user is logged in false otherwise
	 */
	public static function isLoggedIn() {
		$user = Session::get('user');
		
		return !empty($user) ? true : false;
	}

	/**
	 * Return current user.
	 *
	 * @return mixed returns the user if user exists, false otherwise
	 */
	public static function getUser() {
		$user = Session::get('user');
		
		return !empty($user) ? $user : false;
	}

	/**
	 * Tries to authenticate via the intranet with the given cookie.
	 *
	 * @param string $cookie cookie to try to authenticate with
	 * @param bool $displayError if true then places error messages in the session
	 * @return bool true if authentication is successful false otherwise
	 */
	public function AuthenticateViaCookie($cookie, $displayError=false) {
		$WEBSERVICES_URL = Options::getServicesURL()[0] ."/GetProfileWithCourseSections?"
			.http_build_query(array(
				'response' => 'application/json',
				'sessionID' => $cookie,
				'term' => 0
			));

		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);

		// Suppress exceptions with @..
		$content = @file_get_contents($WEBSERVICES_URL, false, stream_context_create($arrContextOptions));

		// If failed to get file ==> web services has gone wrong probably..
		if($content === FALSE) {
			// He's dead, Jim!
			if ($displayError) {
				Session::flash('danger', 'Web Services unavailable');
			}

			return false;
		}

		// Everything goes right.. decode the content..
		$profile = json_decode($content)->return;

		// If the intranet is down then people is would not be set, so check for it
		if (!isset($profile->peopleID)) {
			// He's dead, Jim!
			if ($displayError) {
				Session::flash('danger', 'Web Services unavailable');
			}

			return false;
		}

		// Is he clean?
		if ($profile && $profile->peopleID > 0) {
			self::setUserCredential($profile);
			self::saveAllSessions();
			
			//If Unauthed
			if (self::getUser() === false) {
				Session::flash('danger', 'Not allowed to access application');
				
				$session_id = Session::get('INTRANET_SESSION_ID');
				if ($session_id == null) {
					return Session::flush();
				}
				
				Redirect::to("/");
				return false;
			}

			$cookie_name = App::environment('local', 'beta') ? "DEMOUTSCwebPHPSESSID" : "UTSCwebPHPSESSID";
			if (!isset($_COOKIE[$cookie_name])) {
				setcookie($cookie_name, $cookie, 0, "/", ".utsc.utoronto.ca");
			} else {
				//Make sure the cookie is the same as the new one
				if (strcmp($_COOKIE[$cookie_name], $cookie) != 0) {
					setcookie($cookie_name, $cookie, 0, "/", ".utsc.utoronto.ca");
				}
			}

			return true;
		}

		// Apparently he is not clean..
		if ($displayError) {
			Session::flash('danger', 'Incorrect login name or password.');
		}

		return false;
	}

	/**
	 * Tries to authenticate via the intranet with the given userid and password.
	 *
	 * @param string $userid username
	 * @param string $password password
	 * @return bool true if authentication is successful false otherwise
	 */
	public function Authenticate($userid, $password) {
		$data = array(
			"pageTitle" => "awards",
			"userid" => $userid,
			"password" => $password,
		);
		$param = http_build_query($data);
	
		if (!Session::has('INTRANET_SESSION_ID')) {
			Session::put('INTRANET_SESSION_ID', md5($data["userid"] . time()));
		}

		$sessionId = Session::get('INTRANET_SESSION_ID');
	
		if ($sessionId == null) {
			return false;
		}


		$session_str = App::environment('local', 'beta') ? "DEMOUTSCwebPHPSESSID=" . $sessionId
			: "UTSCwebPHPSESSID=" . $sessionId;
	
		$arr_header = array(	"Cookie: cookietester=1; {$session_str};",
		"Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
		"Connection: keep-alive"
				);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, Options::getServicesURL()[1]);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $arr_header);
		curl_exec($ch);
		curl_close($ch);
	
		self::AuthenticateViaCookie($sessionId, true);
	}

	/**
	 * Logoff of the intranet and destroys the local session.
	 */
	public function logOff() {
		$session_id = Session::get('INTRANET_SESSION_ID');
		//If the season expires before the intranet one expires, this will be null
		//and we need to access the $_COOKIE var directly
		if ($session_id == null) {
			$cookie_name = App::environment('local', 'beta') ? "DEMOUTSCwebPHPSESSID" : "UTSCwebPHPSESSID";

			if (isset($_COOKIE[$cookie_name])) {
				$session_id = $_COOKIE[$cookie_name];
			}
		}

		//If it is still null, then nothing to do return
		if ($session_id == null) {
			return Session::flush();
		}
	
		$WEBSERVICES_URL = Options::getServicesURL()[0] ."/Logoff?"
				.http_build_query(array(
						'response' => 'application/json',
						'sessionID' => $session_id,
				));
					
		$arrContextOptions=array(
				"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
				),
		);

		// Logoff from Intranet.
		$response = file_get_contents($WEBSERVICES_URL, false, stream_context_create($arrContextOptions));
		$logged_off = json_decode($response)->return;

		// Flush Laravel session.
		return Session::flush();
	}
}
