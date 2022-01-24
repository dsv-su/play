<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cattura extends Model
{
    use HasFactory;
    protected $fillable = ['recorder', 'status', 'url'];

}
