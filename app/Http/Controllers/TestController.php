<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function test()
    {
        //return view('modals.disclamer');
        phpinfo();
    }

    public function server()
    {
        dd($_SERVER);
    }

    public function roles()
    {
        //Check role status
        dd('play_auth: '.app()->make('play_auth'),
            'play_role: '. app()->make('play_role'),
            'play_user: '.app()->make('play_user'),
            'play_username: '.app()->make('play_username'),
            'play_email: '.app()->make('play_email'));

    }

}
