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
        // Recap semua site dengan relasi ke Jenis Alat dan Satker melalui SiteSatker
        $recapSites = Site::with(['jenisAlat', 'siteSatkers.satker.provinsi', 'slaOlaNilai'])
            ->join('jenis_alat', 'sites.id_jenis_alat', '=', 'jenis_alat.id')
            ->orderBy('jenis_alat.nama_jenis')   // urutkan berdasarkan jenis alat
            ->orderBy('sites.nama_site')         // lalu urutkan berdasarkan nama site
            ->select('sites.*')                  // penting: supaya kolom hanya dari tabel sites
            ->get()
            ->map(function ($site) {
                return (object) [
                    'id'         => $site->id,
                    'name'       => $site->nama_site,
                    'merk'       => $site->merk,
                    'jenis_alat' => $site->jenisAlat?->nama_jenis,
                    'satker'     => $site->siteSatkers->first()?->satker?->nama_satker,
                    'provinsi'   => $site->siteSatkers->first()?->satker?->provinsi?->nama_provinsi,
                    'avg_sla'    => $site->slaOlaNilai
                        ->where('tipe_id', 1)
                        ->avg('persentase'),
                    'avg_ola'    => $site->slaOlaNilai
                        ->where('tipe_id', 2)
                        ->avg('persentase'),
                ];
            });

        // Recap semua satker dengan provinsinya
        $recapSatkers = Satker::with('provinsi')->get();

        // Recap nilai SLA & OLA
        $recapSlaOla = SlaOlaNilai::with('kategori')
            ->get()
            ->groupBy(fn($item) => $item->kategori?->nama_tipe)
            ->map(function ($items, $tipe) {
                return [
                    'kategori' => $tipe,
                    'rata2_nilai' => $items->avg('persentase'),
                ];
            });

        // Hitung total site
        $totalSites = $recapSites->count();

        // Hitung rata-rata performance keseluruhan (gabungan SLA & OLA)
        $avgPerformance = $recapSites->map(function ($site) {
            return (($site->avg_sla ?? 0) + ($site->avg_ola ?? 0)) / 2;
        })->avg();


        return view('admin.home_admin', compact('recapSites', 'recapSatkers', 'recapSlaOla', 'totalSites', 'avgPerformance'));
    }
}
