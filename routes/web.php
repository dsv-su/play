<?php

use App\Services\AuthHandler;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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
Route::middleware(['entitlements', 'playauth', 'web'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    //Language
    Route::get('lang/{lang}', 'LocalizationController@index')->name('language');

    //View
    Route::get('/semester/{semester}', 'SearchController@viewBySemester')->name('semester.presentations');
    Route::post('/semester/{semester}', 'SearchController@viewBySemester')->name('semester.filter');
    Route::get('/designation/{designation}', 'SearchController@viewByDesignation')->name('designation.presentations');
    Route::post('/designation/{designation}', 'SearchController@viewByDesignation')->name('designation.filter');
    Route::get('/category/{category}', 'SearchController@viewByCategory')->name('category');
    Route::get('/student/{username}', 'SearchController@viewByStudent')->name('student');
    Route::get('/course/{course}', 'SearchController@viewByCourse')->name('course');
    Route::get('/tag/{tag}', 'SearchController@viewByTag')->name('tag.presentations');
    Route::post('/tag/{tag}', 'SearchController@viewByTag')->name('tag.filter');
    Route::get('/presenter/{presenter}', 'SearchController@viewByPresenter')->name('presenter.presentations');
    Route::post('/presenter/{presenter}', 'SearchController@viewByPresenter')->name('presenter.filter');
    Route::get('/queue', 'PlayController@conversionQueue')->name('conversion.queue');

    // Search and autocomplete
    Route::get('/search/{q}', 'SearchController@search')->name('search');
    Route::post('/search/{q}', 'SearchController@search')->name('filter_search');
    Route::get('/find', 'SearchController@find')->name('find');
    Route::get('/findtag', 'SearchController@findTag')->name('tag.find');
    Route::get('/findcourse', 'SearchController@findCourse')->name('course.find');
    Route::get('/findperson', 'SearchController@findPerson')->name('person.find');

    //Multiplayer
    Route::get('/player/{video}', 'MultiplayerController@player')->name('player');
    Route::get('/course/{course}/play', 'MultiplayerController@playCourse')->name('playCourse');
    Route::get('/playlist/{id}', 'MultiplayerController@playlist');

    Route::middleware('redirect-links')->group(function () {
        //Manage courses
        Route::get('/manage_n', function () {
            return view('manage.manage_new');
        })->name('manage_courses');
        //Manage presentations
        Route::get('/manage_presentations', function () {
            return view('manage.manage_presentations');
        })->name('manage_presentations');
    });

    //Manage
    Route::get('/user_manage', 'SearchController@search')->name('user_manage');
    Route::post('/filter_manage', 'SearchController@search')->name('filter_manage');
    //Route::get('/manage/courses', 'ManageCourseSettingsController@index')->name('manage_course');
    Route::get('/course/{courseid}/edit', 'ManageCourseSettingsController@edit')->name('course_edit');
    Route::post('/course/{courseid}/store', 'ManageCourseSettingsController@store')->name('course_edit_store');
    Route::get('/edit/bulk/', 'EditController@bulkEditShow')->name('edit.bulk.show');
    Route::post('/edit/bulk/', 'EditController@bulkEditStore')->name('edit.bulk.store');
    Route::get('/edit/{video}', 'EditController@show')->name('presentation_edit');
    Route::post('/edit/{video}', 'EditController@edit')->name('editpresentation');
    Route::post('/delete/{id}', 'ManagePresentationController@delete')->name('presentation.delete');
    Route::post('/manage/deleteAjax', 'PlayController@deleteVideoAjax')->name('manage.deleteVideo');
    Route::post('/manage/editAjax', 'PlayController@editVideoAjax')->name('manage.editVideo');
    Route::get('/my', 'PlayController@myVideos')->name('my.videos');
    Route::post('/my/filter', 'PlayController@myVideosFilter')->name('my.filter');
    Route::get('/edit_permission/{video}', 'ManagePresentationController@SetPermission')->name('edit_permission');
    Route::post('/store_permission/{id}', 'ManagePresentationController@storePermission')->name('store_permission');

    //Upload
    Route::get('/upload', 'UploadController@upload')->name('user_upload');
    Route::get('/upload/pending', 'UploadController@pending_uploads')->name('pending_uploads');
    Route::get('file-upload', function () {
        return view('default');
    });
    Route::post('/upload_step1/{id}', 'UploadController@step1')->name('upload_step1');
    Route::get('/upload_store/{id}', 'UploadController@store')->name('upload_store');
    Route::get('/ldap_search', 'UploadController@ldap_search')->name('ldap_search');
    Route::get('/course_search', 'UploadController@course_search')->name('course_search');
    Route::get('/tag_search', 'UploadController@tag_search')->name('tag_search');

    //Download
    Route::get('/download/{video}', 'ManualDownloadController@start');
    Route::get('/download_zip/{video}', 'ManualDownloadController@browserDownloadZip');
    Route::get('/download_presentation/{video}', 'ManualDownloadController@download');

    //Video format
    Route::post('/updateVideoFormat', 'PlayController@updateVideoFormat')->name('updateVideoFormat');

    //FAQ
    Route::get('/faq', 'FAQController@index')->name('faq');

    //Admin
    Route::prefix('admin/')->group(function () {
        Route::get('/', 'AdminController@admin')->name('admin');
        Route::post('/emulate', 'AdminController@emulateUser')->name('emulateUser');
        Route::get('/flush_admin', 'AdminController@flush')->name('admin_flush');
        Route::get('/uploads', 'AdminController@uploads')->name('uploads');
        Route::get('/downloads', 'AdminController@downloads')->name('downloads');
        Route::get('/mediasite_admin', 'AdminController@mediasite')->name('mediasite_admin');
        Route::get('/videopermissions', 'AdminController@videopermission')->name('videopermission');
        //Backup
        Route::get('/jsonbackup', 'AdminController@backup_json')->name('backup_json');
        Route::get('/reloadjson', 'AdminController@reload_json')->name('reload_json');
        Route::get('/downloadjson', 'AdminController@download_json')->name('download_json');
        Route::get('/dbbackup', 'AdminController@backup_db')->name('backup_db');
        Route::get('/dbreload', 'AdminController@restore_db')->name('restore_db');

        Route::prefix('logs')->name('log-viewer::logs.')->group(function () {
            Route::get('/', 'LogViewerController@listLogs')->name('list');
            Route::delete('/delete', 'LogViewerController@delete')->name('delete');
            Route::get('/{date}', 'LogViewerController@show')->name('show');
            Route::get('/{date}/download', 'LogViewerController@download')->name('download');
            Route::get('/{date}/{level}', 'LogViewerController@showByLevel')->name('filter');
            Route::get('/{date}/{level}/search', 'LogViewerController@search')->name('search');
        });

        Route::get('/upload_destroy/{id}', 'AdminController@destroy_upload')->name('upload_delete');
        Route::get('/download_destroy/{id}', 'AdminController@destroy_download')->name('download_delete');
        Route::get('/dev_destroy/{id}', 'AdminController@dev_destroy');
        Route::get('/reload', 'ReloadPlayStoreController@index')->name('reload'); //Reload all presentations from play store

        //Testing routes
        Route::get('/test', 'TestController@test')->name('test');
        Route::get('/roles', 'TestController@roles')->name('roles');
        Route::get('/server', 'TestController@server')->name('server');

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
    Route::post('/mediasite/prefetchPresentation', 'PlayController@prefetchPresentationDownload')->name('mediasite.prefetchPresentationDownload');

    //Stats
    Route::get('stats/{video}', 'StatsController@index')->name('stats');

});
Route::any('{query}',
    function () {
        return redirect('/');
    })
    ->where('query', '.*');
