<?php

class AdminController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'AdminController@showWelcome');
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
        $moodles = $moodle->getMoodlePage();
        $area = Area::getProvince();
        $this->layout->content = View::make('admin.index')->with('moodles',$moodles)->with('area',$area);
        //return View::make('hello');
	}


    public function postIndex() {
        $validator = Validator::make(Input::all(), Moodle::$rules);
        if($validator->passes()) {
            $moodle = Moodle::find(Input::get('id'));
            $moodle->moodlename = Input::get('moodlename');
            $moodle->moodleurl = Input::get('moodleurl');
            $moodle->isenable = Input::get('isenable');
            $moodle->istotal = Input::get('istotal');
            $moodle->area = Input::get('area');

            if($moodle->save()) {
                return Redirect::to('admin/index')->with('message','修改成功！');
            }

        }
        return Redirect::to('admin/index')->with('message','错误！');

    }
    public function postMoodleadd() {
        $validator = Validator::make(Input::all(), Moodle::$rules);

        if ($validator->passes()) {
            $moodle = new Moodle();//实例化User对象
            $moodle->moodlename = Input::get('moodlename');
            $moodle->moodleurl = Input::get('moodleurl');
            $moodle->isenable = Input::get('isenable');
            $moodle->area = Input::get('area');

            $moodle->save();
            $baseurl = $moodle->moodleurl."/webservice/rest/courses.php";
            //$baseurl = $moodle->moodleurl."/webservice/rest/server.php?moodlewsrestformat=json&moodlewssettingfilter=true&wsfunction=core_course_get_courses&wstoken=50b22875390c83ea2f350fe011a99fd9";
            $data = $this->curl_post($baseurl , null);
            $resultarr = (array)json_decode($data);
            $baseUserurl = $moodle->moodleurl."/webservice/rest/users.php";
            $students = $this->curl_post($baseUserurl , null);
            $studentarray = (array)json_decode($students);
            if(!empty($resultarr)) {
                foreach( $resultarr as $result) {
                    $course = new Course();
                    if(!Course::where(array('courseid'=> $result->id , 'moodleid' => $moodle->id))->count()) {

                        $course->courseid = $result->id;
                        $course->moodleid = $moodle->id;
                        $course->coursename = $result->fullname;
                        $course->courseimage = '';
                        $course->subject = $result->category == '1' ? '其他' : '未定义';
                        $course->isdelete = $result->visible;
                        $course->save();
                    }

                }
            }

            if(!empty($studentarray)) {
                foreach( $studentarray as $student) {
                    if($student->idnumber != 'teacher') {
                        $students = new Student();
                        $students->moodleid = $moodle->id;
                        $students->studentid = $student->id;
                        $students->email = $student->email;
                        $students->username = $student->username;
                        $students->name = $student->lastname.$student->firstname;
                        $students->phone = $student->phone2;
                        $students->save();
                    }
                }
            }


            return Redirect::to('admin/index')->with('message', empty($resultarr) ? '成功,此平台无课程':'添加成功，课程同步成功！');

        } else {
            return Redirect::to('admin/index')->with('message', '添加失败！');
        }
    }
    public function getUsers() {
        $moodle = new Moodle();
        $moodles = $moodle->getAllMoodle();
        if(!empty($moodles)) {
            $student = Student::getStudentAll($moodles->first()->id);
        }

        //$data['userdata'] = $users;
        $this->layout->content = View::make('admin.users')->with('moodles',$moodles)->with('users',$student);
    }

    public function getMoodle($moodleid = '1') {
        $moodle = new Moodle();
        $moodles = $moodle->getAllMoodle();
        $data['moodles'] = $moodle->getAllMoodle();
        $moodle = Moodle::find($moodleid);
        $data['moodle'] = $moodle;

        if(!empty($moodles)) {
            $course = new Course();
            $data['courses'] = $course->getCoursesByMoodle($moodles->first()->id);
        }


        $this->layout->content = View::make('admin.moodle')->with('data',$data);


    }

    public function postMoodle() {
        $moodle = new Moodle();
        $data['moodles'] = $moodle->getAllMoodle();
        $moodle = Moodle::find(Input::get('moodleid'));
        $course = new Course();
        $data['moodle'] = $moodle;
        $data['courses'] = $course->getCoursesByMoodle($moodle->id);
        $this->layout->content = View::make('admin.moodle')->with('data',$data);
    }

    public function getMoodlerelate($courseid){
        $course = Course::find($courseid);
        if(!empty($course)) {
            $relaCourse = CourseToCourse::where('mcourseid','=',$course->id)
                ->where('mmoodleid','=',$course->moodleid)
                ->get();

            $data['relaCourse'] = $relaCourse;
            $data['course'] = $course;

            $this->layout->content = View::make('admin.moodlerelate')->with('data',$data);
        } else{
            return Redirect::to('admin/moodle');

        }
    }

    public function getDeleterelate($id) {
        $relate = CourseToCourse::find($id);
        if($relate->delete()) {
            return Redirect::to('admin/moodlerelate/'.$relate->mcourseid);

        }else{
            return Redirect::to('admin/moodle');

        }

    }

    public function getAddtocourse($courseid,$moodleid = null) {
        $course = Course::find($courseid);
        $moodles = Moodle::where('istotal','=','0')->get();

        $data['moodles'] = $moodles;
        if(!empty($moodles) && empty($moodleid)) {
            $data['courses'] = Course::where('moodleid','=',$moodles->first()->id)->get();
            $data['relate'] = CourseToCourse::where('bmoodleid','=',$moodles->first()->id)->lists('bcourseid');
        } else {
            $data['courses'] = Course::where('moodleid','=',$moodleid)->get();
            $data['relate'] = CourseToCourse::where('bmoodleid','=',$moodleid)->lists('bcourseid');
        }
        $data['selfrelate'] = CourseToCourse::where('mcourseid','=',$courseid)->lists('bcourseid');
        //$courses = Course::where('moodleid','=',Input::get('moodleid'))->get();
        $data['course'] = $course;
        $this->layout->content = View::make('admin.addtocourse')->with('data',$data);

    }

    public function postAddtocourse(){
        $course = Input::get('courseid');
        $moodle = Input::get('moodleid');
        $coursename = Input::get('coursename');
        return Redirect::to('admin/addtocourse/'.$course.'/'.$moodle);
    }


    public function postRelatecourse() {
        $validator = Validator::make(Input::all(), array());
        $courseid = Input::get('mcourseid');
        $moodleid = Input::get('bmoodleid');
        if ($validator->passes()) {
            $relatecourse = new CourseToCourse();
            $relatecourse->mmoodleid = Input::get('mmoodleid');
            $relatecourse->mcourseid = Input::get('mcourseid');
            $relatecourse->bmoodleid = Input::get('bmoodleid');
            $relatecourse->bcourseid = Input::get('bcourseid');
            $relatecourse->save();
            return Redirect::to('admin/moodlerelate/'.$courseid);

        }
        return Redirect::to('admin/addtocourse/'.$courseid.'/'.$moodleid);

    }
    public function postCourse() {

        $rules = array(
            'courseimage' => 'image'
        );
        //var_dump($_FILES);die();
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $file = Input::file('courseimage');
            if($file->isValid()){
                $clientName = $file->getClientOriginalName();
                //$tmpName = $file->getFileName();
                //$realPath = $file->getRealPath();
                $extension = $file->getClientOriginalExtension();
                //$mimeTye = $file->getMimeType();
                $newName = md5(date('moodle').$clientName).".".$extension;
                $path = $file->move('uploads/images',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给
                $course = Course::find(Input::get('id'));
                $course->courseimage = $path->getPathname();
                $course->save();
                return Redirect::to('admin/moodle')->with('message', '上传成功！');

            }
        }else{
            return Redirect::to('admin/moodle')->with('message', '请上传图片！');

        }
    }
    public function getApp() {
        $app = new MoodleApp();
        $apps = $app->getALL();
        $this->layout->content = View::make('admin.app')->with('apps',$apps);

    }

    public function postApp() {
        $validator = Validator::make(Input::all(), array());
        if ($validator->passes()) {
            $file = Input::file('appfile');
            if($file->isValid()){
                $clientName = $file->getClientOriginalName();
                //$tmpName = $file->getFileName();
                //$realPath = $file->getRealPath();
                $extension = $file->getClientOriginalExtension();
                if(in_array($extension,array('apk','gpk','ipa')) ) {
                    //$mimeTye = $file->getMimeType();
                    $newName = 'moodle'.Input::get('appversion').".".$extension;
                    $path = $file->move('uploads/apps',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给
                    $oldapp = new MoodleApp();
                    $oldapp = $oldapp->getLast();
                    if(!empty($oldapp)) {
                        $oldapp->isonline = '0';
                        $oldapp->save();
                    }
                    $app = new MoodleApp();
                    $app->appversion = Input::get('appversion');
                    $app->appfile = $path->getPathname();
                    $app->apptime = date('Y-m-d H:i:s',time());
                    $app->save();

                    return Redirect::to('admin/app')->with('message', '上传成功！');
                } else {
                    return Redirect::to('admin/app')->with('message','文件格式不对！');
                }



            } else {
                return Redirect::to('admin/app')->with('message','文件空！');
            }

        }else {
            return Redirect::to('admin/app')->with('message','文件上传失败！');
        }
    }


    public function getResources($id) {
        $course = Course::find($id);
        if(!empty($course)) {
            $data['course'] = $course;
            $resources = new Resource();
            $data['resources'] = $resources->getResoursByCourse($course->id);
            $this->layout->content = View::make('admin.resource')->with('data',$data);
        } else{
            return Redirect::to('admin/moodle');

        }

    }

    public function postResources() {
        $validator = Validator::make(Input::all(), Resource::$rules);
        if ($validator->passes()) {
            $file = Input::file('resourceimage');
            if($file->isValid()){
                $clientName = $file->getClientOriginalName();
                //$tmpName = $file->getFileName();
                //$realPath = $file->getRealPath();
                $extension = $file->getClientOriginalExtension();
                //$mimeTye = $file->getMimeType();
                $newName = md5(date('moodle').$clientName).".".$extension;
                $path = $file->move('uploads/images/resource',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给
                $resource = new Resource();
                $resource->resourceid = Input::get('resourceid');
                $resource->courseid = Input::get('id');
                $resource->resourcename = Input::get('resourcename');
                $resource->resourceimage = $path->getPathname();
                $resource->resourcetype = Input::get('resourcetype');
                $resource->resourceurl = Input::get('resourceurl');
                $resource->save();
                return Redirect::to('admin/resources/'.Input::get('id'))->with('message', '上传成功！');
                } else {
                    return Redirect::to('admin/resources/'.Input::get('id'))->with('message','上传失败！');
                }
            }
            return Redirect::to('admin/resources/'.Input::get('id'))->with('message','上传失败！');

    }


    /*
     * 更新课程
     * 1、获取课程信息
     * 2、如果存在就更改，不存在就插入
     * 3、如果获取的数据在本地没有，就要删除
     */
    public function getUpcourse($moodleid){
        $moodle = Moodle::find($moodleid);
        $baseurl = $moodle->moodleurl."/webservice/rest/courses.php";

        $data = $this->curl_post($baseurl , null);
        $resultarr = (array)json_decode($data);
        $oldcourseids = Course::where('moodleid','=',$moodleid)->lists('courseid');
        if(!empty($resultarr)) {

            foreach( $resultarr as $result) {
                $course = Course::where(array('courseid'=> $result->id , 'moodleid' => $moodle->id))->first();
                if(!empty($oldcourseids)) {
                    foreach( $oldcourseids as $key => $value ) {
                        if($result->id == $value) {
                            unset($oldcourseids[$key]);
                        }
                    }
                }

                if(empty($course)) {
                    $course = new Course();
                    $course->courseid = $result->id;
                    $course->moodleid = $moodle->id;
                    $course->coursename = $result->fullname;
                    $course->courseimage = '';
                    $course->subject = $result->category == '1' ? '其他' : '未定义';
                    $course->isdelete = $result->visible;
                    $course->save();
                }else{
                    $course->coursename = $result->fullname;
                    $course->subject = $result->category == '1' ? '其他' : '未定义';
                    $course->isdelete = $result->visible;
                    $course->save();
                }
            }
            if(!empty($oldcourseids)) {
                foreach( $oldcourseids as $key => $value ) {
                    $recourse = Course::where(array('courseid'=> $value , 'moodleid' => $moodle->id))->first();
                    Resource::where('courseid','=',$recourse->id)->delete();
                    //Resource::where('courseid','=',$recourse->id)->delete();
                    $recourse->delete();
                }
            }
            return Redirect::to('admin/index')->with('message','课程更新成功！');
        }
        return Redirect::to('admin/index')->with('message','课程更新失败！');
    }


    /*
     * 1、通过curl从moodle平台获取用户数据
     * 2、与本地判断，主要更新内容
     * 3、如果有新用户，加入到本地，如果moodle上有被删除的用户，那此用户相关的内容都删除
     * 4、减少class班级的总人数
     */
    public function getUpusers($moodleid) {
        $moodle = Moodle::find($moodleid);
        $baseurl = $moodle->moodleurl."/webservice/rest/users.php";

        $data = $this->curl_post($baseurl , null);
        $resultarr = (array)json_decode($data);
        $oldStudentids = Student::where('moodleid','=',$moodleid)->lists('studentid');

        if(!empty($resultarr)) {
            foreach( $resultarr as $students) {
                if($students->idnumber != 'teacher') {
                    $localStudent = Student::where(array('studentid'=> $students->id , 'moodleid' => $moodle->id))->first();
                    if(!empty($oldStudentids)) {
                        foreach( $oldStudentids as $key => $value ) {
                            if($students->id == $value) {
                                unset($oldStudentids[$key]);
                            }
                        }
                    }
                    if(!empty($localStudent)) {
                        $localStudent->email = $students->email;
                        $localStudent->username = $students->username;
                        $localStudent->name = $students->lastname.$students->firstname;
                        $localStudent->phone = $students->phone2;
                        $localStudent->save();
                    }else{
                        $newStudent = new Student();
                        $newStudent->moodleid = $moodle->id;
                        $newStudent->studentid = $students->id;
                        $newStudent->email = $students->email;
                        $newStudent->username = $students->username;
                        $newStudent->name = $students->lastname.$students->firstname;
                        $newStudent->phone = $students->phone2;
                        $newStudent->save();
                    }
                }

            }
            if(!empty($oldStudentids)) {
                foreach( $oldStudentids as $key => $value ) {
                    $restudent = Student::where(array('studentid'=> $value , 'moodleid' => $moodle->id))->first();
                    $classstudent = ClassStudent::where('studentid','=',$restudent->id)->where('moodleid','=',$moodle->id)->first();
                    if(!empty($classstudent)){
                        $class = Classes::find($classstudent->classid);
                        $class->count = $class->count - 1;
                        $class->save();
                        $classstudent->delete();
                    }
                    $restudent->delete();
                }
            }
            return Redirect::to('admin/index')->with('message','用户更新成功！');
        }
        return Redirect::to('admin/index')->with('message','用户更新失败！');
    }


    /*
     * 获取选课人数，汇总，加到每个moodle平台的上面
     */
    public function getCourseuc($moodleid){

        $moodle = Moodle::find($moodleid);
        $baseurl = $moodle->moodleurl."/webservice/rest/courses.php";
        $data = $this->curl_post($baseurl , null);
        $resultarr = (array)json_decode($data);
        if(!empty($resultarr)) {
            foreach( $resultarr as $result) {
                $course = Course::where(array('courseid'=> $result->id , 'moodleid' => $moodle->id))->first();
                if(!empty($course)) {
                   // var_dump($result);
                    if(!empty($result->teacher)) {
                        $course->teachercount = count((array)($result->teacher));
                    }
                    $course->usercount = $result->usercount;
                    $course->save();
                }
            }
            die();
            return Redirect::to('admin/index')->with('message','选课人数更新成功！');
        }
        return Redirect::to('admin/index')->with('message','选课人数更新失败！');
    }

}
