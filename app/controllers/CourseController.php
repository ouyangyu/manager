<?php

class CourseController extends ApiController {

    public function getMoodle() {
        $moodles = Moodle::all(array('id','moodlename','moodleurl','istotal'));
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

    public function getCourseus($courseids = null,$moodleid=null){
        if(!empty($courseids) && !empty($moodleid)) {
            $courseArray = explode('-',$courseids);
            $moodle = Moodle::find($moodleid);
            if(count($courseArray)){
                foreach($courseArray as $courseid) {
                    $course = Course::where('courseid','=', $courseid)->where('moodleid','=', $moodleid)->first();
                    if(!empty($course)) {
                        //course后面会发生变化，因此要先保留总部平台人数
                        $mstudentCount = $course->usercount;
                        $mteacherCount = $course->teachercount;
                        if($moodle->istotal == '0') {
                            $courseToCourse = CourseToCourse::where('bmoodleid','=',$moodleid)
                                ->where('bcourseid','=',$course->id)->first();
                            $course = Course::find($courseToCourse->mcourseid);
                            $moodle = Moodle::find($courseToCourse->mmoodleid);
                        }
                        $counts = $this->getCounts($course->id,$course->moodleid);
                        $counts['studentCount'] = $counts['studentCount'] + $mstudentCount;
                        $counts['teacherCount'] = $counts['teacherCount'] + $mteacherCount;
                        $counts['student'][$moodle->area]['count'] = $counts['student'][$moodle->area]['count'] + $course->usercount;
                        $counts['teacher'] = $this->getTeachers($course->id,$course->moodleid);
                        $image = empty($course->courseimage) ? "404" : URL::to($course->courseimage);

                        $counts['image'] = $image;
                        $result[$courseid][] = $counts;
                    } else {
                        $result[$courseid][] = '404';
                    }
                }
                $data['status'] = 'true';
                $data['message'] = $result;
            }else {
                $data['status'] = 'false';
                $data['message'] = "课程id为NULL！";
            }

        }else{
            $data['status'] = 'false';
            $data['message'] = "缺少必要的参数！";
        }
        echo json_encode($data);


    }

    private function getCounts($courseid,$moodleid){
        $courseList = CourseToCourse::where('mmoodleid','=',$moodleid)
            ->where('mcourseid','=',$courseid)->get();
        $data['studentCount'] = 0;
        $data['teacherCount'] = 0;
        $data['student'] = 'null';
        $areaAll = Moodle::all()->lists('area');
        foreach($areaAll as $key => $value) {
            $data['student'][$value]['name'] = Area::find($value)->title;
            $data['student'][$value]['count'] = 0;
        }

            if(count($courseList)) {
            foreach($courseList as $courseToCourse) {
                $moodle = Moodle::find($courseToCourse->bmoodleie);
                $course = Course::find($courseToCourse->bcourseid);
                $data['studentCount'] = $data['studentCount'] + $course->usercount;
                $data['teacherCount'] = $data['teacherCount'] + $course->teachercount;
                $data['student'][$moodle->area]['count'] = $data['student'][$moodle->area]['count'] + $course->usercount;

                }
            }
            //$data['student'][Area::find($moodle->area)->title] = $course->usercount;

        return $data;

    }

    public function getCteachers($courseid = null,$moodleid=null){
        if(!empty($courseid) && !empty($moodleid)) {

            $moodle = Moodle::find($moodleid);
            $course = Course::where('courseid','=', $courseid)->where('moodleid','=', $moodleid)->first();
            if(!empty($course)) {

                if($moodle->istotal == '0') {
                     $courseToCourse = CourseToCourse::where('bmoodleid','=',$moodleid)
                                ->where('bcourseid','=',$course->id)->first();
                     $course = Course::find($courseToCourse->mcourseid);
                }

                $teacher = $this->getTeachers($course->id,$course->moodleid);
                if(empty($teacher)) {
                    $teacher = '404';
                }

            } else {
                $teacher = '404';
             }

            $data['status'] = 'true';
            $data['message'] = $teacher;

        }else{
            $data['status'] = 'false';
            $data['message'] = "缺少必要的参数！";
        }

        echo json_encode($data);
    }


    private function getTeachers($courseid,$moodleid) {
        $courseList = CourseToCourse::where('mmoodleid','=',$moodleid)
            ->where('mcourseid','=',$courseid)->get();
        $data = null;
        if(count($courseList)) {
            foreach($courseList as $courseToCourse) {
                $moodle = Moodle::find($courseToCourse->bmoodleie);
                //$course = Course::find($courseToCourse->bcourseid);
                $courseTeacher = CourseTeacher::where('moodleid','=',$courseToCourse->bmoodleie)
                    ->where('courseid','=',$courseToCourse->bcourseid)->get();
                if(count($courseTeacher)) {
                    foreach($courseTeacher as $teach) {
                        $teacher['mteacherid'] = $teach->teacherid;
                        $teacher['teachername'] = $teach->teachername;
                        $data[] = $teacher;

                    }
                }
                if(empty($data)) {
                    $result[$moodle->moodlename][] = $data;
                }
                $data = null;

            }
            $courseToCourse = $courseList->first();
            $moodle = Moodle::find($courseToCourse->mmoodleie);
            //$course = Course::find($courseToCourse->bcourseid);
            $courseTeacher = CourseTeacher::where('moodleid','=',$courseToCourse->mmoodleie)
                ->where('courseid','=',$courseToCourse->mcourseid)->get();
            if(count($courseTeacher)) {
                foreach($courseTeacher as $teach) {
                    $teacher['mteacherid'] = $teach->teacherid;
                    $teacher['teachername'] = $teach->teachername;
                    $data[] = $teacher;
                }
            }
            if(empty($data)) {
                $result[$moodle->moodlename][] = $data;
            }
            $data = null;

        }else{
            $result = null;
        }

        return $result;
    }
}
