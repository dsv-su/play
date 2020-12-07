<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('token', 'AuthController@login');
Route::post('destroy', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::apiResource('recordings', 'Api\VideoApiController');
Route::get('permission', 'Api\VideoApiController@permission');
