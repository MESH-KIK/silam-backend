<?php

use App\Http\Controllers\LayananController;
use App\Http\Controllers\LoginController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Login (modal)
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => redirect('/beranda')->with('buka_login', true))->name('login');
    Route::post('/loginaksi', [LoginController::class, 'loginaksi'])->name('loginaksi');
});

Route::middleware('role:administrator')->group(function () {
        Route::resource('layanan', LayananController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('user', UserController::class)->only(['index', 'store', 'update', 'destroy']);
    });
