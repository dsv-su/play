<?php

namespace App\Http\Controllers;


class MediaLibraryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Get Media Library page
     * @return View
     */
    public function mediaLibrary()
    {
        return view('medialibrary');
    }
}


