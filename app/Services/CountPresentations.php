<?php

namespace App\Services;

use App\Video;
use Illuminate\Database\Eloquent\Model;

class CountPresentations extends Model
{
    public function latest()
    {
        return Video::count();
    }
}
