<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UPTController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OlaController;
use App\Http\Controllers\Admin\SlaController;
// use App\Http\Controllers\Admin\AdminUptController;
// use App\Http\Controllers\Admin\PegawaiController;

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

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('admin.home_admin');
    })->name('home');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ola', [OlaController::class, 'index'])->name('ola.index');
    Route::get('/sla', [SlaController::class, 'index'])->name('sla.index');

});