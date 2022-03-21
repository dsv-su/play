<?php

namespace App\Http\Controllers;

use App\Course;
use App\Services\Daisy\DaisyIntegration;
use App\Services\Notify\PlayStoreNotify;
use App\Video;

class TestController extends Controller
{
    public function test()
    {
    }

    public function roles()
    {
        //Check role status
        dd('play_auth: '.app()->make('play_auth'), 'play_role: '. app()->make('play_role'), 'play_user: '.app()->make('play_user'),'play_username: '.app()->make('play_username'), 'play_email: '.app()->make('play_email'));

    }

}
