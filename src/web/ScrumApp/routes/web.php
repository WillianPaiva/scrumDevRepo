<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', 'WelcomeControler@index');
Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/profile','UserController@userProfile');

Route::get('/project/list','ProjectController@getProject')->middleware('auth');

Route::post('/project/add','ProjectController@showAddProjectForm')->middleware('auth');

Route::post('/project/addProject','ProjectController@createProject')->middleware('auth');