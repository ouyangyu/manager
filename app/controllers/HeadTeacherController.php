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
        $data['moodles'] = $moodles;
        if(!empty($moodles)) {
            $teacher = new Teacher();
            $data['teachers'] = $teacher->getHeadTeacher($moodles->first()->id,'1');

        }

        $this->layout->content = View::make('headteacher.index')->with('data',$data);
        //return View::make('hello');
    }

    public function postIndex() {
        return Redirect::to('headTeacher/index');
    }
    public function postAdd(){
        $validator = Validator::make(Input::all(), Teacher::$rules);

        if ($validator->passes() && Teacher::notSameTeacher(Input::get('teacher'),Input::get('moodleid'))) {
            $teacher = new Teacher();
            $teacher->moodleid = Input::get('moodleid');
            $teacher->password = Hash::make(Input::get('111111'));
            $teacher->teacher = Input::get('teacher');
            $teacher->email = Input::get('email');
            $teacher->phone = Input::get('phone');
            $teacher->name = Input::get('name');
            $teacher->major = Input::get('major');
            $teacher->sex = Input::get('sex');
            $teacher->nation = Input::get('nation');
            $teacher->identity = Input::get('identity');
            $teacher->nativeplace = Input::get('nativeplace');
            $teacher->education = Input::get('education');
            $file = Input::file('image');
            if($file->isValid()){
                $clientName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $newName = md5(date('moodle').$clientName).".".$extension;
                $path = $file->move('uploads/images',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给
                $teacher->image = $path->getPathname();
            }
            $teacher->save();
            return Redirect::to('headTeacher/index')->with('message', '添加成功！');


        }else{
            return Redirect::to('headTeacher/index')->with('message', '请按要求填写！');

        }
    }

    public function postUpdate(){
        $validator = Validator::make(Input::all(), Teacher::$rules);

        if ($validator->passes() ) {
            $teacher = Teacher::find(Input::get('id'));
            $teacher->moodleid = Input::get('moodleid');
            if($teacher->teacher != Input::get('teacher')) {
                if(Teacher::notSameTeacher(Input::get('teacher'),Input::get('moodleid'))){
                    $teacher->teacher = Input::get('teacher');
                }
            }
            $teacher->email = Input::get('email');
            $teacher->phone = Input::get('phone');
            $teacher->name = Input::get('name');
            $teacher->major = Input::get('major');
            $teacher->sex = Input::get('sex');
            $teacher->nation = Input::get('nation');
            $teacher->identity = Input::get('identity');
            $teacher->nativeplace = Input::get('nativeplace');
            $teacher->education = Input::get('education');
            $file = Input::file('image');
            if(is_object($file) && $file->isValid()){
                $clientName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $newName = md5(date('moodle').$clientName).".".$extension;
                $path = $file->move('uploads/images',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给
                $teacher->image = $path->getPathname();
            }
            $teacher->save();
            return Redirect::to('headTeacher/index')->with('message', '添加成功！');


        }else{
            return Redirect::to('headTeacher/index')->with('message', '请按要求填写！');

        }
    }


    public function getClass($teacherid,$moodleid = '1') {

        $classes = Classes::where('moodleid','=',$moodleid)->get();


        $this->layout->content = View::make('headteacher.index')->with('data',$data);

    }


}
