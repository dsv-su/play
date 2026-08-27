<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\MultiplayerController;
use App\Http\Controllers\PresentationOrderController;
use App\Http\Controllers\TestController;
use App\Services\AuthHandler;
use Illuminate\Support\Facades\Route;

if (class_exists(AuthHandler::class))
    $login = app()->make('SystemService')->authorize()->global->login_route;

// SU idp Endpoints
Route::get('/sulogin', [\App\Http\Controllers\SystemController::class, 'SUlogin'])->name('sulogin');
Route::get($login, [\App\Http\Controllers\SystemController::class, 'SUidpReturn'])->name('login');


// Multiplayer — public endpoints guarded by permissions
Route::controller(MultiplayerController::class)->group(function () {
    // video-permission applies to both multiplayer pages
    Route::middleware('video-permission')->group(function () {
        Route::get('/multiplayer',     'multiplayer_ce')->name('multiplayer.index');
    });

    // presentation-permission only for presentations
    Route::get('/presentation/{presentation}', 'presentation')
        ->name('presentation.show')
        ->middleware('presentation-permission');
});

//Protected routes
Route::middleware(['entitlements', 'playauth','web'])->group(function () {
    Route::middleware(['redirect-links'])
        ->get('/', [\App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    Route::middleware(['redirect-links'])
        ->get('/pending', [\App\Http\Controllers\HomeController::class, 'pending'])
        ->name('pending.presentations');

    Route::get('/faq', FaqController::class)->name('faq');
    // Locale
    Route::get('/locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

    //Profile
    Route::get('/presentation-order', [PresentationOrderController::class, 'show'])
        ->name('presentation-order.show');
    Route::post('/presentation-order', [PresentationOrderController::class, 'store'])
        ->name('presentation-order.store');

    // Test
    Route::controller(TestController::class)->group(function () {
        Route::get('/server', 'server')->name('server');
        Route::get('/daisy', 'health')->name('daisy.health');
    });

    //My
    Route::middleware(['redirect-links'])->get('/user/all', \App\Livewire\My\UserPresentations::class)->name('my.presentations');
    //Route::get('/user/all', \App\Livewire\My\MyPresentations::class)->name('my.presentations');

    //Study
    Route::middleware(['redirect-links'])->get('/study/all', \App\Livewire\Study\StudyPresentations::class)->name('study.presentations');
    Route::middleware(['redirect-links'])->get('/nextilearn/all', \App\Livewire\Nextilearn\NextIlearnPresentations::class)->name('nextilearn.presentations');
    Route::get('/channels/manage', \App\Livewire\Channel\ManageChannels::class)->middleware('can:manage-content')->name('channels.manage');
    Route::middleware(['redirect-links'])->get('/channels/{channel}', \App\Livewire\Channel\ChannelPresentations::class)->name('channels.show');
    //Edit
    Route::controller(\App\Http\Controllers\EditController::class)->group(function () {
        Route::get('/edit/{video}', 'show')->name('presentation.edit');
        Route::post('/edit/{video}/stream/upload', 'streamUpload')->name('presentation.stream-upload');
        Route::post('/edit/{video}', 'edit')->name('presentation.save');
        Route::delete('/delete/{video}', 'destroy')->name('presentation.destroy');
        Route::post('/bulkedit', 'bulkEditShow')->name('bulk.edit');
        Route::post('/bulksave', 'bulkEditSave')->name('bulk.save');
    });
    //Download
    Route::controller(\App\Http\Controllers\DownloadController::class)->group(function () {
        Route::get('/download/{video}', 'download')->name('presentation.download');
        Route::get('/download_zip/{video}', 'browserDownloadZip')->name('zip.download');
        Route::get('/videos/{video}/download/status','status')->name('presentation.download.status');
    });
    //Upload
    Route::controller(\App\Http\Controllers\UploadController::class)->group(function () {
        Route::get('/upload',  'create')->name('presentation.upload');
        Route::post('/upload_step1/{presentation}', 'step1')->name('presentation.upload_step1');
        Route::get('/upload_store/{id}', 'store')->name('presentation.upload-store');
        Route::post('thumb/upload', 'thumbupload')->name('presentation.thumb-upload');
        Route::post('thumb/delete', 'thumbdelete')->name('presentation.thumb-delete');
        Route::post('chunk/upload', 'chunkupload')->name('file-upload');
        Route::post('chunk/delete', 'chunkdelete')->name('file-delete');
    });

    // Multiplayer
    Route::controller(\App\Http\Controllers\MultiplayerController::class)->group(function () {
        Route::get('/player/{video}', 'player')->name('player.show');
        Route::get('/course/{course}/play', 'playCourse')->name('course.play');
        Route::get('/playlist/{playlist}', 'playlist')->name('playlist.show');
    });

    // Search Results
    Route::controller(App\Http\Controllers\SearchResultController::class)->group(function () {
        Route::get('/tag/{tag}', 'tags')->name('tags.show');
        Route::get('/designation/{designation}', 'courses')->name('courses.show');
        Route::get('/presenter/{username}', 'presenters')->name('presenters.show');
    });


    //Admin
    Route::prefix('admin')->middleware(['play-admin'])->group(function () {
        Route::get('/settings', \App\Livewire\Admin\AdminSettings::class)->name('admin.settings');
        Route::get('/cattura', [\App\Http\Controllers\AdminController::class, 'recorders'])->name('admin.recorder');
    });
    // Emulating users
    Route::post('/admin/emulate', [\App\Http\Controllers\AdminController::class, 'emulateUser'])
        ->name('admin.emulate');
    //Route::middleware(['play-admin'])->get('/cattura', \App\Livewire\Admin\CatturaRecorders::class)->name('admin.recorders');
    Route::get('/cattura', \App\Livewire\Admin\CatturaRecorders::class)->name('admin.recorders');
    Route::get('/clear-links', function () {
        session()->forget('links');
        return redirect('/')->with('status', 'Session links cleared!');
    });
}); //end protected routes
