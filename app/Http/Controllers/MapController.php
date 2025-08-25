<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satker;
use App\Models\Provinsi;

class MapController extends Controller
{
    public function index()
    {
        // Ambil semua satker beserta provinsi dan alat yang dimilikinya
        $satkers = Satker::with(['provinsi', 'alatSatker.alat'])->get();

        // Ambil semua provinsi untuk dropdown filter
        $provinsi = Provinsi::all();

        // Kirim ke view
        return view('map', compact('satkers', 'provinsi'));
    }
}
