<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Student extends Eloquent  {



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'students';


	public static $rules = array(
	    'username'=>'required|alpha|min:2',
	    'email'=>'required|email|unique:users',
	    );



    public static function getStudentAll($moodleid) {
        return Student::where('moodleid','=',$moodleid)->paginate(6);

    }
    /*
     * 除去已经在班级里面的学生
     */
    public static  function getStudentByMoodle($moodleid,$classid) {

        $classstudent = ClassStudent::where('moodleid','=',$moodleid)->where('classid','=',$classid)->get(array('studentid'));
        $classstudent = $classstudent->toArray();

        $classs = DB::table('students')
            ->where('students.moodleid','=',$moodleid)
            ->whereNotIn('id',$classstudent)
            ->paginate(6);
        return $classs;
    }



	public function up(){
	}

	public function down(){

	}

}
