<?php
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('login', ['as' => 'login', "uses" => 'LoginController@showLogin']);
Route::post('login', 'LoginController@postLogin');

Route::get('logout', ['as' => 'logout', 'uses' => 'LoginController@logOff']);

Route::group(['middleware' => 'loginCheck'], function() {
	//View PHP Info
	Route::get('/', ['as' => 'landingPage', 'uses' => 'LandingController@showLandingPage']);
});
