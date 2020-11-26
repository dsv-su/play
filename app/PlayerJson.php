<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerJson extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'sources', 'subtitles', 'bitrates'];
}
