<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    /**
     * The database table used to keep track of student responses.
     *
     * @var string
     */
    protected $table = 'response';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param int question_id the question id
     * @param int student_id the student id
     * @param int answer_id the answer id
     * @param text answer the answer students give
     */
     
     public static function addResponse($question_id, $student_id, $answer_id, $answer) {
     	Response::insert(['question_id' => $question_id, 'student_id' => $student_id, 'answer_id' => $answer_id, 'answer' => $answer]);
     }
     
     public static function getAllResponsesFromQuestion($question_id) {
     	return Response::where('question_id', '=', $question_id)->leftJoin('student', 'student.id', '=', 'response.student_id')->get()->toArray();
     }
}
