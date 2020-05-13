<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Under development
|
*/
use App\Services\AuthHandler;

if (class_exists(AuthHandler::class))
    $login = app()->make('SystemService')->authorize()->global->login_route;
//Endpoint
Route::get($login, 'SystemController@login')->name('login');

//Route::middleware('entitlements')->group(function () {

Route::get('/', 'PlayController@index');
Route::get('/player', 'PlayController@player');
Route::get('/list', 'TestController@index');
Route::post('/search', 'TestController@search')->name('search');
Route::get('/videos/{video}', 'TestController@show')->name('videos.show');
Route::get('/categories/{category}', 'TestController@show')->name('categories.show');

Route::get('/upload', 'PlayController@upload');
Route::post('/store', 'PlayController@store')->name('store');

//});
