<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CleanBox extends Model
{
    protected $table = 'CleanBox';

    protected $fillable = [
        'region',
        'road',
        'location',
        'latitude',
        'longitude',
        'remarks'
    ];
}
