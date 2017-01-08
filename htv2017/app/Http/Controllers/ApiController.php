<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\Login;
use Illuminate\Http\Request;
use Input;
use ResponseL;
use App\Course;
use App\Attendence;
use App\Question;
use App\Answer;
use App\Response;
use App\Task;
use App\Mark;

class ApiController extends Controller
{
	public function ApiController() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, POST');
		header("Access-Control-Allow-Headers: X-Requested-With");
		
		super();
	}

	//Login
	public function doLogin() {
		$utorId = Input::get('username');
		$password = Input::get('password');
	
		$login = Login::Instance();
		$ret = $login->Authenticate($utorId, $password);
		
		// Failed credential
		if ($ret == false) {
			return response()->json(["message" => "Wrong username or password"], 401);
		}
		
		return response()->json(["message" => "OK"], 200);
	}
	
	//Logout
	public function doLogoff() {
		$login = Login::Instance();
		$login->logOff();
		
		return response()->json(["message" => "OK"], 200);
	}

	// Course API
    public function addCourse() {
	    if (null == Input::get('session')) return response()->json("Missing session parameter.", 400);
	    if (null == Input::get('course_code')) return response()->json("Missing course_code parameter.", 400);
	    if (null == Input::get('session_type')) return response()->json("Missing session_type parameter.", 400);
	    if (null == Input::get('session_number')) return response()->json("Missing session_number parameter.", 400);
	    
		return json_encode(Course::addCourse(Input::get('session'), Input::get('course_code'), Input::get('session_type'), Input::get('session_number')));
    }
    
    public function isCourseActive() {
	    if (null == Input::get('sesssion')) return response()->json("Missing session parameter.", 400);
	    if (null == Input::get('course_code')) return response()->json("Missing course_code parameter.", 400);
	    if (null == Input::get('session_type')) return response()->json("Missing session_type parameter.", 400);
	    if (null == Input::get('session_number')) return response()->json("Missing session_number parameter.", 400);
	    
    	return json_encode(Course::isCourseActive(Input::get('session'), Input::get('course_code'), Input::get('session_type'), Input::get('session_number')));
    }
    
    public function getCoursesCurrentLoggedInStudentIsIn() {
    	return json_encode(Course::getCoursesCurrentLoggedInStudentIsIn());
    }
    
    public function getCoursesCurrentLoggedInStaffIsTeaching() {
    	return json_encode(Course::getCoursesCurrentLoggedInStaffIsTeaching());
    }
    
    public function getAcitivatedCourses() {
    	return json_encode(Course::getAcitivatedCourses());
    }
    
    public function getCourseId() {
	    if (null == Input::get('sesssion')) return response()->json("Missing session parameter.", 400);
	    if (null == Input::get('course_code')) return response()->json("Missing course_code parameter.", 400);
	    if (null == Input::get('session_type')) return response()->json("Missing session_type parameter.", 400);
	    if (null == Input::get('session_number')) return response()->json("Missing session_number parameter.", 400);
	    
    	return json_encode(Course::getId(Input::get('session'), Input::get('course_code'), Input::get('session_type'), Input::get('session_number')));
    }
    
    public function startAttendence() {
	    if (null == Input::get('course_code')) return response()->json("Missing course_code parameter.", 400);
    
    	return json_encode(Course::startAttendence(Input::get('course_code')));
    }
    
    public function stopAttendence() {
	    if (null == Input::get('course_code')) return response()->json("Missing course_code parameter.", 400);
	    
    	return json_encode(Course::stopAttendence(Input::get('course_code')));
    }
    
    public function isAllowingAttendence() {
	    if (null == Input::get('course_code')) return response()->json("Missing course_code parameter.", 400);
	    
    	return json_encode(Course::isAllowingAttendence(Input::get('course_code')));
    }
    
    // Attendence API
    public function getAttendenceByCourse() {
	    if (null == Input::get('course_id')) return response()->json("Missing course_id parameter.", 400);
	    
    	return json_encode(Attendence::getAttendenceByCourse(Input::get('course_id')));
    }
    
    public function setAttendence() {
	    if (null == Input::get('course_id')) return response()->json("Missing course_id parameter.", 400);
	    if (null == Input::get('student_id')) return response()->json("Missing student_id parameter.", 400);
	    
    	return json_encode(Attendence::setAttendence(Input::get('course_id'), Input::get('student_id')));
    }
    
    // Question API
    public function getQuestions() {
	    if (null == Input::get('course_id')) return response()->json("Missing course_id parameter.", 400);
	    
    	return json_encode(Question::getQuestions(Input::get('course_id')));
    }
    
    public function addQuestion() {	// date is in datetime format
	    if (null == Input::get('course_id')) return response()->json("Missing course_id parameter.", 400);
	    if (null == Input::get('question')) return response()->json("Missing question parameter.", 400);
	    if (null == Input::get('date')) return response()->json("Missing date parameter.", 400);
	    
    	return json_encode(Question::addQuestion(Input::get('course_id'), Input::get('question'), Input::get('date')));
    }
    
    // Answer API
    public function getAnswers() {
	    if (null == Input::get('question_id')) return response()->json("Missing question_id parameter.", 400);
	    
    	return json_encode(Answer::getAnswers(Input::get('question_id')));
    }
    
    public function addAnswer() {	// is_correct is a boolean = 0 (false) or 1 (true)
	    if (null == Input::get('question_id')) return response()->json("Missing question_id parameter.", 400);
	    if (null == Input::get('answer')) return response()->json("Missing answer parameter.", 400);
	    
    	return json_encode(Answer::addAnswer(Input::get('question_id'), Input::get('answer'), Input::get('is_correct')));
    }
    
    // Response
    public function addResponse() {
	    if (null == Input::get('question_id')) return response()->json("Missing question_id parameter.", 400);
	    
    	return json_encode(Response::addResponse(Input::get('question_id'), Input::get('student_id'), Input::get('answer_id'), Input::get('answer')));
    }
    
    public function getAllResponsesFromQuestion() {
	    if (null == Input::get('question_id')) return response()->json("Missing question_id parameter.", 400);
	    
    	return json_encode(Response::getAllResponsesFromQuestion(Input::get('question_id')));
    }
    
    // Task
    public function addTask() {	// date is in datetime format
	    if (null == Input::get('course_id')) return response()->json("Missing course_id parameter.", 400);
	    if (null == Input::get('date')) return response()->json("Missing date parameter.", 400);
	    if (null == Input::get('name')) return response()->json("Missing name parameter.", 400);
	    
    	return json_encode(Task::addTask(Input::get('course_id'), Input::get('date'), Input::get('name')));
    }
    
    public function getTask() {
	    if (null == Input::get('course_id')) return response()->json("Missing course_id parameter.", 400);
	    
    	return json_encode(Task::getTask(Input::get('course_id')));
    }
    
    // Mark
    public function addMark() {	// done is a boolean = 0 (false) or 1 (true)
	    if (null == Input::get('task_id')) return response()->json("Missing task_id parameter.", 400);
	    if (null == Input::get('student_id')) return response()->json("Missing task_id parameter.", 400);
	    if (null == Input::get('mark') || null == Input::get('task_id')) return response()->json("Missing mark or done parameter.", 400);
	    
    	return json_encode(Mark::addMark(Input::get('task_id'), Input::get('student_id'), Input::get('mark'), Input::get('done')));
    }
    
    public function getMarkByTask() {
	    if (null == Input::get('task_id')) return response()->json("Missing task_id parameter.", 400);
	    
    	return json_encode(Mark::getMarkByTask(Input::get('task_id')));
    }
}
