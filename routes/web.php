<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UPTController;

Route::get('/', function () {
    return view('home');
});

Route::get('/map', function () {
    return view('map');
});

Route::get('/data-upt', function () {
    return view('upt');
});

Route::get('/map', [MapController::class, 'index'])->name('map');

Route::get('/home', function () {
    return view('home');
})->name('home');


Route::get('/data-upt', [UPTController::class, 'index'])->name('upt.index');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/map', [MapController::class, 'index'])->name('map');
Route::get('/upt', [UPTController::class, 'index'])->name('upt.index');
