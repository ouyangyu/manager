<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class MoodleApp extends Eloquent {
    protected $table = 'apps';

    public function getALL() {
        return $this->all();
    }

    public function getLast() {
        return $this->orderBy('id','desc')->first();
    }

    public static function setAll($apptype,$equipment){

        if(in_array($apptype,array('teacher','student')) && in_array($equipment,array('phone','pad'))){
            $apps = MoodleApp::where('apptype','=',$apptype)->where('equipment','=',$equipment)->get();
            foreach ($apps as $app)
            {
                $app->isonline = 0;
                $app->save();
            }
            return true;
        }else{
            return false;
        }

    }
}