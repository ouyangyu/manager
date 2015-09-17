<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class Moodle extends Eloquent {
    protected $table = 'moodle';

    public static $rules = array(
        'moodlename'=>'required|min:2',
        'moodleurl'=>'required|url',

    );
    public function getAllMoodle() {
        return $this->all();
    }

    public static function getMoodlePage() {
        return Moodle::paginate(4);
    }

    public static function isTotal($moodleid){
        $moodle = Moodle::find($moodleid);
        if($moodle->istotal) {
            return true;
        }else{
            return false;
        }
    }

    public static function getMoodleName($moodleid) {
        $moodle = Moodle::find($moodleid);
        return $moodle->moodlename;
    }

    public static function isNull() {
        if(Moodle::all()->count()) {
            return true;
        }
        return false;
    }

    /**
     * 存在分部moodle平台
     */
    public static function hasreMoodle() {
        if(Moodle::where('istotal','=','0')->get()->count()){
            return true;
        }
        return false;
    }
}