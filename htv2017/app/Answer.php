<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The database table used to keep track of possible answers.
     *
     * @var string
     */
    protected $table = 'answer';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param int question_id the question id
     * @param text answer the answer students give
     * @param boolean is_correct if this answer is correct
     */
     
     public static function getAnswers($question_id) {
     	return Answer::where('question_id', '=', $question_id)->get()->toArray();
     }
     
     public static function addAnswer($question_id, $answer, $is_correct) {
     	Answer::insert(['question_id' => $question_id, 'answer' => $answer, 'is_correct' => $is_correct]);
     }
}
