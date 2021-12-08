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

// SU idp Endpoints
Route::get('/sulogin', 'SystemController@SUlogin')->name('sulogin');
Route::get($login, 'SystemController@SUidpReturn')->name('login');

//Multiplayer public access
Route::get('/multiplayer', 'MultiplayerController@multiplayer')->name('multiplayer')->middleware('video-permission');
Route::get('/presentation/{id}', 'MultiplayerController@presentation')->middleware('presentation-permission');

//Protected routes
Route::middleware('entitlements', 'playauth')->group(function () {

    Route::get('/', 'PlayController@index')->name('home');
    Route::get('lang/{lang}', 'LocalizationController@index');
    //Search
    Route::get('/semester/{semester}', 'SearchController@searchBySemester')->name('semester');
    Route::post('/semester/{semester}', 'SearchController@filterBySemester')->name('filter_semester');
    Route::get('/designation/{designation}', 'SearchController@searchByDesignation')->name('designation');
    Route::post('/designation/{designation}', 'SearchController@filterByDesignation')->name('filter_designation');
    Route::get('/category/{category}', 'SearchController@searchByCategory')->name('category');
    Route::get('/student/{username}', 'SearchController@searchByUser');
    Route::get('/search/{q}', 'SearchController@search')->name('search');
    Route::post('/search/{q}', 'SearchController@filterSearch')->name('filter_search');
    Route::get('/find', 'SearchController@find')->name('find');

    //Multiplayer
    Route::get('/player/{video}', 'MultiplayerController@player')->name('player');
    Route::get('/playlist/{id}', 'MultiplayerController@playlist');

    //Manage
    Route::get('/manage', 'SearchController@search')->name('manage');
    Route::get('/manage_course', 'ManageCourseSettingsController@index')->name('manage_course');
    Route::get('/course/{courseid}/edit', 'ManageCourseSettingsController@edit')->name('course_edit');
    Route::post('/course/{courseid}/store', 'ManageCourseSettingsController@store')->name('course_edit_store');
    Route::post('/manage', 'SearchController@filterSearch')->name('filter_manage');
    Route::get('/edit/{video}', 'EditController@show')->name('presentation_edit');
    Route::post('/edit/{video}', 'EditController@edit')->name('editpresentation');

    Route::post('/manage/deleteAjax', 'PlayController@deleteVideoAjax')->name('manage.deleteVideo');
    Route::post('/manage/editAjax', 'PlayController@editVideoAjax')->name('manage.editVideo');
    Route::get('/course/{course}', 'SearchController@showCourseVideos')->name('course.videos');
    Route::get('/tag/{tag}', 'SearchController@showTagVideos')->name('tag.videos');
    Route::post('/tag/{tag}', 'SearchController@FilterTagVideos')->name('tag.filter_videos');
    Route::get('/presenter/{presenter}', 'SearchController@showPresenterVideos')->name('presenter.videos');
    Route::post('/presenter/{presenter}', 'SearchController@filterPresenterVideos')->name('presenter.filter_videos');
    Route::get('/my', 'PlayController@myVideos')->name('my.videos');
    Route::post('/my/filter', 'PlayController@myVideosFilter')->name('my.filter');
    Route::get('/edit_permission/{video}', 'ManagePresentationController@SetPermission')->name('edit_permission');
    Route::post('/store_permission/{id}', 'ManagePresentationController@storePermission')->name('store_permission');

    //Upload
    Route::get('/user_upload', 'UploadController@upload')->name('user_upload');
    Route::get('file-upload', function () {
        return view('default');
    });
    Route::post('/upload_step1/{id}', 'UploadController@step1')->name('upload_step1');
    //Route::post('/thumb/{id}', 'UploadController@thumb')->name('thumb');
    //Route::post('/poster/{id}', 'UploadController@poster')->name('poster');
    Route::get('/upload_store/{id}', 'UploadController@store')->name('upload_store');
    Route::get('/ldap_search', 'UploadController@ldap_search')->name('ldap_search');
    Route::get('/course_search', 'UploadController@course_search')->name('course_search');
    Route::get('/tag_search', 'UploadController@tag_search')->name('tag_search');

    //Download
    Route::post('/download/{video}', 'ManualDownloadController@step1')->name('download');
    Route::get('/download_step2/{video}', 'ManualDownloadController@step2');
    Route::get('/download_presentation/{video}', 'ManualDownloadController@download');
    Route::get('/download_step3/{video}', 'ManualDownloadController@step3')->name('download_step3');
    Route::post('/download_store/{video}', 'ManualDownloadController@store')->name('download_store');
    Route::post('/gen_thumb_download/{id}', 'ManualDownloadController@gen_thumb_download')->name('gen_thumb_download');
    Route::post('/gen_poster_download/{id}', 'ManualDownloadController@gen_poster_download')->name('gen_poster_download');
    Route::get('/download_step4/{id}', 'ManualDownloadController@step4')->name('download_step4');
    Route::get('/download_send/{id}', 'ManualDownloadController@send');

    //Admin
    Route::prefix('admin/')->group(function () {
        Route::get('/', 'AdminController@admin')->name('admin');
        Route::post('/emulate', 'AdminController@emulateUser')->name('emulateUser');
        Route::get('/flush_admin', 'AdminController@flush')->name('admin_flush');
        Route::get('/uploads', 'AdminController@uploads')->name('uploads');
        Route::get('/downloads', 'AdminController@downloads')->name('downloads');
        Route::get('/mediasite_admin', 'AdminController@mediasite')->name('mediasite_admin');
        Route::get('/videopermissions', 'AdminController@videopermission')->name('videopermission');
        Route::prefix('logs')->name('log-viewer::logs.')->group(function () {
            Route::get('/', 'LogViewerController@listLogs')->name('list');
            Route::delete('/delete', 'LogViewerController@delete')->name('delete');
            Route::get('/{date}', 'LogViewerController@show')->name('show');
            Route::get('/{date}/download', 'LogViewerController@download')->name('download');
            Route::get('/{date}/{level}', 'LogViewerController@showByLevel')->name('filter');
            Route::get('/{date}/{level}/search', 'LogViewerController@search')->name('search');
        });
    });
    Route::get('/start', 'SystemController@start')->name('playboot');
    Route::get('/manual_admin_erase/{id}', 'AdminController@admin_erase')->name('manual_admin_erase');
    Route::get('/manual_admin_notify/{id}', 'AdminController@admin_upload_notify_fail')->name('manual_admin_notify_fail');
    Route::get('/manual_admin_unregister/{id}', 'AdminController@admin_unregister')->name('manual_admin_unregister');
    Route::get('/add_permission', 'AdminController@addPermission')->name('add_permission');
    Route::get('/modify_permission/{permission}', 'AdminController@modifyPermission')->name('modify_permission');
    Route::get('/delete_permission/{permission}', 'AdminController@deletePermission')->name('delete_permission');
    Route::post('/store_new_permission', 'AdminController@adminNewPermission')->name('store_new_permission');
    Route::get('/admin_download_notify_resend/{id}', 'AdminController@admin_download_notify_resend')->name('admin_download_notify_resend');

    //Mediasite
    Route::get('/mediasite', 'PlayController@mediasite')->name('mediasite');
    Route::get('/mediasiteFetch', 'PlayController@mediasiteFetch')->name('mediasiteFetch');
    Route::post('/mediasiteCourseDownload', 'PlayController@mediasiteCourseDownload')->name('mediasiteCourseDownload');
    Route::post('/mediasiteRecordingDownload', 'PlayController@mediasiteRecordingDownload')->name('mediasiteRecordingDownload');
    Route::post('/mediasiteUserDownload', 'PlayController@mediasiteUserDownload')->name('mediasiteUserDownload');
    Route::post('/mediasiteOtherDownload', 'PlayController@mediasiteOtherDownload')->name('mediasiteOtherDownload');
    Route::post('/mediasite/prefetchCourse', 'PlayController@prefetchCourseDownload')->name('mediasite.prefetchCourseDownload');
    /*
    Route::get('/upload', 'PlayController@upload');
    Route::post('/store', 'PlayController@store')->name('store');
   */

    //Testing routes --> to be removed before production
    Route::get('/test', 'TestController@test')->name('test');
    Route::get('/roles', 'TestController@roles')->name('roles');
    Route::get('/upload_destroy/{id}', 'AdminController@destroy_upload')->name('upload_delete');
    Route::get('/download_destroy/{id}', 'AdminController@destroy_download')->name('download_delete');
    Route::get('/dev_destroy/{id}', 'AdminController@dev_destroy');
    Route::get('/php', 'TestController@php')->name('php');
    Route::get('/server', 'TestController@server')->name('server');
    Route::get('/reload', 'ReloadPlayStoreController@index')->name('reload'); //Reload all presentations from play store
    Route::get('/del/{video}', 'TestController@del')->name('del'); //Send delete notification to play-store

    //-->
});
Route::any('{query}',
    function() { return redirect('/'); })
    ->where('query', '.*');
