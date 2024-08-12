<?php

use Illuminate\Support\Facades\Auth;
// use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\WaterLevelController;

// Route untuk halaman dashboard
Route::get('/dashboard', [WaterLevelController::class, 'index'])->name('dashboard');

// Route untuk halaman statis lainnya
Route::view('/', 'home')->name('home');
Route::view('/about', 'about')->name('about');

// Route untuk halaman kontak (Layanan) yang dapat diakses oleh guest
Route::get('/contact', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user instanceof App\Models\User) {
            return view('contact');
        }
    }
    // Jika tidak memiliki hak akses, tampilkan error 403
    abort(401, 'Unauthorized');
})->name('contact');

// Route untuk halaman riwayat (History) yang hanya dapat diakses oleh admin
Route::middleware(['auth', RoleMiddleware::class . ':Admin'])->group(function () {
    Route::get('/history', [WaterLevelController::class, 'history'])->name('history');
});

// Route untuk API dan lainnya
Route::get('/api/water-level-data', [WaterLevelController::class, 'getWaterLevelData']);
Route::get('/download-report', [WaterLevelController::class, 'downloadReport'])->name('downloadReport');
Route::get('/get-chart-data', [WaterLevelController::class, 'getChartData'])->name('getChartData');

// Require authentication routes
require __DIR__ . '/auth.php';
