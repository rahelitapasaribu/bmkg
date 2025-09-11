<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satker;
use App\Models\Provinsi;

class MapController extends Controller
{
    public function index()
    {
        // Ambil semua satker beserta provinsi, alat (jenis + kondisi), dan staf
        $satkers = Satker::with(['provinsi', 'alatSatker.jenisAlat', 'alatSatker.kondisi', 'staf'])->get();

        // Ambil semua provinsi untuk dropdown filter
        $provinsi = Provinsi::all();

        return view('map', compact('satkers', 'provinsi'));
    }
}
