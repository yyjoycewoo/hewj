<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\Login;
use App\Course;
use Input;
use Illuminate\Http\Request;

class LandingController extends Controller {
    
    public function showLandingPage() {
        $options = array(
            "courses" => Course::getCoursesCurrentLoggedInStaffIsTeaching(),
        );

        return view("landing")->with($options);
    }
}
