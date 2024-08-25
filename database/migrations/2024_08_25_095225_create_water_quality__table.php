<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterQualityTable extends Migration
{
    public function up()
    {
        Schema::create('water_quality', function (Blueprint $table) {
            $table->id();
            $table->float('ph_air'); // Menyimpan pH air
            $table->float('kekeruhan_air'); // Menyimpan kekeruhan air
            $table->timestamps(); // Waktu pembuatan dan pembaruan data
        });
    }

    public function down()
    {
        Schema::dropIfExists('water_quality');
    }
}

