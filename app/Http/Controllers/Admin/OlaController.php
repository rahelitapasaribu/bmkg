<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Performance;
use Illuminate\Support\Collection;

class OlaController extends Controller
{
    // Mapping nama tab ke category_id (sesuaikan dengan DB-mu)
    protected $categoryMap = [
        'AWOS' => 3,
        'RADAR' => 4,
        'AWS' => 10,
        'AWS Synoptic' => 5,
        'AWS Maritim' => 6,
        'AAWS' => 7,
        'ARG' => 8,
        'InaTEWS' => 9,
    ];

    public function index(Request $request)
    {
        $tab  = $request->get('tab', 'AWOS');
        $year = (int) $request->get('year', date('Y'));

        // ambil category_id dari map
        $categoryId = $this->categoryMap[$tab] ?? null;

        // ambil sites (dengan relasi satker) sesuai kategori; kalau tidak ada category -> empty collection
        if ($categoryId) {
            $sites = Site::where('category_id', $categoryId)
                         ->with('satker')
                         ->orderBy('name')
                         ->get();
        } else {
            $sites = collect();
        }

        // ambil performances untuk sites di year ini
        $siteIds = $sites->pluck('id')->toArray();
        if (!empty($siteIds)) {
            $performances = Performance::whereIn('site_id', $siteIds)
                                ->where('year', $year)
                                ->get();
        } else {
            $performances = collect();
        }

        // availableYears (ambil distinct years dari table performance), jika kosong buat default range
        $years = Performance::select('year')->distinct()->orderBy('year', 'desc')->pluck('year')->toArray();
        if (empty($years)) {
            $current = (int) date('Y');
            $years = range($current - 5, $current + 1);
            rsort($years);
        }

        // pastikan collections (blade mengandalkan ->where pada collections)
        if (!($performances instanceof Collection)) {
            $performances = collect($performances);
        }

        return view('admin.ola', [
            'tab' => $tab,
            'year' => $year,
            'sites' => $sites,
            'performances' => $performances,
            'availableYears' => $years,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'year'    => 'required|integer',
            'month'   => 'required|integer|min:1|max:12',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        // hindari duplicate per (site,year,month) --> updateOrCreate
        Performance::updateOrCreate(
            [
                'site_id' => $data['site_id'],
                'year'    => $data['year'],
                'month'   => $data['month'],
            ],
            ['percentage' => $data['percentage']]
        );

        return redirect()->route('admin.ola.index', ['tab' => $request->get('tab', 'AWOS'), 'year' => $data['year']])
                         ->with('success', 'Data berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $perf = Performance::findOrFail($id);

        $data = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'year'    => 'required|integer',
            'month'   => 'required|integer|min:1|max:12',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $perf->update($data);

        return redirect()->route('admin.ola.index', ['tab' => $request->get('tab', 'AWOS'), 'year' => $data['year']])
                         ->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $perf = Performance::findOrFail($id);
        $tab = request()->get('tab', 'AWOS');
        $year = $perf->year;

        $perf->delete();

        return redirect()->route('admin.ola.index', ['tab' => $tab, 'year' => $year])
                         ->with('success', 'Data berhasil dihapus.');
    }
}
