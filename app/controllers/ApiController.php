<?php

class ApiController extends Controller {

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



}
