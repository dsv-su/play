<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    //UUID
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'video_id', 'handlers', 'progress'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
