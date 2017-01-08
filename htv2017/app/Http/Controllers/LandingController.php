<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\Login;
use App\Course;
use App\Attendence;
use Input;
use Redirect;
use Illuminate\Http\Request;

class LandingController extends Controller {
    
    public function showLandingPage() {
        $options = array(
            "courses" => Course::getCoursesCurrentLoggedInStaffIsTeaching(),
            "activatedCourses" => Course::getAcitivatedCourses(),
        );

        return view("landing")->with($options);
    }
    
    public function courseAttendence() {
    	$course_id = Input::get('courseId');
    	$date = Input::get('date', null);
    	
    	if ($course_id == null) {
    		return Redirect::to('/');
    	}
    
    	$options = array("course" => Course::getCourse($course_id));
    	
    	if ($date == null) {
    		$options["attendence"] = Attendence::getAttendenceByCourse($course_id);
    	} else {
    		$options["attendence"] = Attendence::getAttendenceByCourseAndDate($course_id, $date);
    		$options["date"] = $date;
    	}
    	
    	return view("courses")->with($options);
    }
}
