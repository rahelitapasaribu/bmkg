<?php

namespace App\Http\Controllers;

use App\Models\Staf;

class StafController extends Controller
{
    // Tampilkan semua data staf
    public function index()
    {
        $staf = Staf::with('satker')->get();
        return view('staf.index', compact('staf'));
    }

    // Tampilkan detail staf berdasarkan id
    public function show($id)
    {
        $staf = Staf::with('satker')->findOrFail($id);
        return view('map', compact('staf'));
    }
}
