<?php

class HeadTeacherController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| class mannger Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'ClassController@showWelcome');
	|
	*/

    protected $layout = "layouts.admin";

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));
        //$this->beforeFilter('auth', array('only'=>array('getIndex')));
        $this->beforeFilter('auth', array('except' => ''));
    }

    public function getIndex()
    {
        $moodle = new Moodle();
        $moodles = $moodle->getAllMoodle();

        $this->layout->content = View::make('admin.index')->with('moodles',$moodles);
        //return View::make('hello');
    }
   

}
