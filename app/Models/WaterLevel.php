<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterLevel extends Model
{
    use HasFactory;

    protected $table = 'water_levels'; // ensure this matches your table name

    // app/Models/WaterLevel.php
    protected $fillable = [
        'tanggal',
        'waktu',
        'level',
        'ketinggian_air',
        'volume',
        'ph_air',
        'kekeruhan_air',
        'status'
    ];

    public function waterQuality()
{
    return $this->hasOne(WaterQuality::class, 'level_id', 'id');
}


}
