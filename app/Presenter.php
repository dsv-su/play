<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presenter extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function video_presenter()
    {
        return $this->hasMany(VideoPresenter::class);
    }
}
