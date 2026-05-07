<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PendudukController;
use App\Http\Controllers\Admin\UsahaController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Mitra\SurveiController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dev route for quick testing (Logins as Admin ID 1)
Route::get('/dev/login-admin', function () {
    Auth::loginUsingId(1);
    return redirect('/admin/dashboard');
});

// Dev route for Mitra (Logins as Mitra ID 2)
Route::get('/dev/login-mitra', function () {
    Auth::loginUsingId(2);
    return redirect('/mitra/survei');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('penduduk', PendudukController::class);
    Route::resource('usaha', UsahaController::class);
    Route::get('/map', [MapController::class, 'index'])->name('map.index');
});

Route::prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/survei', [SurveiController::class, 'index'])->name('survei.index');
    Route::get('/survei/penduduk/create', [SurveiController::class, 'createPenduduk'])->name('survei.penduduk.create');
    Route::post('/survei/penduduk', [SurveiController::class, 'storePenduduk'])->name('survei.penduduk.store');
    Route::get('/survei/usaha/create', [SurveiController::class, 'createUsaha'])->name('survei.usaha.create');
    Route::post('/survei/usaha', [SurveiController::class, 'storeUsaha'])->name('survei.usaha.store');
});
