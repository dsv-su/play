<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use App\Video;

class CountPresentations extends model
{
    public function latest()
    {
        return Video::count();
    }
}
