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

    public function getIndex($moodleid = null)
    {
        $moodle = new Moodle();
        $moodles = $moodle->getAllMoodle();
        $data['moodles'] = $moodles;
        if(empty($moodleid)) {
            $moodleid = $moodles->first()->id;
        }
        if(!empty($moodles)) {
            $teacher = new Teacher();
            $data['teachers'] = $teacher->getHeadTeacher($moodleid,'1');
        }
        $this->layout->content = View::make('headteacher.index')->with('data',$data)->with('moodleid',$moodleid);
    }

    public function postIndex() {
        return Redirect::to('headTeacher/index/'.Input::get('moodleid'));
    }
    public function postAdd(){
        $validator = Validator::make(Input::all(), Teacher::$rules);
        if ($validator->passes() && Teacher::notSameTeacher(Input::get('teacher'),Input::get('moodleid'))) {
            $teacher = new Teacher();
            $teacher->moodleid = Input::get('moodleid');
            $teacher->password = Hash::make('11111111');
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
            if(!empty($file) && $file->isValid()){
                $clientName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $newName = md5(date('moodle').$clientName).".".$extension;
                $path = $file->move('uploads/images',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给
                $teacher->image = $path->getPathname();
            } else{
                $teacher->image = "public/images/body.jpg";

            }
            $user['username']= "laravel".rand(100,99999).Input::get('teacher');
            $user['password']= "Founder@2015!";
            $user['firstname']= "用户";
            $user['lastname']= '班主任';
            $user['email']= "laravel".rand(100,99999).Input::get('email');
            $user['mnethostid'] = 0;
            $user['idnumber']= 'teacher';
            $moodle = Moodle::find(Input::get('moodleid'));
            $baseurl = $moodle->moodleurl."/webservice/rest/create_users.php";
            //$baseurl = "http://172.19.43.180/fdmoodle/webservice/rest/create_users.php";
            $data = $this->curl_post($baseurl , $user);
            $resultarr = (array)json_decode($data);
            //$tokenurl = "http://172.19.43.180/fdmoodle/login/token.php?username=".$user['username']."&password=".$user['password']."&service=moodle_mobile_app";
            $tokenurl = $moodle->moodleurl."/login/token.php?username=".$user['username']."&password=".$user['password']."&service=moodle_mobile_app";

            $token = $this->curl_post($tokenurl, null);
            $tokenoc = json_decode($token);
            if(!empty($resultarr)) {
                if(isset($tokenoc->token)) {
                    $teacher->token = $tokenoc->token;
                }
                $teacher->mouserid = $resultarr[0]->id;
                $teacher->save();
                return Redirect::to('headTeacher/index')->with('message', '添加成功！');

            } else {
                return Redirect::to('headTeacher/index')->with('message', '网络错误！');
            }
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
        $inclass = ClassTeacher::getClassed($teacherid,$moodleid);
        $moodle = Moodle::find($moodleid);
        $data['classes'] = $classes;
        $data['inclass'] = $inclass;
        $data['moodlename'] = $moodle->moodlename;
        $data['teacherid'] = $teacherid;
        $this->layout->content = View::make('headteacher.class')->with('data',$data);
    }

    public function postClass() {
        $validator = Validator::make(Input::all(), ClassTeacher::$rules);
        $data['classid'] = Input::get('classid');
        $data['moodleid'] = Input::get('moodleid');
        $data['teacherid'] = Input::get('teacherid');
        if ($validator->passes() ) {
            //$classteacher = new ClassTeacher();
            if(Input::get('type') == 'add') {
                $classteacher = ClassTeacher::firstOrCreate($data);
                if(!$classteacher->enable) {
                    $classteacher->enable = '1';
                    $classteacher->save();
                }
            }elseif(Input::get('type') == 'delete'){
                $classteacher = ClassTeacher::where('moodleid','=',$data['moodleid'])
                    ->where('classid','=',$data['classid'])
                    ->where('teacherid','=',$data['teacherid'])
                    ->first();
                $classteacher->delete();
            }
            return Redirect::to('headTeacher/class/'.$data['teacherid'].'/'.$data['moodleid'])->with('message','成功！');
        }
        return Redirect::to('headTeacher/class/'.$data['teacherid'].'/'.$data['moodleid'])->with('message','错误！');
    }
}
