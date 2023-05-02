<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeteoSuisse extends Model
{
    protected $fillable = [
        'date', 'temperature', 'precipitation', 'date'
    ];
}
