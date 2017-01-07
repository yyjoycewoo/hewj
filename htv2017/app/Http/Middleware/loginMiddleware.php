<?php  
namespace App\Http\Middleware;

use Closure;
use Redirect, Session, Request;
use App\Http\Controllers\Auth\Login;
use Illuminate\Support\Facades\Route;

class loginMiddleWare {
	
	public function handle($request, Closure $next) {	
		//Check if they are logged in		
		if (!Login::isLoggedIn()) {
			if (Request::ajax()) {
				return Response::make('Unauthorized. You are not logged in, or your session has timed out.', 401);
			}
				
			Session::flash("danger", "Please log in.");
			return Redirect::to("login");
		}

		return $next($request);
	}
}
