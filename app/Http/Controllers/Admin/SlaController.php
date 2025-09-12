<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SlaOlaNilai;
use App\Models\TipeKategori;
use App\Models\Site;

class SlaController extends Controller
{

    public function index(Request $request)
    {

        // Mapping tab ke nama kategori di database
        $tabMapping = [
            'AWOS'      => 'AWOS',
            'RADAR'     => 'RADAR',
            'AWS DIGI'  => 'AWS DIGI',
            'AWS POSMET' => 'AWS Posmet & Rekayasa',
            'AWS MARITIM' => 'AWS MARITIM',
            'RASON'     => 'AWS Rasond',
            'AAWS'      => 'AAWS',
            'AWS'       => 'AWS',
            'ARG'       => 'ARG',
            'InaTEWS'   => 'InaTEWS',
        ];

        $tab = $request->get('tab', 'rekapan');
        $year = (int) $request->get('year', date('Y'));

        // Ambil tipe SLA
        $kategori = TipeKategori::where('nama_tipe', 'SLA')->first();

        // Ambil daftar site sesuai tab
        $sitesQuery = Site::with(['jenisAlat', 'siteSatkers.satker'])
            ->orderBy('nama_site');

        if ($tab !== 'rekapan') {
            $namaDb = $tabMapping[$tab] ?? $tab; // fallback kalau ga ada
            $sitesQuery->whereHas('jenisAlat', function ($q) use ($namaDb) {
                $q->where('nama_jenis', $namaDb);
            });
        }

        $sites = $sitesQuery->get();

        // Ambil data SLA sesuai tahun
        $performances = $kategori
            ? SlaOlaNilai::where('tipe_id', $kategori->id)
            ->where('tahun', $year)
            ->get()
            : collect();

        // Ambil daftar tahun yang tersedia
        $years = SlaOlaNilai::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($years)) {
            $current = (int) date('Y');
            $years = range($current - 5, $current + 1);
            rsort($years);
        }

        if (!$request->has('tab') || !$request->has('year')) {
            return redirect()->route('admin.sla.index', [
                'tab' => $tab,
                'year' => $year,
            ]);
        }

        // --- Hitung Rekapan --- //
        $month = (int) $request->get('month', date('n'));
        $month = null;
        if ($tab === 'rekapan') {
            $month = (int) $request->get('month', date('n'));
        }

        // mapping alat ke kategori
        $kelompok = [
            'Geofisika' => ['InaTEWS'],
            'Meteorologi' => ['AWOS', 'RADAR', 'AWS DIGI', 'AWS Posmet & Rekayasa', 'AWS MARITIM', 'AWS Rasond'],
            'Klimatologi' => ['AAWS', 'AWS', 'ARG'],
        ];

        $rekapan = [];
        if ($tab === 'rekapan') {
            foreach ($kelompok as $kategori => $alatList) {
                $query = SlaOlaNilai::whereHas('site.jenisAlat', function ($q) use ($alatList) {
                    $q->whereIn('nama_jenis', $alatList);
                })
                    ->where('tahun', $year);

                if ($month) {
                    $query->where('bulan', $month);
                }

                $rekapan[$kategori] = $query->avg('persentase') ?? 0;
            }
        }

        $rekapanDetail = [];

        foreach ($kelompok as $kategori => $alatList) {
            foreach ($alatList as $alat) {
                $query = SlaOlaNilai::whereHas('site.jenisAlat', function ($q) use ($alat) {
                    $q->where('nama_jenis', $alat);
                })
                    ->where('tahun', $year)
                    ->where('bulan', $month);

                $jumlah = $query->count();
                $persentase = $query->avg('persentase') ?? 0;

                $rekapanDetail[$kategori][] = [
                    'nama' => $alat,
                    'jumlah' => $jumlah,
                    'persentase' => $persentase,
                ];
            }
        }

        return view('admin.sla', [
            'tab'            => $tab,
            'year'           => $year,
            'month'          => $month,
            'sites'          => $sites,
            'performances'   => $performances,
            'availableYears' => $years,
            'rekapan'        => $rekapan,
            'rekapanDetail'  => $rekapanDetail,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id'    => 'required|exists:sites,id',
            'year'       => 'required|integer',
            'month'      => 'required|integer|min:1|max:12',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $kategori = TipeKategori::where('nama_tipe', 'SLA')->firstOrFail();
        $site = Site::findOrFail($data['site_id']);

        SlaOlaNilai::create([
            'site_id'       => $site->id,
            'jenis_alat_id' => $site->id_jenis_alat,
            'tipe_id'       => $kategori->id,
            'tahun'         => $data['year'],
            'bulan'         => $data['month'],
            'persentase'    => $data['percentage'],
        ]);

        return redirect()->route('admin.sla.index', [
            'tab'  => $request->get('tab', 'rekapan'),
            'year' => $data['year'],
        ])->with('success', 'Data SLA berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $nilai = SlaOlaNilai::findOrFail($id);
        $nilai->update([
            'persentase' => $data['percentage'],
        ]);

        return redirect()->back()->with('success', 'Data SLA berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = SlaOlaNilai::findOrFail($id);
        $nilai->delete();

        return redirect()->back()->with('success', 'Data SLA berhasil dihapus.');
    }
}
