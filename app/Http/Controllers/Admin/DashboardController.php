<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Category;
use App\Models\Performance;

class DashboardController extends Controller
{
    public function index()
    {
        // Load sites dengan relasi yang dibutuhkan
        $recapSites = Site::with(['category', 'satker', 'performances'])
            ->orderBy('name')
            ->get();

        return view('admin.home_admin', compact('recapSites'));
    }
}