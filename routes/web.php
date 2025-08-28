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
// tampilkan form login (misalnya di resources/views/auth/login.blade.php)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

// proses login
Route::post('/login', [AuthController::class, 'login'])->name('login');

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// Admin Routes (hanya setelah login)
// ==========================
Route::get('/admin/home', function () {
    return view('admin.home_admin');
})->name('admin.home')->middleware('auth');
