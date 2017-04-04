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
    return view('twilio');
});
Route::get('/twilio', function () {
    return view('twilio');
});
/*
|------------------------------------------------------------------
| Send SMS to the specified number                     |
|------------------------------------------------------------------
*/
Route::post('/api/sendSms','MsgCallController@sendMsg');

/*
|------------------------------------------------------------------
| Make call to the specified number                     |
|------------------------------------------------------------------
*/
Route::post('/api/makeCall','MsgCallController@makeCall');
