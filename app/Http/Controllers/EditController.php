<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Presentation;
use App\Video;
use App\VideoPresenter;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function show(Video $video)
    {
        //dd($video);
        $permissions = Permission::all();
        //$presenters = $video->presenters();

        return view('manage.edit', compact('video', 'permissions'));
    }
}
