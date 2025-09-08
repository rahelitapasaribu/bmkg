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
        // Ambil data satker dengan relasi
        $uptData = DB::table('satker as s')
            ->leftJoin('provinsi as p', 's.id_provinsi', '=', 'p.id')
            ->leftJoin('staf as st', 's.id', '=', 'st.id_satker')
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
                    ->join('alat as a', 'als.id_alat', '=', 'a.id')
                    ->where('als.id_satker', $item->id)
                    ->select('a.nama_alat', 'als.jumlah')
                    ->get();

                // Convert to object for easier access in blade
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
        $alat = DB::table('alat')->orderBy('nama_alat')->get();

        return view('admin.dataupt', compact('uptData', 'provinsi', 'alat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
            'id_provinsi' => 'required|exists:provinsi,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'asn_laki' => 'nullable|integer|min:0',
            'asn_perempuan' => 'nullable|integer|min:0',
            'ppnpn_laki' => 'nullable|integer|min:0',
            'ppnpn_perempuan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Insert data satker
            $satkerId = DB::table('satker')->insertGetId([
                'nama_satker' => $request->nama_satker,
                'id_provinsi' => $request->id_provinsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            // Insert data staf
            DB::table('staf')->insert([
                'id_satker' => $satkerId,
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
            ->leftJoin('staf as st', 's.id', '=', 'st.id_satker')
            ->where('s.id', $id)
            ->select(
                's.id',
                's.nama_satker',
                's.id_provinsi',
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

        // Format data untuk response JSON
        $response = [
            'nama_satker' => $upt->nama_satker,
            'id_provinsi' => $upt->id_provinsi,
            'latitude' => $upt->latitude,
            'longitude' => $upt->longitude,
            'staf' => [
                'asn_laki' => $upt->asn_laki ?? 0,
                'asn_perempuan' => $upt->asn_perempuan ?? 0,
                'ppnpn_laki' => $upt->ppnpn_laki ?? 0,
                'ppnpn_perempuan' => $upt->ppnpn_perempuan ?? 0,
            ]
        ];

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
            'id_provinsi' => 'required|exists:provinsi,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'asn_laki' => 'nullable|integer|min:0',
            'asn_perempuan' => 'nullable|integer|min:0',
            'ppnpn_laki' => 'nullable|integer|min:0',
            'ppnpn_perempuan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Update data satker
            DB::table('satker')
                ->where('id', $id)
                ->update([
                    'nama_satker' => $request->nama_satker,
                    'id_provinsi' => $request->id_provinsi,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude
                ]);

            // Update atau insert data staf
            $existingStaf = DB::table('staf')->where('id_satker', $id)->first();

            if ($existingStaf) {
                // Update existing staf
                DB::table('staf')
                    ->where('id_satker', $id)
                    ->update([
                        'asn_laki' => $request->asn_laki ?? 0,
                        'asn_perempuan' => $request->asn_perempuan ?? 0,
                        'ppnpn_laki' => $request->ppnpn_laki ?? 0,
                        'ppnpn_perempuan' => $request->ppnpn_perempuan ?? 0,
                    ]);
            } else {
                // Insert new staf data
                DB::table('staf')->insert([
                    'id_satker' => $id,
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
            'id_satker' => 'required|exists:satker,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Jika pilih alat baru
        if ($request->id_alat === "new" && $request->filled('nama_alat_baru')) {
            $alatId = DB::table('alat')->insertGetId([
                'nama_alat' => $request->nama_alat_baru,
            ]);
        } else {
            $alatId = $request->id_alat;
        }

        // Check apakah sudah ada
        $existing = DB::table('alat_satker')
            ->where('id_satker', $request->id_satker)
            ->where('id_alat', $alatId)
            ->first();

        if ($existing) {
            DB::table('alat_satker')
                ->where('id_satker', $request->id_satker)
                ->where('id_alat', $alatId)
                ->update([
                    'jumlah' => DB::raw('jumlah + ' . $request->jumlah),
                ]);
        } else {
            DB::table('alat_satker')->insert([
                'id_satker' => $request->id_satker,
                'id_alat' => $alatId,
                'jumlah' => $request->jumlah,
            ]);
        }

        return redirect()->route('admin.dataupt.index')
            ->with('success', 'Alat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Method ini bisa diimplementasi nanti jika diperlukan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Method ini bisa diimplementasi nanti jika diperlukan
    }
}
