<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeteoSuisse extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'wind', 'gust', 'temperature', 'precipitation', 'date'
    ];

}
