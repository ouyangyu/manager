<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class Resource extends Eloquent {
    protected $table = 'resources';

    public static $rules = array(
        'resourceimage'=>'image',
        'resourceurl'=>'required|url',

    );

    public function getResoursByCourse($courseid) {
        return $this->where('courseid','=',$courseid)->get();
    }
}