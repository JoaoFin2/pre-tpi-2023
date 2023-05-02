<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weather';
    
    public $timestamps = false;

    protected $fillable = [
        'date', 'temperature', 'precipitation'
    ];
}
