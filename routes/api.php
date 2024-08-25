<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WaterLevelController;

Route::get('/water-level', [WaterLevelController::class, 'getWaterLevel']);
Route::post('/water-level', [WaterLevelController::class, 'store']);
Route::post('/water-quality', [WaterLevelController::class, 'storeWaterQuality']);
Route::get('/latest-data', [WaterLevelController::class, 'getLatestData']);
// Route::post('/store-data', [WaterLevelController::class, 'store']);
Route::get('water_quality/api', [WaterLevelController::class, 'apiGet']);
Route::post('water_quality/api', [WaterLevelController::class, 'apiPost']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
