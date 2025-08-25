<?php

namespace App\Http\Controllers;

use App\Models\AlatSatker;
use Illuminate\Http\Request;

class AlatSatkerController extends Controller
{
    // Menampilkan data alat + jumlah
    public function index()
    {
        // ambil data alat satker + relasi alat (nama) + jumlah
        $alatSatker = AlatSatker::with('alat')->get();

        return view('map', compact('alatSatker'));
    }
}
