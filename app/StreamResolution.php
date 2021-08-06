<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamResolution extends Model
{
    use HasFactory;

    protected $fillable = ['stream_id', 'resolution', 'filename'];

    public function stream() {
        return $this->belongsTo(Stream::class);
    }
}
