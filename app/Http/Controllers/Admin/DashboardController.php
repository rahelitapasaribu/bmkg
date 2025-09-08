<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Satker;

class DashboardController extends Controller
{
    public function index()
    {
        $recapSites = Site::with(['category', 'satker', 'performances'])
            ->orderBy('name')
            ->get()
            ->groupBy('name')
            ->map(function ($sites) {
                $site = $sites->first();

                $slaPerformances = $sites
                    ->filter(fn($s) => $s->category?->type === 'SLA')
                    ->flatMap->performances;

                $olaPerformances = $sites
                    ->filter(fn($s) => $s->category?->type === 'OLA')
                    ->flatMap->performances;

                return (object)[
                    'id' => $site->id,
                    'name' => $site->name,
                    'category' => $site->category,
                    'satker' => $site->satker,
                    'avg_sla' => $slaPerformances->avg('percentage'),
                    'avg_ola' => $olaPerformances->avg('percentage'),
                ];
            })
            ->sortBy(fn($site) => $site->category?->name) // urutkan berdasarkan type
            ->values(); // reset index biar rapi

        $recapSatkers = Satker::with('provinsi')->get();

        return view('admin.home_admin', compact('recapSites', 'recapSatkers'));
    }
}
