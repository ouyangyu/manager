<?php

class CourseController extends ApiController {

    public function getResource($courseid , $moodleid = 1){
        $course = Course::where('courseid','=', $courseid)->where('moodleid','=', $moodleid)->first();
        if(empty($course)) {
            $this->errorjson('404','没有找到！');
        } else {
            $data['image'] = URL::to($course->courseimage);
            $resources = Resource::where('courseid','=',$course->id)->get();
            $redate = array();
            foreach($resources as $resource) {
                $resource->resourceimage =  URL::to($resource->resourceimage);
            }

            $data['resource'] = $resources;
            echo json_encode($data);
        }
    }

}
