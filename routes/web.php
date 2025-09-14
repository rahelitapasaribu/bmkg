<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\UPTController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OlaController;
use App\Http\Controllers\Admin\SlaController;
use App\Http\Controllers\Admin\DataUptController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // OLA
    Route::resource('ola', OlaController::class);

    // SLA
    Route::resource('sla', SlaController::class);

    Route::get('dataupt', [DataUptController::class, 'index'])->name('dataupt.index');
    Route::get('dataupt/{id}/edit', [DataUptController::class, 'edit'])->name('dataupt.edit');
    Route::put('dataupt/{id}', [DataUptController::class, 'update'])->name('dataupt.update');

    Route::post('dataupt/store-alat', [DataUptController::class, 'storeAlat'])->name('dataupt.store-alat');
    Route::delete('dataupt/alat/{id}', [DataUptController::class, 'destroyAlat'])->name('dataupt.destroy-alat');
});

