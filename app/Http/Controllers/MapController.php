<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satker;
use App\Models\Provinsi;

class MapController extends Controller
{
    public function index()
    {
        $satkers = Satker::with([
            'provinsi',
            'alatSatker.jenisAlat',
            'alatSatker.kondisi',
            'siteSatkers.site',
            'siteSatkers.kondisi',
            'staf', 
        ])->get();

        $provinsi = Provinsi::all();

        return view('map', compact('satkers', 'provinsi'));
    }
}
