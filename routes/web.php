<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;

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