<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeteoSuisse extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'date', 'temperature', 'precipitation', 'date'
    ];
}
