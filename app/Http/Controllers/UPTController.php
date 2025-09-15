<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UPTController extends Controller
{
    public function index()
    {
        $upts = DB::table('satker')
            ->join('provinsi', 'satker.id_provinsi', '=', 'provinsi.id')
            ->select(
                'satker.id',
                'satker.nama_satker',
                'satker.latitude',
                'satker.longitude',
                'provinsi.nama_provinsi'
            )
            ->orderBy('provinsi.nama_provinsi', 'asc') 
            ->orderBy('satker.nama_satker', 'asc')
            ->get();

        return view('upt', compact('upts'));
    }
}
