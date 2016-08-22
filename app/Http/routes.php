<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('test');
    });

    Route::get('blog','BlogController@index');
    Route::get('blog/{slug}','BlogController@showPost');

    //Admin area
    Route::get('admin', function (){
       return redirect('/admin/post');
    });
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth', 'prefix'=>'admin'],function(){
        Route::resource('post','PostController');
        Route::resource('tag','TagController');
        Route::get('upload','UploadController@index');
    });

    //Admin auth,Logging in and out
    Route::get('auth/login', 'Auth\\AuthController@getLogin');
    Route::post('auth/login', 'Auth\\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@logout');
});
