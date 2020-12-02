<?php

use App\Services\AuthHandler;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Under development
|
*/

if (class_exists(AuthHandler::class))
    $login = app()->make('SystemService')->authorize()->global->login_route;
//Endpoint
Route::get($login, 'SystemController@login')->name('login');

Route::middleware('entitlements')->group(function () {
    Route::get('/', 'PlayController@index')->name('home');
    Route::get('/manage', 'PlayController@manage')->name('manage');
    Route::get('/mediasite', 'PlayController@mediasite')->name('mediasite');
    Route::get('/mediasiteFetch', 'PlayController@mediasiteFetch')->name('mediasiteFetch');
    Route::post('/mediasiteCourseDownload', 'PlayController@mediasiteCourseDownload')->name('mediasiteCourseDownload');
    Route::post('/mediasiteRecordingDownload', 'PlayController@mediasiteRecordingDownload')->name('mediasiteRecordingDownload');
    Route::post('/mediasiteUserDownload', 'PlayController@mediasiteUserDownload')->name('mediasiteUserDownload');
    Route::post('/mediasiteOtherDownload', 'PlayController@mediasiteOtherDownload')->name('mediasiteOtherDownload');
    Route::get('find', 'TestController@find')->name('find');

    Route::get('/player/{video}', 'PlayController@player')->name('player');
    Route::get('/multiplayer', 'PlayController@multiplayer')->name('multiplayer');
    Route::get('/presentation/{id}', 'PlayController@presentation');
    Route::get('/playlist/{id}', 'PlayController@playlist');

    Route::get('/list', 'TestController@index')->name('list');
    Route::post('/search', 'TestController@search')->name('search');

    Route::get('/videos/{video}', 'TestController@show')->name('videos.show');
    Route::post('/manage/deleteAjax', 'PlayController@deleteVideoAjax')->name('manage.deleteVideo');
    Route::post('/manage/editAjax', 'PlayController@editVideoAjax')->name('manage.editVideo');
    Route::get('/categories/{category}', 'TestController@show')->name('categories.show');
    Route::get('/course/{course}', 'TestController@show')->name('course.show');

    Route::get('/upload', 'PlayController@upload');
    Route::post('/store', 'PlayController@store')->name('store');

    //Testing routes
    Route::get('/php', 'TestController@php')->name('php');
    Route::get('/server', 'TestController@server')->name('server');
    Route::get('/thumb', 'TestController@thumb')->name('thumb');
    Route::get('/daisy', 'TestController@daisy')->name('daisy');
    Route::get('/daisyload', 'TestController@daisyLoadCourses');
    Route::get('/json', 'TestController@storeJson');
});
