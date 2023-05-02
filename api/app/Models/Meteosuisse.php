<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeteoSuisse extends Model
{
    protected $table = 'meteo_suisse';

    public $timestamps = false;

    protected $fillable = [
        'wind', 'gust', 'temperature', 'precipitation', 'date'
    ];
}
