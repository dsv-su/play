<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;
    protected $fillable = ['catch', 'jobid', 'pk_id'];

    protected $casts = [
        'catch' =>  'array'
    ];
}
