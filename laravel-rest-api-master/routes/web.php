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

Route::get('/', function () {
    return view('welcome');
});

/*
|------------------------------------------------------------------
| Get user details                     |
|------------------------------------------------------------------
*/
Route::post('/api/getUsers','apiController@getUsers');

/*
|------------------------------------------------------------------
| Login User                   |
|------------------------------------------------------------------
*/
Route::post('/api/loginUser','apiController@loginUser');

/*
|------------------------------------------------------------------
| Add a new user                   |
|------------------------------------------------------------------
*/
Route::post('/api/addUser','apiController@addUser');

/*
|------------------------------------------------------------------
| Update a user                   |
|------------------------------------------------------------------
*/
Route::post('/api/updateUser','apiController@updateUser');

/*
|------------------------------------------------------------------
| Delete a user                   |
|------------------------------------------------------------------
*/
Route::post('/api/delUser','apiController@deleteUser');