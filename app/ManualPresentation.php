<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ManualPresentation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = ['title'];
}
