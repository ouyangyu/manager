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
}