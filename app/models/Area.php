<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class Area extends Eloquent {
    protected $table = 'area';

    public static function getNameById($id) {
        $result = null;
        if(!empty($id)) {
            $result = Area::where('area_id','=',$id)->first()->title;
        }
        return $result;
    }

    public static function getProvince() {
        $result = array();
        $provinces = Area::where('pid','=',0)->get();

        foreach($provinces as $province){
            $result[$province->area_id] = $province->title;
        }

        return $result;
    }

}