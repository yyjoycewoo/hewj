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

Route::get('webLogin', ['as' => 'login', "uses" => 'LoginController@showLogin']);
Route::post('webLogin', 'LoginController@postLogin');
Route::get('webLogout', ['as' => 'logout', 'uses' => 'LoginController@logOff']);

Route::get('login', ['as' => 'login', 'uses' => 'ApiController@doLogin']);
Route::post('login', ['as' => 'login', 'uses' => 'ApiController@doLogin']);
Route::get('logout', ['as' => 'logout', 'uses' => 'ApiController@doLogoff']);

Route::group(['middleware' => 'loginCheck'], function() {
	//View PHP Info
	Route::get('/', ['as' => 'landing', 'uses' => 'LandingController@showLandingPage']);
	
	Route::get('addCourse', 'ApiController@addCourse');
	Route::get('isCourseActive', 'ApiController@isCourseActive');
	Route::get('getCoursesCurrentLoggedInStudentIsIn', 'ApiController@getCoursesCurrentLoggedInStudentIsIn');
	Route::get('getCoursesCurrentLoggedInStaffIsTeaching', 'ApiController@getCoursesCurrentLoggedInStaffIsTeaching');
	Route::get('getAcitivatedCourses', 'ApiController@getAcitivatedCourses');
	Route::get('getCourseId', 'ApiController@getCourseId');
	Route::get('startAttendence', 'ApiController@startAttendence');
	Route::get('stopAttendence', 'ApiController@stopAttendence');
	Route::get('isAllowingAttendence', 'ApiController@isAllowingAttendence');
	Route::get('getAttendenceByCourse', 'ApiController@getAttendenceByCourse');
	Route::get('setAttendence', 'ApiController@setAttendence');
	Route::get('getQuestions', 'ApiController@getQuestions');
	Route::get('addQuestion', 'ApiController@addQuestion');
	Route::get('getAnswers', 'ApiController@getAnswers');
	Route::get('addAnswer', 'ApiController@addAnswer');
	Route::get('addResponse', 'ApiController@addResponse');
	Route::get('getAllResponsesFromQuestion', 'ApiController@getAllResponsesFromQuestion');
	Route::get('addTask', 'ApiController@addTask');
	Route::get('addMark', 'ApiController@addMark');
	Route::get('getMarkByTask', 'ApiController@getMarkByTask');
});
