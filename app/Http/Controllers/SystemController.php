<?php

namespace App\Http\Controllers;

use App\Services\ConfigurationHandler;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function login()
    {
        return redirect('/');
    }

    public function start()
    {
        //Persist system configuration
        $init = new ConfigurationHandler();
        $init->system();
    }
}
