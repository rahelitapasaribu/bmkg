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
use App\Http\Controllers\Admin\SiteController;

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

    // Sites
    Route::get('sites', [SiteController::class, 'index'])->name('sites.index');
    Route::post('sites/jenis', [SiteController::class, 'storeJenis'])->name('sites.storeJenis');
    Route::post('sites', [SiteController::class, 'storeSite'])->name('sites.store');
    Route::put('sites/{id}', [SiteController::class, 'updateSite'])->name('sites.update');

    Route::post('sites/store-alat', [SiteController::class, 'storeAlat'])->name('sites.store-alat');
    Route::put('sites/update-alat/{id}', [SiteController::class, 'updateAlat'])->name('sites.updateAlat');
    Route::delete('sites/destroy-alat/{id}', [SiteController::class, 'destroyAlat'])->name('sites.destroy-alat');
    Route::put('sites/update-alat/{jenis}/{satker}', [SiteController::class, 'updateAlatGroup'])->name('admin.sites.update-alat-group');
});
