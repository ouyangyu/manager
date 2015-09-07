<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class Teacher extends Eloquent {
    protected $table = 'teachers';

    public  static $rules = array(
        'image' => 'image',
        'email' => 'required|email',
        'phone' => 'required|digits:11',
        'teacher'=>'required|alpha_num',
        'name' => 'required',
        'moodleid'=>'required',

    );

    public function getHeadTeacher($moodleid = '1',$type = '1') {
        return $this->where('moodleid','=',$moodleid)->where('type','=',$type)->paginate(4);
    }

    public static  function notSameTeacher($teacher,$moodleid = '1') {
        $teacher = Teacher::where('moodleid','=',$moodleid)->where('teacher','=',$teacher)->count();
        if($teacher == 0) {
            return true;
        }else {
            return false;
        }
    }
}