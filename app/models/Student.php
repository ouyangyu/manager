<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Student extends Eloquent  {



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'students';


	public static $rules = array(
	    'username'=>'required|alpha|min:2',
	    'email'=>'required|email|unique:users',
	    );

	public function up(){
		

	}

	public function down(){

	}

}
