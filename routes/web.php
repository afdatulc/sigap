<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RumahController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Mitra\SurveiController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dev route for quick testing (Logins as Admin ID 1)
Route::get('/dev/login-admin', function () {
    Auth::loginUsingId(1);
    \App\Models\LogAktivitas::create([
        'user_id' => 1,
        'aktivitas' => 'Login (Dev)',
        'detail' => 'Login sebagai Admin via dev route',
        'ip_address' => request()->ip(),
    ]);
    return redirect('/admin/dashboard');
});


// Dev route for Mitra (Logins as Mitra ID 2)
Route::get('/dev/login-mitra', function () {
    Auth::loginUsingId(2);
    \App\Models\LogAktivitas::create([
        'user_id' => 2,
        'aktivitas' => 'Login (Dev)',
        'detail' => 'Login sebagai Mitra via dev route',
        'ip_address' => request()->ip(),
    ]);
    return redirect('/mitra/survei');
});


Route::post('/logout', function () {
    $user = Auth::user();
    if ($user) {
        \App\Models\LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Logout',
            'detail' => "User {$user->name} keluar dari sistem",
            'ip_address' => request()->ip(),
        ]);
    }
    Auth::logout();
    return redirect('/');
})->name('logout');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('rumah', RumahController::class);
    Route::get('/map', [MapController::class, 'index'])->name('map.index');
    Route::get('/activity-log', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log.index');

});

Route::prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/survei', [SurveiController::class, 'index'])->name('survei.index');
    Route::get('/survei/rumah/create', [SurveiController::class, 'createRumah'])->name('survei.rumah.create');
    Route::post('/survei/rumah', [SurveiController::class, 'storeRumah'])->name('survei.rumah.store');
});
