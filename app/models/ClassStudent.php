<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class ClassStudent extends Eloquent  {



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'classuser';


	public static $rules = array(

	    );



    public function getClassStudent($classid,$moodleid) {

        $classstudent = DB::table($this->table)
            ->join('students', 'students.id', '=', 'classuser.studentid')
            ->select('students.*')
            ->where('classuser.classid','=',$classid)
            ->where('students.moodleid','=',$moodleid)
            ->paginate(6);
        return $classstudent;
    }



	public function up(){
	}

	public function down(){

	}

}
