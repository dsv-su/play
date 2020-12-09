<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoPresenter extends Model
{
    use HasFactory;
    protected $fillable = ['video_id', 'presenter_id'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function presenter()
    {
        return $this->belongsTo(Presenter::class);
    }
}
