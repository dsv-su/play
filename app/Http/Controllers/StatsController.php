<?php

namespace App\Http\Controllers;

use App\Video;
use App\VideoStat;

class StatsController extends Controller
{
    public function __construct()
    {
        //For session history
        $this->middleware('redirect-links');
    }

    public function index(Video $video)
    {
        $videoid = $video->id;
        $stats = VideoStat::where('video_id', $video->id)->first();
        return view('stats.presentation', compact('videoid', 'stats'));
    }
}
