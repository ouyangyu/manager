<?php

class ApiController extends Controller {


	/**
	 * API基本控制类.
	 *
	 * @return void
	 */

    protected function errorjson($status,$message){
        $data['status'] = $status;
        $data['message'] = $message;
        echo json_encode($data);
    }


    protected function retrunjson($message = '空数据！') {
        if(count($message)) {
            $data['status'] = 'true';
            $data['message'] = $message;
        }else {
            $data['status'] = 'false';
            $data['message'] = $message;
        }
        echo json_encode($data);
    }

    public function postLogin() {

        if(Input::get('type') == 'teacher') {
            $teachername = Input::get('teacher');
            $teacherphone = Input::get('phone');
            if(!empty($teachername)) {
                $teacher = Teacher::where('teacher','=',$teachername)
                    ->where('moodleid','=',Input::get('moodleid'))
                    ->where('type','=','1')
                    ->first();
            } elseif(!empty($teacherphone)) {
                $teacher = Teacher::where('phone','=',$teacherphone)
                    ->where('moodleid','=',Input::get('moodleid'))
                    ->where('type','=','1')
                    ->first();
            }

            if(!empty($teacher)) {

                if(Hash::check(Input::get('password'),$teacher->password)) {
                    $data['status'] = 'true';
                    $data['message'] = [
                        'id'=>$teacher->id,
                        'teacher' => $teacher->teacher,
                        'name' => $teacher->name,
                        'image' => URL::asset($teacher->image),
                        "email"=> $teacher->email,
                        "phone"=> $teacher->phone,
                        "nativeplace"=> $teacher->nativeplace,
                        "nation"=> $teacher->nation,
                        "major"=> $teacher->major,
                        "identity"=> $teacher->identity,
                        "education"=> $teacher->education,
                        "sex"=> $teacher->sex,
                        "mouserid"=> $teacher->mouserid
                    ];

                } else{
                    $data['status'] = 'false';
                    $data['message'] = '密码错误!';
                }

            }else{
                $data['status'] = 'false2';
                $data['message'] = "用户名错误！";
            }
        }else{
            $data['status'] = 'false3';
            $data['message'] = "用户名错误！";
        }

        echo json_encode($data);



    }

}
