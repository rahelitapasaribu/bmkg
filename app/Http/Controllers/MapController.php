<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satker; // jangan lupa import model

class MapController extends Controller
{
    public function index()
    {
        // Ambil semua satker beserta nama provinsinya (relasi)
        $satkers = Satker::with('provinsi')->get();

        // kirim ke view
        return view('map', compact('satkers'));
    }
}
