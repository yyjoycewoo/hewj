<?php

namespace App;

use App\Http\Controllers\Auth\Login;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    /**
     * The database table used to keep track of courses.
     *
     * @var string
     */
    protected $table = 'course';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param int session when the course is offered
     * @param string course_code course code
     * @param string session_type type of the session
     * @param int session_number number
     */
     
    public static function addCourse($session, $course_code, $session_type, $session_number) {
    	$insert_array = array(
    		"session" => $session,
    		"course_code" => $course_code,
    		"session_type" => $session_type,
    		"session_number" => $session_number,
    	);
    	
    	$id = Course::insertGetId($insert_array);
    	return $id > 0 ? $id : -1;
    }
    
    public static function isCourseActive($session, $course_code, $session_type, $session_number) {
    	return count(Course::where("course_code", "=", $course_code)
    					->where("session", "=", $session)
    					->where("session_type", "=", $session_type)
    					->where("session_number", "=", $session_number)
    					->get()->toArray()) > 0;
    }
    
    public static function getCoursesCurrentLoggedInStudentIsIn() {
    	$user = Login::getUser();
    	$courses = $user->takes;
    	$rV = array();
    	
    	foreach ($courses as $course) {
    		$session = (string)$course->year . (string)$course->session;
    		$session_type = $course->meetingsection[0];
    		$session_number = substr($course->meetingsection, 1);
    	
    		$new_array = array(
    			"session" => $session,
    			"course_code" => $course->coursecode,
    			"session_type" => $session_type,
    			"session_number" => $session_number,
    			"is_active" => Course::isCourseActive($session, $course->coursecode, $session_type, $session_number),
    		);
    		
    		array_push($rV, $new_array);
    	}	
    	
    	return $rV;
    }
    
    public static function getCoursesCurrentLoggedInStaffIsTeaching() {
    	$user = Login::getUser();
    	$courses = $user->teaches;
    	$rV = array();
    	
    	var_dump($courses);
    	
    	foreach ($courses as $course) {
    		var_dump($course);
    	
    		$session = (string)$course->year . (string)$course->session;
			$session_type = $course->meetingsection[0];
			$session_number = substr($course->meetingsection, 1);
    	
    		$new_array = array(
    			"session" => $session,
    			"course_code" => $course->coursecode,
    			"session_type" => $session_type,
    			"session_number" => $session_number,
    			"is_active" => Course::isCourseActive($session, $course->coursecode, $session_type, $session_number),
    		);
    		
    		array_push($rV, $new_array);
    	}	
    	
    	return $rV;
    } 
    
    public static function getAcitivatedCourses() {
    	$user = Login::getUser();
    	$courses = $user->teaches;
    	$rV = array();
    	
    	foreach ($courses as $course) {
    		$session = (string)$course->year . (string)$course->session;
    		$session_type = $course->meetingsection[0];
    		$session_number = substr($course->meetingsection, 1);
    	
    		$check = Course::where("course_code", "=", $course->coursecode)
    			->where("session", "=", $session)
    			->where("session_type", "=", $session_type)
    			->where("session_number", "=", $session_number)
    			->get()->toArray();
    	
    		$new_array = array(
    			"session" => $session,
    			"course_code" => $course->coursecode,
    			"session_type" => $session_type,
    			"session_number" => $session_number,
    		);
    		
    		if (count($check) == 1) {
    			array_push($rV, $new_array);
    		}
    	}	
    	
    	return $rV;
    }
    
    public static function getId($session, $course_code, $session_type, $session_number) {
    	$check = Course::where("course_code", "=", $course->coursecode)
    			->where("session", "=", $session)
    			->where("session_type", "=", $session_type)
    			->where("session_number", "=", $session_number)
    			->get()->toArray();
    			
    	if (count($check) == 1) {
	    	return $check[0]['id'];
    	} else {
	    	return -1;
    	}
    }
    
    public static function startAttendence($course_id) {
	    Course::where("id", "=", $course_id)->update(['allow_attendence' => 1]);
    }
    
    public static function stopAttendence($course_id) {
	    Course::where("id", "=", $course_id)->update(['allow_attendence' => 0]);
    }
    
    public static function isAllowingAttendence($course_id) {
    	$check = Course::where("id", "=", $course_id)->get()->toArray();
    	
    	if (count($check) == 1) {
    		return $check[0]['allow_attendence'];
    	} else {
	    	return -1;
    	}
    }   
}
