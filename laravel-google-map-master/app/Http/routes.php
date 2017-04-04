<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	$arr = array(
			    array(
			        "latitude" => -25.363,
			        "longitude" => 131.044
			    ),
			    array(
			        "latitude" => -26.363,
			        "longitude" => 136.044
			    ),
			    array(
			        "latitude" => -27.363,
			        "longitude" => 140.044
			    )
			);

		$marks = json_encode($arr);
    // return view('welcome');
    return View::make('welcome')->with('marks', $marks);
});
