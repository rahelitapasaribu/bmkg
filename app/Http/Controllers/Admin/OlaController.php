<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Performance;
use Illuminate\Support\Collection;

class OlaController extends Controller
{
    public function index(Request $request)
{
    $tab  = $request->get('tab', 'AWOS');
    $year = (int) $request->get('year', date('Y'));

    // cari kategori berdasarkan nama
    $category = \App\Models\Category::where('name', $tab)->first();

    $sites = $category
        ? Site::where('category_id', $category->id)
              ->with('satker')
              ->orderBy('name')
              ->get()
        : collect();

    $siteIds = $sites->pluck('id')->toArray();

    $performances = !empty($siteIds)
        ? Performance::whereIn('site_id', $siteIds)
                     ->where('year', $year)
                     ->get()
                     ->keyBy(function ($item) {
                         return $item->site_id . '-' . $item->month;
                     })
        : collect();

    $years = Performance::select('year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();

    if (empty($years)) {
        $current = (int) date('Y');
        $years   = range($current - 5, $current + 1);
        rsort($years);
    }

    return view('admin.ola', [
        'tab'            => $tab,
        'year'           => $year,
        'sites'          => $sites,
        'performances'   => $performances,
        'availableYears' => $years,
        'months'         => [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
            7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ],
    ]);
}
    // OlaController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'site_id'    => 'required|exists:sites,id',
        'year'       => 'required|integer',
        'month'      => 'required|integer|min:1|max:12',
        'percentage' => 'required|numeric|min:0|max:100',
    ]);

    // Insert kalau belum ada, update kalau sudah ada
    \App\Models\Performance::updateOrCreate(
        [
            'site_id' => $validated['site_id'],
            'year'    => $validated['year'],
            'month'   => $validated['month'],
        ],
        [
            'percentage' => $validated['percentage'],
        ]
    );

    return redirect()->back()->with('success', 'Data berhasil disimpan!');
}

    public function update(Request $request, $id)
    {
        $perf = Performance::findOrFail($id);

        $data = $request->validate([
            'site_id'    => 'required|exists:sites,id',
            'year'       => 'required|integer',
            'month'      => 'required|integer|min:1|max:12',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        $perf->update($data);

        return redirect()->route('admin.ola.index', [
            'tab'  => $request->get('tab', 'AWOS'),
            'year' => $data['year'],
        ])->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        $perf = Performance::findOrFail($id);
        $tab  = request()->get('tab', 'AWOS');
        $year = $perf->year;

        $perf->delete();

        return redirect()->route('admin.ola.index', [
            'tab'  => $tab,
            'year' => $year,
        ])->with('success', 'Data berhasil dihapus.');
    }
}
