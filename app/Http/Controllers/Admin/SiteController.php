<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $jenisAlat = DB::table('jenis_alat')->orderBy('nama_jenis')->get();
        $satkers = DB::table('satker')->orderBy('nama_satker')->get();
        $selectedJenis = $request->get('jenis_alat_id');
        $kondisi = DB::table('kondisi_alat')->get();

        $sites = collect();
        $alatRekap = collect();
        $punyaSite = null;

        if ($selectedJenis) {
            $jenis = DB::table('jenis_alat')->where('id', $selectedJenis)->first();

            if ($jenis) {
                $punyaSite = $jenis->punya_site;

                if ($punyaSite == 1) {
                    $sites = DB::table('sites as s')
                        ->leftJoin('site_satker as ss', 's.id', '=', 'ss.site_id')
                        ->leftJoin('satker as st', 'ss.satker_id', '=', 'st.id')
                        ->leftJoin('kondisi_alat as ka', 'ss.kondisi_id', '=', 'ka.id')
                        ->select(
                            's.id',
                            's.nama_site',
                            's.merk',
                            's.tahun_pengadaan',
                            'st.id as id_satker',
                            'ka.id as kondisi_id',
                            'st.nama_satker as stasiun_pic',
                            'ka.nama_kondisi'
                        )
                        ->where('s.id_jenis_alat', $selectedJenis)
                        ->get();
                } else {
                    // ambil field tambahan supaya modal edit/tombol edit punya data lengkap
                    $alatRekap = DB::table('alat_satker as als')
                        ->leftJoin('satker as s', 'als.satker_id', '=', 's.id')
                        ->leftJoin('kondisi_alat as ka', 'als.kondisi_id', '=', 'ka.id')
                        ->leftJoin('jenis_alat as ja', 'als.jenis_alat_id', '=', 'ja.id')
                        ->select(
                            'als.id',
                            'als.jenis_alat_id',
                            'als.satker_id',
                            'als.kondisi_id',
                            'als.jumlah',
                            's.nama_satker',
                            'ja.nama_jenis',
                            'ka.nama_kondisi'
                        )
                        ->where('als.jenis_alat_id', $selectedJenis)
                        ->get()
                        ->groupBy('satker_id');
                }
            }
        }

        return view('admin.sites', compact('jenisAlat', 'selectedJenis', 'sites', 'alatRekap', 'punyaSite', 'satkers', 'kondisi'));
    }

    public function storeJenis(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
            'punya_site' => 'required|boolean',
        ]);

        DB::table('jenis_alat')->insert([
            'nama_jenis' => $request->nama_jenis,
            'punya_site' => $request->punya_site,
        ]);

        return redirect()->route('admin.sites.index')->with('success', 'Jenis alat berhasil ditambahkan!');
    }

    public function storeSite(Request $request)
    {
        $request->validate([
            'id_jenis_alat' => 'required|exists:jenis_alat,id',
            'id_satker' => 'required|exists:satker,id',
            'nama_site' => 'required|string|max:255',
            'merk' => 'nullable|string|max:255',
            'tahun_pengadaan' => 'nullable|integer',
            'kondisi_id' => 'required|exists:kondisi_alat,id',
        ]);

        // insert ke sites
        $siteId = DB::table('sites')->insertGetId([
            'id_jenis_alat' => $request->id_jenis_alat,
            'nama_site' => $request->nama_site,
            'merk' => $request->merk,
            'tahun_pengadaan' => $request->tahun_pengadaan,
        ]);

        // insert relasi ke site_satker
        DB::table('site_satker')->insert([
            'site_id' => $siteId,
            'satker_id' => $request->id_satker,
            'kondisi_id' => $request->kondisi_id,
        ]);

        return redirect()->back()->with('success', 'Site berhasil ditambahkan!');
    }

    public function updateSite(Request $request, $id)
    {
        $request->validate([
            'nama_site' => 'required|string|max:255',
            'merk' => 'nullable|string|max:255',
            'tahun_pengadaan' => 'nullable|integer',
            'id_satker' => 'required|exists:satker,id',
            'kondisi_id' => 'required|exists:kondisi_alat,id',
        ]);

        DB::beginTransaction();
        try {
            // ambil data site dulu (untuk dapat id_jenis_alat agar redirect ke jenis yang sama)
            $site = DB::table('sites')->where('id', $id)->first();
            if (! $site) {
                return redirect()->back()->with('error', 'Site tidak ditemukan.');
            }

            // update tabel sites (nama, merk, tahun)
            DB::table('sites')->where('id', $id)->update([
                'nama_site' => $request->nama_site,
                'merk' => $request->merk,
                'tahun_pengadaan' => $request->tahun_pengadaan,
            ]);

            // update atau buat relasi di site_satker (site <-> satker + kondisi)
            $existing = DB::table('site_satker')->where('site_id', $id)->first();

            if ($existing) {
                DB::table('site_satker')->where('site_id', $id)->update([
                    'satker_id' => $request->id_satker,
                    'kondisi_id' => $request->kondisi_id,
                ]);
            } else {
                DB::table('site_satker')->insert([
                    'site_id' => $id,
                    'satker_id' => $request->id_satker,
                    'kondisi_id' => $request->kondisi_id,
                ]);
            }

            DB::commit();

            // redirect kembali ke halaman sites dengan jenis alat yang sama supaya user tidak "terlempar"
            return redirect()->route('admin.sites.index', ['jenis_alat_id' => $site->id_jenis_alat])
                ->with('success', 'Site berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeAlat(Request $request)
    {
        $request->validate([
            'jenis_alat_id' => 'required|exists:jenis_alat,id',
            'satker_id'     => 'required|exists:satker,id',
            'kondisi_id'    => 'required|exists:kondisi_alat,id',
            'jumlah'        => 'required|integer|min:1',
        ]);

        // cek apakah sudah ada kombinasi yang sama
        $existing = DB::table('alat_satker')
            ->where('jenis_alat_id', $request->jenis_alat_id)
            ->where('satker_id', $request->satker_id)
            ->where('kondisi_id', $request->kondisi_id)
            ->first();

        if ($existing) {
            // kalau sudah ada → kembalikan error
            return redirect()->back()->with('error', 'Data dengan UPT dan kondisi ini sudah ada. Gunakan edit untuk mengubah jumlah.');
        }

        // kalau belum ada → insert baru
        DB::table('alat_satker')->insert([
            'jenis_alat_id' => $request->jenis_alat_id,
            'satker_id'     => $request->satker_id,
            'kondisi_id'    => $request->kondisi_id,
            'jumlah'        => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Data alat berhasil ditambahkan!');
    }


    public function updateAlat(Request $request, $id)
    {
        $request->validate([
            'satker_id'  => 'required|exists:satker,id',
            'kondisi_id' => 'required|exists:kondisi_alat,id',
            'jumlah'     => 'required|integer|min:0',
        ]);

        DB::table('alat_satker')->where('id', $id)->update([
            'satker_id'  => $request->satker_id,
            'kondisi_id' => $request->kondisi_id,
            'jumlah'     => $request->jumlah,
        ]);

        return redirect()->back()->with('success', 'Data alat berhasil diperbarui!');
    }

    public function updateAlatGroup(Request $request, $jenisId, $satkerId)
    {
        $alatData = $request->input('alat', []);

        foreach ($alatData as $kondisiId => $row) {
            DB::table('alat_satker')
                ->where('id', $row['id'])
                ->update([
                    'jumlah' => $row['jumlah'],
                ]);
        }

        return redirect()->back()->with('success', 'Data alat berhasil diperbarui!');
    }
}
