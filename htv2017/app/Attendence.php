<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    /**
     * The database table used to keep track of attendence.
     *
     * @var string
     */
    protected $table = 'attendence';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param int course_id the course id
     * @param int student_id the student id
     * @param datetime date the datetime
     */
     
     public static function getAttendenceByCourse($course_id) {
     	return Attendence::where('course.id', '=', $course_id)
     			->leftJoin('course', 'attendence.course_id', '=', 'course.id')
     			->leftJoin('student', 'attendence.student_id', '=', 'student.id')
     			->select('student.first_name', 'student.last_name', 'attendence.date')
			    ->get()
			    ->toArray();
     }
     
     public static function setAttendence($course_id, $student_id) {
     	Attendence::insert(['course_id' => $course_id, 'student_id' => $student_id]);
     }
}
