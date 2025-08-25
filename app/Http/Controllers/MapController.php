<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satker;
use App\Models\provinsi;

class MapController extends Controller
{
    public function index()
{
    // Ambil semua satker beserta nama provinsinya (relasi)
    $satkers = Satker::with('provinsi')->get();

    // Ambil semua provinsi untuk dropdown filter
    $provinsi = Provinsi::all();

    // kirim ke view
    return view('map', compact('satkers', 'provinsi'));
}
}
