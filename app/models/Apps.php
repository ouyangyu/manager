<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/7/29
 * Time: 16:18
 */

class Apps extends Eloquent {
    protected $table = 'apps';

    public static function getOnline($isonline = '1') {
        return Apps::where('isonline','=',$isonline)->get();
    }
}