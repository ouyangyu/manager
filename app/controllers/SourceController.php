<?php

class SourceController extends BaseController {

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
        $resources = new Resource();
        $data['resources'] = $resources->getResoursByCourse(0);
        $this->layout->content = View::make('source.index')->with('data',$data);

	}


    public function postIndex() {

        $rules = array(
            'resourceimage'=>'image',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $file = Input::file('resourceimage');
            if($file->isValid()){
                $clientName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $newName = md5(date('moodle').$clientName).".".$extension;
                $path = $file->move('uploads/images/resource',$newName); //这里是缓存文件夹，存放的是用户上传的原图，这里要返回原图地址给
                $resource = new Resource();
                $resource->resourceid = 0;
                $resource->courseid = 0;
                $resource->resourcename = Input::get('resourcename');
                $resource->resourceimage = $path->getPathname();
                $resource->resourcetype = Input::get('resourcetype');
                $resource->resourceurl = "null";
                $resource->save();
                return Redirect::to('source/index')->with('message', '上传成功！');
            }
        }
        return Redirect::to('source/index')->with('message','上传失败！');

    }


}
