<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tokenHandler extends Model
{
    use HasFactory;
    protected $fillable = ['video_id','token','allow'];
}
