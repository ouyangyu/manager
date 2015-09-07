<?php

class CourseController extends ApiController {

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
}
