<?php

class CourseController extends ApiController {

    public function getResource($courseid , $moodleid = 1){
        $str = "11-16-13";

        $courseArray = explode('-',$str);
        foreach($courseArray as $arr) {
            $course = null;
            $course = Course::where('courseid','=', $arr)->where('moodleid','=', $moodleid)->first();
            if(empty($course)) {
                $result[$arr] = "404";

            } else {

                if(empty($course->courseimage)) {
                    $result[$arr] = null;
                } else {
                    $result[$arr] = URL::to($course->courseimage);
                }
            }
        }

        echo json_encode($result);
        /*if(empty($course)) {
            $this->errorjson('404','没有找到！');
        } else {

            if(!empty($course->courseimage)) {
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
        }*/
    }

}
