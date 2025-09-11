<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Satker;
use App\Models\SlaOlaNilai;

class DashboardController extends Controller
{
    public function index()
    {
        // Recap semua site dengan relasi Satker dan Jenis Alat
        $recapSites = Site::with(['satker.provinsi', 'jenisAlat'])
            ->orderBy('name')
            ->get()
            ->map(function ($site) {
                return (object) [
                    'id'         => $site->id,
                    'name'       => $site->name,
                    'merk'       => $site->merk,
                    'jenis_alat' => $site->jenisAlat?->nama_jenis,
                    'satker'     => $site->satker?->nama_satker,
                    'provinsi'   => $site->satker?->provinsi?->nama_provinsi,
                ];
            });

        // Recap semua satker dengan provinsinya
        $recapSatkers = Satker::with('provinsi')->get();

        // Recap nilai SLA & OLA (dari tabel sla_ola_nilai)
        $recapSlaOla = SlaOlaNilai::with('kategori')
            ->get()
            ->groupBy(fn($item) => $item->kategori?->nama_kategori)
            ->map(function ($items, $kategori) {
                return [
                    'kategori' => $kategori,
                    'rata2_nilai' => $items->avg('nilai'),
                ];
            });

        return view('admin.home_admin', compact('recapSites', 'recapSatkers', 'recapSlaOla'));
    }
}
