<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
   {
       app()->bind('play_faq', function() {
           return true;
       });
       if(!in_array(session('localisation'), ['en', 'swe'])) {
           //Check if there is a localisation change
           //Store in session
           session(['faq_url' => app()->make('play_faq_url')]);
           session()->forget('localisation');
       }

       return view('faq.faq');
   }
}
