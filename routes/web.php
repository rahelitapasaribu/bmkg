<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UPTController;
use App\Http\Controllers\AuthController;

// ==========================
// Public Routes
// ==========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/data-upt', [UPTController::class, 'index'])->name('upt.index');

// ==========================
// Auth Routes
// ==========================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// Admin Routes (auth only)
// ==========================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminUptController;
use App\Http\Controllers\Admin\PegawaiController;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('admin.home_admin');
    })->name('home');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // halaman Data (sementara)
    Route::get('/data', function () {
        return view('admin.data.index');
    })->name('data.index');

    // CRUD UPT
    Route::resource('upt', AdminUptController::class);

    // CRUD Pegawai
    Route::resource('pegawai', PegawaiController::class);
});
