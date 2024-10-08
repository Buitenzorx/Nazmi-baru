<?php

use Illuminate\Support\Facades\Auth;
// use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\WaterLevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LayananController;
Route::get('/users', [UserController::class, 'index'])->name('users');


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
// Untuk API
Route::get('/api/water-quality-data', [WaterLevelController::class, 'getWaterQualityData']);

// Route::get('/api/get-chart-data', [WaterLevelController::class, 'getChartData']);
Route::get('/download-report', [WaterLevelController::class, 'downloadReport'])->name('downloadReport');
Route::get('/api/get-chart-data', [WaterLevelController::class, 'getChartData'])->name('getChartData');
Route::get('/search-by-status', [WaterLevelController::class, 'searchByStatus'])->name('searchByStatus');
Route::post('/services/submit', [LayananController::class, 'submit'])->name('layanan.submit');
Route::get('/log-layanan', [LayananController::class, 'index'])->name('log-layanan');


// Require authentication routes
require __DIR__ . '/auth.php';
