<?php

class ApiController extends Controller {

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        //$this->beforeFilter('auth', array('only'=>array('getDashboard')));

    }
	/**
	 * API基本控制类.
	 *
	 * @return void
	 */

    protected function errorjson($status,$message){
        $data['status'] = $status;
        $data['message'] = $message;
        echo json_encode($data);
    }

    public function postLogin() {

        array('email'=>Input::get('email'), 'password'=>Input::get('password'));

    }

}
