<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataUptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data satker dengan relasi provinsi & staf
        $uptData = DB::table('satker as s')
            ->leftJoin('provinsi as p', 's.provinsi_id', '=', 'p.id')
            ->leftJoin('staf as st', 's.id', '=', 'st.satker_id')
            ->select(
                's.id',
                's.nama_satker',
                's.latitude',
                's.longitude',
                'p.nama_provinsi',
                'st.asn_laki',
                'st.asn_perempuan',
                'st.ppnpn_laki',
                'st.ppnpn_perempuan'
            )
            ->get()
            ->map(function ($item) {
                // Ambil data alat untuk setiap UPT
                $item->alat_satker = DB::table('alat_satker as als')
                    ->join('jenis_alat as ja', 'als.jenis_alat_id', '=', 'ja.id')
                    ->join('kondisi_alat as ka', 'als.kondisi_id', '=', 'ka.id')
                    ->where('als.satker_id', $item->id)
                    ->select('ja.nama_jenis', 'ka.nama_kondisi', 'als.jumlah')
                    ->get();

                // Convert ke object biar gampang dipakai di Blade
                $item->provinsi = (object)['nama_provinsi' => $item->nama_provinsi];
                $item->staf = (object)[
                    'asn_laki' => $item->asn_laki ?? 0,
                    'asn_perempuan' => $item->asn_perempuan ?? 0,
                    'ppnpn_laki' => $item->ppnpn_laki ?? 0,
                    'ppnpn_perempuan' => $item->ppnpn_perempuan ?? 0,
                ];

                return $item;
            });

        $provinsi = DB::table('provinsi')->orderBy('nama_provinsi')->get();
        $jenisAlat = DB::table('jenis_alat')->orderBy('nama_jenis')->get();
        $kondisi = DB::table('kondisi_alat')->orderBy('nama_kondisi')->get();

        return view('admin.dataupt', compact('uptData', 'provinsi', 'jenisAlat', 'kondisi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'asn_laki' => 'nullable|integer|min:0',
            'asn_perempuan' => 'nullable|integer|min:0',
            'ppnpn_laki' => 'nullable|integer|min:0',
            'ppnpn_perempuan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $satkerId = DB::table('satker')->insertGetId([
                'nama_satker' => $request->nama_satker,
                'provinsi_id' => $request->provinsi_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            DB::table('staf')->insert([
                'satker_id' => $satkerId,
                'asn_laki' => $request->asn_laki ?? 0,
                'asn_perempuan' => $request->asn_perempuan ?? 0,
                'ppnpn_laki' => $request->ppnpn_laki ?? 0,
                'ppnpn_perempuan' => $request->ppnpn_perempuan ?? 0,
            ]);

            DB::commit();

            return redirect()->route('admin.dataupt.index')
                ->with('success', 'Data UPT berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $upt = DB::table('satker as s')
            ->leftJoin('staf as st', 's.id', '=', 'st.satker_id')
            ->where('s.id', $id)
            ->select(
                's.id',
                's.nama_satker',
                's.provinsi_id',
                's.latitude',
                's.longitude',
                'st.asn_laki',
                'st.asn_perempuan',
                'st.ppnpn_laki',
                'st.ppnpn_perempuan'
            )
            ->first();

        if (!$upt) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'nama_satker' => $upt->nama_satker,
            'provinsi_id' => $upt->provinsi_id,
            'latitude' => $upt->latitude,
            'longitude' => $upt->longitude,
            'staf' => [
                'asn_laki' => $upt->asn_laki ?? 0,
                'asn_perempuan' => $upt->asn_perempuan ?? 0,
                'ppnpn_laki' => $upt->ppnpn_laki ?? 0,
                'ppnpn_perempuan' => $upt->ppnpn_perempuan ?? 0,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'asn_laki' => 'nullable|integer|min:0',
            'asn_perempuan' => 'nullable|integer|min:0',
            'ppnpn_laki' => 'nullable|integer|min:0',
            'ppnpn_perempuan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            DB::table('satker')
                ->where('id', $id)
                ->update([
                    'nama_satker' => $request->nama_satker,
                    'provinsi_id' => $request->provinsi_id,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude
                ]);

            $existingStaf = DB::table('staf')->where('satker_id', $id)->first();

            if ($existingStaf) {
                DB::table('staf')
                    ->where('satker_id', $id)
                    ->update([
                        'asn_laki' => $request->asn_laki ?? 0,
                        'asn_perempuan' => $request->asn_perempuan ?? 0,
                        'ppnpn_laki' => $request->ppnpn_laki ?? 0,
                        'ppnpn_perempuan' => $request->ppnpn_perempuan ?? 0,
                    ]);
            } else {
                DB::table('staf')->insert([
                    'satker_id' => $id,
                    'asn_laki' => $request->asn_laki ?? 0,
                    'asn_perempuan' => $request->asn_perempuan ?? 0,
                    'ppnpn_laki' => $request->ppnpn_laki ?? 0,
                    'ppnpn_perempuan' => $request->ppnpn_perempuan ?? 0,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.dataupt.index')
                ->with('success', 'Data UPT berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store alat for specific UPT
     */
    public function storeAlat(Request $request)
    {
        $request->validate([
            'satker_id' => 'required|exists:satker,id',
            'jenis_alat_id' => 'required|exists:jenis_alat,id',
            'kondisi_id' => 'required|exists:kondisi_alat,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $existing = DB::table('alat_satker')
            ->where('satker_id', $request->satker_id)
            ->where('jenis_alat_id', $request->jenis_alat_id)
            ->where('kondisi_id', $request->kondisi_id)
            ->first();

        if ($existing) {
            DB::table('alat_satker')
                ->where('id', $existing->id)
                ->update([
                    'jumlah' => DB::raw('jumlah + ' . $request->jumlah),
                ]);
        } else {
            DB::table('alat_satker')->insert([
                'satker_id' => $request->satker_id,
                'jenis_alat_id' => $request->jenis_alat_id,
                'kondisi_id' => $request->kondisi_id,
                'jumlah' => $request->jumlah,
            ]);
        }

        return redirect()->route('admin.dataupt.index')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    // show & destroy masih kosong, bisa ditambah kalau diperlukan
}
