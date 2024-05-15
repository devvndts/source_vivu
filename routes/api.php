<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hello-world', function (Request $request) {
	$data = array(
		array(
			"name"=>"Vũ An Bình",
			"age"=>26
		),
		array(
			"name"=>"Trần Văn A",
			"age"=>26
		),
	);
    return response()->json($data,200);
});
