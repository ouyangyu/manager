<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class Classes extends Eloquent {
    protected $table = 'classes';

    public static $rules = array(
        'name'=>'required|min:2',
        'moodleid'=>'required',

    );
    public function getClassByMoodle($moodleid = '1') {
        return $this->where('moodleid','=',$moodleid)->get();
    }
}