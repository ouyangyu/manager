<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::controller('admin', 'AdminController');
Route::controller('class', 'ClassController');
Route::controller('mentor', 'MentorController');
Route::controller('headTeacher', 'HeadTeacherController');
Route::controller('users', 'UsersController');
Route::controller('home', 'HomeController');
Route::controller('course', 'CourseController');
Route::controller('api','ApiController');
/*Event::listen("illuminate.query", function($query, $bindings){
    var_dump($query);//sql 预处理 语句
    var_dump($bindings);// 替换数据
    echo "</br>";
});*/