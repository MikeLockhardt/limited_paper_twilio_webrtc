<?php

use Illuminate\Http\Request;

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
    //return $request->user();
    return view('dashboard');
   
});


Route::get('/api_login', ['uses' => 'Api\LoginController@login', 'as' => 'api_login']);
Route::get('/gotoTest', 'Api\LoginController@gotoTest');
