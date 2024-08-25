<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterQuality extends Model
{
    protected $table = 'water_quality';
    protected $fillable = ['ph_air', 'kekeruhan_air'];
}   

