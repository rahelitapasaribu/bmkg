<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SlaOlaNilai;
use App\Models\TipeKategori;

class OlaController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'OLA');
        $year = (int) $request->get('year', date('Y'));

        // ambil kategori dengan nama OLA
        $kategori = TipeKategori::where('nama_kategori', 'OLA')->first();

        $nilai = $kategori
            ? SlaOlaNilai::where('kategori_id', $kategori->id)
                ->whereYear('created_at', $year)
                ->get()
            : collect();

        // ambil daftar tahun
        $years = SlaOlaNilai::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
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
            'tab' => $tab,
            'year' => $year,
            'nilai' => $nilai,
            'availableYears' => $years,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => 'required|exists:tipe_kategori,id',
            'nama' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        SlaOlaNilai::create($data);

        return redirect()->route('admin.ola.index', [
            'tab' => 'OLA',
            'year' => date('Y'),
        ])->with('success', 'Data OLA berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $nilai = SlaOlaNilai::findOrFail($id);
        $nilai->update($data);

        return redirect()->back()->with('success', 'Data OLA berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = SlaOlaNilai::findOrFail($id);
        $nilai->delete();

        return redirect()->back()->with('success', 'Data OLA berhasil dihapus.');
    }
}
