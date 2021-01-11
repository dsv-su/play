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

    //Manual upload
    Route::get('/manual_upload', 'ManualUploadController@index')->name('manual_upload');
    Route::post('/manual_step1_store', 'ManualUploadController@step1')->name('manual_step1');
    Route::post('/gen_thumb/{id}', 'ManualUploadController@gen_thumb')->name('gen_thumb');
    Route::post('/gen_poster/{id}', 'ManualUploadController@gen_poster')->name('gen_poster');
    Route::get('/manual_step3_store/{id}', 'ManualUploadController@step3')->name('manual_step3');
    Route::post('/manual_store', 'ManualUploadController@store')->name('manual_store');
    Route::get('/manual_send/{id}', 'ManualUploadController@send');
    Route::get('/manual_admin', 'ManualUploadController@admin')->name('manual_admin');
    Route::get('/manual_admin_erase/{id}', 'ManualUploadController@admin_erase')->name('manual_admin_erase');
    Route::get('/manual_admin_notify/{id}', 'ManualUploadController@admin_notify')->name('manual_admin_notify');
    Route::get('/manual_admin_unregister/{id}', 'ManualUploadController@admin_unregister')->name('manual_admin_unregister');
    Route::get('/dev_destroy/{id}', 'ManualUploadController@destroy');

    //Testing routes
    Route::get('/php', 'TestController@php')->name('php');
    Route::get('/server', 'TestController@server')->name('server');
    Route::get('/daisy', 'TestController@daisy')->name('daisy');
    Route::get('/daisyload', 'TestController@daisyLoadCourses');
    Route::get('/token/{video}', 'TestController@token');
    Route::get('/decode/{token}', 'TestController@decode');
});
