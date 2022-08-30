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

Route::group(['prefix' => 'auth','as'=>'auth.'], function(){
    Route::post('login','AuthController@login')->name('login');
    Route::delete('logout','AuthController@logout')->name('logout')->middleware(['auth:sanctum']);
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::resource('user','UserController');
});
