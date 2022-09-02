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
    Route::get('verify_token','AuthController@verify_token')->middleware(['auth:sanctum']);
});

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::resource('user','UserController');
    Route::resource('obatalkes','ObatAlkesController',['parameters' => ['obatalkes' => 'id']]);
    Route::resource('signa','SignaController',['parameters' => ['signa' => 'id']]);
    Route::resource('obatalkes_racikan','ObatAlkesRacikanController', ['parameters' => ['obatalkes_racikan' => 'obatalkes_racikan']]);

    Route::resource('resep','ResepController');
    Route::get('resep/{resep}/pdf','ResepController@pdf');
});
