<?php

namespace App\Http\Controllers;

use App\Services\ReLoadPlayStore;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReloadPlayStoreController extends Controller
{
   public function index()
   {
       $load = new ReLoadPlayStore();
       $presentations = $load->reloadlist();

       foreach($presentations as $presentation) {
           $video = $load->reloadPresentation($presentation);
           //store
           $load->reloadstore(new Request($video));
       }
       return redirect()->back()->with(['message' => 'All presentations have been reloaded successfully!', 'alert' => 'alert-success']);
   }
}
