<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    /**
     * The database table used to keep track of marks.
     *
     * @var string
     */
    protected $table = 'mark';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param int task_id the task id
     * @param int student_id the student id
     * @param int mark the mark for this student for this task_id
     * @param boolean done whether or not this task is done by this student
     */
     
     public static function addMark($task_id, $student_id, $mark, $done) {
     	Mark::insert(['task_id' => $task_id, 'student_id' => $student_id, 'mark' => $mark, 'done' => $done]);
     }
     
     public static function getMarkByTask($task_id) {
     	return Mark::where('task_id', '=', $task_id)->leftJoin('student', 'student.id', '=', 'mark.student_id')->get()->toArray();
     }
}
