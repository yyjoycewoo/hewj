<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {


    /**
     * The database table used to list students.
     *
     * @var string
     */
    protected $table = 'student';

    public $timestamps = false;

    /**
     * --------------Table Fields----------------
     *
     * @param int id the primary key
     * @param string utorid (also id used on intranet)
     * @param string firstname firstname of this person
     * @param string lastname lastname of this person
     */

	/**
	 * Given the peopleID, gets back the primary key
	 *
	 * @param string utorid
	 *
	 * @return primary id if found, null if user does not exist
	 */
	public static function getPrimaryKey($utorid) {
		$results = User::where("utorid", "=", $utorid)->get()->toArray();
		
		//Person not in this system
		if (count($results) == 0) {
			return null;
		}
		
		//Return primary id
		return $results[0]["id"];
	}

    /**
     * Gets a list of all the students
     *
     * @return array of all the students
     */
    public static function listAll() {
        return User::select("id", "firstname", "lastname", "utorid")->get()->toArray();
    }

    /**
     * Added the user to the user table if not already added
     */
    public static function addUserIfNotExist($utorid, $firstname, $lastname) {
        $user = User::where("utorid", "=", $utorid);
        $users = $user->get()->toArray();
        
        $user_insert = array(
            "utorid" => $utorid,
            "firstname" => $firstname,
            "lastname" => $lastname,
        );
        
        //If the user exists, do nothing
        if (count($users) > 0) {
        	$user->update($user_insert);
        } else {
        	$user->insert($user_insert);
        }
    }
}
