<?php

class CourseController extends ApiController {

    public function getMoodle() {
        $moodles = Moodle::all(array('id','moodlename','moodleurl'));
        echo json_encode($moodles);
    }

    public function getResource($courseid , $moodleid = 1){
        $course = Course::where('courseid','=', $courseid)->where('moodleid','=', $moodleid)->first();
        if(empty($course)) {
            $this->errorjson('404','没有找到！');
        } else {
            if(empty($course->courseimage)) {
                $data['image'] = null;
            } else {
                $data['image'] = URL::to($course->courseimage);
            }
            $resources = Resource::where('courseid','=',$course->id)->get();
            foreach($resources as $resource) {
                $resource->resourceimage =  URL::to($resource->resourceimage);
            }
            $data['resource'] = $resources;
            echo json_encode($data);
        }
    }

    public function getImage($courseid , $moodleid = 1){
        $courseArray = explode('-',$courseid);
        foreach($courseArray as $arr) {
            $course = null;
            $course = Course::where('courseid','=', $arr)->where('moodleid','=', $moodleid)->first();
            if(empty($course)) {
                $result[$arr] = "404";
            } else {
                if(empty($course->courseimage)) {
                    $result[$arr] = '404';
                } else {
                    $result[$arr] = URL::to($course->courseimage);
                }
            }
        }
        echo json_encode($result);
    }

    public  function getApp($version = null){
        $app = Apps::getOnline()->first();
        if(!empty($app) ){
            if($app->appversion != $version) {
                $data['version'] = $app->appversion;
                $data['file'] = URL::to($app->appfile);
            }else{
                $data['version'] = $app->appversion;
                $data['file'] = "";
            }
        }
            else {
            $data['version'] = "";
            $data['file'] = "";
        }
        echo json_encode($data);
    }

    public function getIndex($teacherid, $moodleid) {
        $result = ClassTeacher::getTeacherClass($teacherid,$moodleid);
        if(count($result)) {
            $data['status'] = 'true';
            $data['message'] = $result;
        }else {
            $data['status'] = 'false';
            $data['message'] = "无班级关联！";
        }
        echo json_encode($data);
    }

    public function getCusers($classid,$moodleid) {
        $result = ClassStudent::getCStudent($classid,$moodleid);

        if(count($result)) {
            $data['status'] = 'true';
            $data['message'] = $result;
        }else {
            $data['status'] = 'false';
            $data['message'] = "无学生！";
        }
        echo json_encode($data);
    }
}
