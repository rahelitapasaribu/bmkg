<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataUptController extends Controller
{
    public function index()
    {
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
            ->orderBy('p.nama_provinsi', 'asc')
            ->orderBy('s.nama_satker', 'asc')
            ->get()
            ->map(function ($item) {
                $item->alat_satker = DB::table('alat_satker as als')
                    ->leftJoin('jenis_alat as ja', 'als.jenis_alat_id', '=', 'ja.id')
                    ->leftJoin('kondisi_alat as ka', 'als.kondisi_id', '=', 'ka.id')
                    ->where('als.satker_id', $item->id)
                    ->select('als.id', 'als.jenis_alat_id', 'ja.nama_jenis', 'ka.nama_kondisi', 'als.jumlah', 'ja.punya_site')
                    ->get();

                $item->provinsi = (object)['nama_provinsi' => $item->nama_provinsi];
                $item->staf = (object)[
                    'asn_laki' => $item->asn_laki ?? 0,
                    'asn_perempuan' => $item->asn_perempuan ?? 0,
                    'ppnpn_laki' => $item->ppnpn_laki ?? 0,
                    'ppnpn_perempuan' => $item->ppnpn_perempuan ?? 0,
                ];

                return $item;
            });

        $provinsi  = DB::table('provinsi')->orderBy('nama_provinsi')->get();
        $jenisAlat = DB::table('jenis_alat')->orderBy('nama_jenis')->get();
        $kondisi   = DB::table('kondisi_alat')->orderBy('nama_kondisi')->get();

        return view('admin.dataupt', compact('uptData', 'provinsi', 'jenisAlat', 'kondisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
            'id_provinsi' => 'required|exists:provinsi,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'asn_laki' => 'nullable|integer|min:0',
            'asn_perempuan' => 'nullable|integer|min:0',
            'ppnpn_laki' => 'nullable|integer|min:0',
            'ppnpn_perempuan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $satkerId = DB::table('satker')->insertGetId([
                'nama_satker' => $request->nama_satker,
                'id_provinsi' => $request->id_provinsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            DB::table('staf')->insert([
                'id_satker' => $satkerId, // ✅ pakai id_satker
                'asn_laki' => $request->asn_laki ?? 0,
                'asn_perempuan' => $request->asn_perempuan ?? 0,
                'ppnpn_laki' => $request->ppnpn_laki ?? 0,
                'ppnpn_perempuan' => $request->ppnpn_perempuan ?? 0,
            ]);

            DB::commit();
            return redirect()->route('admin.dataupt.index')->with('success', 'Data UPT berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

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
            return redirect()->route('admin.dataupt.index')->with('error', 'Data tidak ditemukan!');
        }

        $upt->alat_satker = DB::table('alat_satker as als')
            ->leftJoin('jenis_alat as ja', 'als.jenis_alat_id', '=', 'ja.id')
            ->leftJoin('kondisi_alat as ka', 'als.kondisi_id', '=', 'ka.id')
            ->where('als.satker_id', $id)
            ->select(
                'als.id',
                'als.jenis_alat_id',
                'ja.nama_jenis',
                'ka.nama_kondisi',
                'als.jumlah',
                'ja.punya_site'
            )
            ->get();

        $upt->site_satker = DB::table('site_satker as ss')
            ->join('sites as s', 'ss.site_id', '=', 's.id')
            ->leftJoin('kondisi_alat as ka', 'ss.kondisi_id', '=', 'ka.id')
            ->where('ss.satker_id', $id)
            ->select(
                's.id',
                's.nama_site',
                's.merk',
                's.tahun_pengadaan',
                's.id_jenis_alat',
                'ka.nama_kondisi'
            )
            ->get();

        $upt->staf = (object)[
            'asn_laki' => $upt->asn_laki ?? 0,
            'asn_perempuan' => $upt->asn_perempuan ?? 0,
            'ppnpn_laki' => $upt->ppnpn_laki ?? 0,
            'ppnpn_perempuan' => $upt->ppnpn_perempuan ?? 0,
        ];

        $provinsi  = DB::table('provinsi')->orderBy('nama_provinsi')->get();
        $jenisAlat = DB::table('jenis_alat')->orderBy('nama_jenis')->get();
        $kondisi   = DB::table('kondisi_alat')->orderBy('nama_kondisi')->get();

        return view('admin.dataupt-edit', compact('upt', 'provinsi', 'jenisAlat', 'kondisi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
            'id_provinsi' => 'required|exists:provinsi,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'asn_laki' => 'nullable|integer|min:0',
            'asn_perempuan' => 'nullable|integer|min:0',
            'ppnpn_laki' => 'nullable|integer|min:0',
            'ppnpn_perempuan' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            DB::table('satker')->where('id', $id)->update([
                'nama_satker' => $request->nama_satker,
                'id_provinsi' => $request->id_provinsi,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            $existingStaf = DB::table('staf')->where('id_satker', $id)->first(); // ✅ id_satker

            if ($existingStaf) {
                DB::table('staf')->where('id_satker', $id)->update([ // ✅ id_satker
                    'asn_laki' => $request->asn_laki ?? 0,
                    'asn_perempuan' => $request->asn_perempuan ?? 0,
                    'ppnpn_laki' => $request->ppnpn_laki ?? 0,
                    'ppnpn_perempuan' => $request->ppnpn_perempuan ?? 0,
                ]);
            } else {
                DB::table('staf')->insert([
                    'id_satker' => $id, // ✅ id_satker
                    'asn_laki' => $request->asn_laki ?? 0,
                    'asn_perempuan' => $request->asn_perempuan ?? 0,
                    'ppnpn_laki' => $request->ppnpn_laki ?? 0,
                    'ppnpn_perempuan' => $request->ppnpn_perempuan ?? 0,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.dataupt.index')->with('success', 'Data UPT berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function storeAlat(Request $request)
    {
        $request->validate([
            'satker_id' => 'required|exists:satker,id',
            'jenis_alat_id' => 'required|exists:jenis_alat,id',
            'kondisi_id' => 'required|exists:kondisi_alat,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $existing = DB::table('alat_satker')
            ->where('satker_id', $request->satker_id) // ✅ satker_id
            ->where('jenis_alat_id', $request->jenis_alat_id)
            ->where('kondisi_id', $request->kondisi_id)
            ->first();

        if ($existing) {
            DB::table('alat_satker')->where('id', $existing->id)->update([
                'jumlah' => DB::raw('jumlah + ' . (int) $request->jumlah),
            ]);
        } else {
            DB::table('alat_satker')->insert([
                'satker_id' => $request->satker_id, // ✅ satker_id
                'jenis_alat_id' => $request->jenis_alat_id,
                'kondisi_id' => $request->kondisi_id,
                'jumlah' => $request->jumlah,
            ]);
        }

        return redirect()->route('admin.dataupt.index')->with('success', 'Alat berhasil ditambahkan!');
    }
}
