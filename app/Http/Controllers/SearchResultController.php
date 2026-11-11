<?php

namespace App\Http\Controllers;

class SearchResultController extends Controller
{
    public function tags($tag)
    {
        return view('search.navigator', ['tag' => $tag]);
    }

    public function courses($designation)
    {
        return view('search.navigator', ['designation' => $designation]);
    }

    public function presenters($presenter)
    {
        return view('search.navigator', ['presenter_search' => $presenter]);
    }
}
