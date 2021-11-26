<?php

namespace App\Http\Controllers;

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
        dd('play_auth: '.app()->make('play_auth'), 'play_role: '. app()->make('play_role'), 'play_user: '.app()->make('play_user'),'play_username: '.app()->make('play_username'));

    }

    public function del(Video $video)
    {
        //Send Delete notification
        $notify = new PlayStoreNotify($video);
        return $message = $notify->sendDelete();

        return back()->with(['message' => 'Presentationen har raderats']);
    }

    public function php()
    {
        return phpinfo();
    }

    public function server()
    {
        dd($_SERVER);
    }


}
