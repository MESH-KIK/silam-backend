<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/silam-app', function () {
    return view('page.beranda');
});

Route::get('/beranda', function () {
    return view('page.beranda');
});

Route::get('/outlet', function () {
    return view('page.outlet');
});

Route::get('/status', function () {
    return view('page.status');
});

// Login (modal)
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => redirect('/beranda')->with('buka_login', true))->name('login');
    Route::post('/loginaksi', [LoginController::class, 'loginaksi'])->name('loginaksi');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Administrator saja: master layanan & user
    Route::middleware('role:administrator')->group(function () {
        Route::resource('layanan', LayananController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('user', UserController::class)->only(['index', 'store', 'update', 'destroy']);
    });

    // Administrator + Kasir: pelanggan, buat pesanan, pembayaran
    Route::middleware('role:administrator,kasir')->group(function () {
        Route::resource('pelanggan', PelangganController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
        Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
        Route::patch('/pesanan/{pesanan}/bayar', [PesananController::class, 'bayar'])->name('pesanan.bayar');
    });

    // Semua role: lihat pesanan & update status kerja
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.status');
});
