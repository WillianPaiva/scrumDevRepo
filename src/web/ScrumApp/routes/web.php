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


Route::get('/', 'WelcomeControler@index')->name('welcome');
Auth::routes();

Route::get('/profile','UserController@userProfile')->name('profile');
Route::get('/project/list','ProjectController@getProject')->name('projects');
Route::post('/project/add','ProjectController@showAddProjectForm');
Route::post('/project/addProject','ProjectController@createProject');
Route::get('/project/{id}','ProjectController@showProject')->name('showProject');