<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('test', 'AuthController@token_test');

//Issue tokens
Route::post('token_store', 'AuthController@store');
Route::post('token_read', 'AuthController@read');
//Invalidate tokens
Route::post('destroy', 'AuthController@logout');
//Refresh token
//Route::post('refresh', 'AuthController@refresh');

//Store
Route::apiResource('recordings', 'Api\VideoApiController');

//Check permissions
Route::get('permissions', 'Api\VideoApiController@permissions');
