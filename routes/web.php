<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('site.site-prezentare');
});


Route::get('/admin/learn',function () {
	return view('admin.learn');
});

Route::post("/admin/learn",array("uses"=>"LearnController@learnInsert"));

Route::post("/check-pictures",array("uses"=>"ApiController@checkPictures"));
		