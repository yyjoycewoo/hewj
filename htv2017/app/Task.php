<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The database table used to keep track of tasks.
     *
     * @var string
     */
    protected $table = 'task';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param int course_id the course id
     * @param datetime date the date for this task
     * @param text name the name of the task
     */
     
     public static addTask($course_id, $date, $name) {
     	Task::insert(['course_id' => $course_id, 'date' => $date, 'name' => $name]);
     }
     
     public static getTask($course_id) {
     	return Task::where('course_id', '=', $course_id)->get()->toArray();
     }
}
