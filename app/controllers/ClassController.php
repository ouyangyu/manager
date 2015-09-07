<?php

class ClassController extends BaseController {

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
        $data['moodles'] = $moodle->getAllMoodle();
        if(!empty($moodles)) {
            $class = new Classes();
            $data['classes'] = $class->getClassByMoodle();
        }

        $this->layout->content = View::make('class.index')->with('data',$data);
    }

    public function postIndex(){
        $moodle = new Moodle();

        $data['moodles'] = $moodle->getAllMoodle();
        $moodleid = Input::get('moodleid');
        $moodle = Moodle::find($moodleid);
        if(!empty($moodle)) {
            $class = new Classes();
            $data['classes'] = $class->getClassByMoodle($moodleid);
        }

        $this->layout->content = View::make('class.index')->with('data',$data)->with('moodleid',$moodleid);
    }

    public function postAdd()
    {
        $rules = array();
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) {
            $class = new Classes();//实例化User对象
            $class->moodleid = Input::get('moodleid');
            $class->name = Input::get('name');
            $class->public = Input::get('public');
            $class->describe = Input::get('describe');
            if ($class->save()) {
                return Redirect::to('class/index')->with('message', '添加成功！');
            } else {
                return Redirect::to('class/index')->with('message', '添加失败！');
            }
        }
    }

    public function postUpdate() {
        $rules = array(
            'moodleid'=>'required',
            'classname'=>'required',
            'classid'=>'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) {
            $class = Classes::find(Input::get('classid'));//实例化User对象
            $class->moodleid = Input::get('moodleid');
            $class->name = Input::get('classname');
            $class->public = Input::get('classpublic');
            $class->describe = Input::get('classdescribe');
            if ($class->save()) {
                return Redirect::to('class/index')->with('message', '修改成功！');
            } else {
                return Redirect::to('class/index')->with('message', '修改失败！');
            }
        }
    }

    public function getClassstudent($classid,$moodleid) {
        $classStudent = new ClassStudent();
        $student = $classStudent->getClassStudent($classid,$moodleid);
        $this->layout->content = View::make('class.classstudent')->with('classstudent',$student)->with('moodleid',$moodleid)->with('classid',$classid);

    }

    public function getStudent($classid,$moodleid) {
        $student = Student::getStudentByMoodle($moodleid,$classid);
        $this->layout->content = View::make('class.student')->with('students',$student)->with('classid',$classid);
    }

    public function postStudent() {
        $studentids = Input::get('studentids');
        $moodleid = Input::get('moodleid');
        $classid = Input::get('classid');

        $studentids = explode(",",$studentids);
        foreach($studentids as $id) {
            $classStudent = new ClassStudent();
            $classStudent->moodleid = $moodleid;
            $classStudent->classid = $classid;
            $classStudent->studentid = $id;
            $classStudent->save();
        }
        $class = Classes::find($classid);
        $class->count = $class->count + count($studentids);
        $class->save();
        return Redirect::to('class/classstudent/'.$classid.'/'.$moodleid)->with('message', '添加成功！');

    }

}
