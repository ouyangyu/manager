<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class ClassTeacher extends Eloquent  {

    use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'classteacher';
    protected $fillable = ['moodleid', 'classid','teacherid' ];


    protected $dates = ['deleted_at'];
	public static $rules = array(

	    );


    public static function getTeacherClass($teacherid, $moodleid) {
        $classid = ClassTeacher::where('teacherid','=',$teacherid)->where('classteacher.moodleid','=',$moodleid)
            ->join('classes','classes.id','=','classteacher.classid')
            ->get(array('classes.id','name','count'));
        return $classid;

    }


    public static  function  getClassed($teacherid , $moodleid = '1') {
        $classids = ClassTeacher::where('teacherid','=',$teacherid)->where('moodleid','=',$moodleid)->lists('classid');
        if(count($classids)) {
            return $classids;
        }
        return array();
    }



	public function up(){
	}

	public function down(){

	}

}
