<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class Teacher extends Eloquent {
    protected $table = 'teachers';
    protected $hidden = array('password');

    public  static $rules = array(
        'image' => 'image',
        'email' => 'required|email|unique:teachers',
        'phone' => 'required|digits:11|unique:teachers',
        'teacher'=>'required|alpha_num',
        'name' => 'required',
        'moodleid'=>'required',

    );

    public function getHeadTeacher($moodleid = '1',$type = '1') {
        return $this->where('moodleid','=',$moodleid)->where('type','=',$type)->paginate(15);
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