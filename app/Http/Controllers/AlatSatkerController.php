<?php

namespace App\Http\Controllers;

use App\Models\AlatSatker;
use Illuminate\Http\Request;

class AlatSatkerController extends Controller
{
    // Menampilkan data alat satker + relasi jenis alat & kondisi
    public function index()
    {
        $alatSatker = AlatSatker::with(['jenisAlat', 'kondisi', 'satker.provinsi'])->get();

        return view('map', compact('alatSatker'));
    }
}
