<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::group(function () {
    Schedule::command('adminhandler:truncate');
    Schedule::command('upload:clear');
    Schedule::command('uploads:clear');
    Schedule::command('download:clear');
    Schedule::command('update:courses');
    Schedule::command('tokens:clear');
})->dailyAt('21:00')->timezone('Europe/Stockholm');
