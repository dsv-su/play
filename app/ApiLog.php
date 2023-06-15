<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;
    protected $fillable = ['pk_id'];
/*
    protected $casts = [
        'catch' =>  'array'
    ];
*/
}
