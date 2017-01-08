<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The database table used to keep track of questions.
     *
     * @var string
     */
    protected $table = 'question';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param int course_id the course id
     * @param text question the question
     * @param datetime date the datetime
     */
     
     public static function getQuestions($course_id) {
	     return Question::where('course_id', '=', $course_id)->get()->toArray();
     }
     
     public static function addQuestion($course_id, $question, $date) {
     	Question::insert(['course_id' => $course_id, 'question' => $question, 'date' => $date]);
     }
}
