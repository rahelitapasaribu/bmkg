<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SlaOlaNilai;
use App\Models\TipeKategori;
use App\Models\Site;

class OlaController extends Controller
{
    public function index(Request $request)
    {
        // Mapping tab ke nama kategori di database
        $tabMapping = [
            'AWOS'        => 'AWOS',
            'RADAR'       => 'RADAR',
            'AWS DIGI'    => 'AWS DIGI',
            'AWS POSMET'  => 'AWS Posmet & Rekayasa',
            'AWS MARITIM' => 'AWS MARITIM',
            'RASON'       => 'AWS Rasond',
            'AAWS'        => 'AAWS',
            'AWS'         => 'AWS',
            'ARG'         => 'ARG',
            'InaTEWS'     => 'InaTEWS',
        ];

        // Default langsung ke AWOS, bukan "OLA"
        $tab = $request->get('tab', 'AWOS');
        $year = (int) $request->get('year', date('Y'));

        // Ambil tipe OLA
        $kategori = TipeKategori::where('nama_tipe', 'OLA')->first();

        // Ambil daftar site sesuai tab
        $sitesQuery = Site::with(['jenisAlat', 'siteSatkers.satker'])
            ->orderBy('nama_site');

        if (isset($tabMapping[$tab])) {
            $namaDb = $tabMapping[$tab];
            $sitesQuery->whereHas('jenisAlat', function ($q) use ($namaDb) {
                $q->where('nama_jenis', $namaDb);
            });
        }

        $sites = $sitesQuery->get();

        // Ambil data OLA sesuai tahun
        $performances = $kategori
            ? SlaOlaNilai::where('tipe_id', $kategori->id)
                ->where('tahun', $year)
                ->get()
            : collect();

        // Ambil daftar tahun
        $years = SlaOlaNilai::where('tipe_id', $kategori->id ?? 0)
            ->select('tahun')
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
            return redirect()->route('admin.ola.index', [
                'tab' => $tab,
                'year' => $year,
            ]);
        }

        return view('admin.ola', [
            'tab'            => $tab,
            'year'           => $year,
            'sites'          => $sites,
            'performances'   => $performances,
            'availableYears' => $years,
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

        $kategori = TipeKategori::where('nama_tipe', 'OLA')->firstOrFail();
        $site = Site::findOrFail($data['site_id']);

        SlaOlaNilai::create([
            'site_id'       => $site->id,
            'jenis_alat_id' => $site->id_jenis_alat,
            'tipe_id'       => $kategori->id,
            'tahun'         => $data['year'],
            'bulan'         => $data['month'],
            'persentase'    => $data['percentage'],
        ]);

        return redirect()->route('admin.ola.index', [
            'tab'  => $request->get('tab', 'AWOS'),
            'year' => $data['year'],
        ])->with('success', 'Data OLA berhasil ditambahkan.');
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

        return redirect()->back()->with('success', 'Data OLA berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = SlaOlaNilai::findOrFail($id);
        $nilai->delete();

        return redirect()->back()->with('success', 'Data OLA berhasil dihapus.');
    }
}
