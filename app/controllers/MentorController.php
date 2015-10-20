<?php

class MentorController extends BaseController {

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

    public function getIndex($moodleid = null)
    {

        $moodles = Moodle::all();
        if(!empty($moodles) ) {
            if(empty($moodleid)) {
                $moodleid = $moodles->first()->id;
            }
            $teachers = CourseTeacher::where('moodleid','=',$moodleid)->groupBy('teacherid')->paginate(15);
            foreach($teachers as $teacher){
                $courseid = CourseTeacher::where(array('moodleid'=>$moodleid,'teacherid'=>$teacher->teacherid))->lists('courseid');
                $teacher->courseids = $courseid;
            }

            $data['teachers'] = $teachers;
        }
        $data['moodles'] = Moodle::all();
        $this->layout->content = View::make('mentor.index')->with('data',$data)->with('moodleid',$moodleid);
        //return View::make('hello');
    }


    public function postIndex() {
        return Redirect::to('mentor/index/'.Input::get('moodleid'));
    }

}
