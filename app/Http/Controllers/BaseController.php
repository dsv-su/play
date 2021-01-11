<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function __construct()
    {
        // If the environment is local
        if (app()->environment('local')) {
            $user = 'För Efternamn';
        } else {
            $user = $_SERVER['displayName'];
        }

        View::share('play_user', $user);
    }
}
