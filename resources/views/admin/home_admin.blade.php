@extends('admin.layouts.admin')

@section('title', 'BMKG Dashboard')

@section('content')
    <!-- Header Section -->
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-3xl p-8 mb-8 overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-24 -translate-x-24"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">BMKG Dashboard</h1>
                    <p class="text-blue-100 text-lg">Badan Meteorologi, Klimatologi, dan Geofisika</p>
                    <p class="text-blue-200 text-sm mt-1">{{ date('l, d F Y') }}</p>
                </div>
                <div class="text-right">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                        <div class="text-white text-sm">Last Update</div>
                        <div class="text-white font-bold text-lg">{{ date('H:i') }} WIB</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analysis Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Performance Overview -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Performance Overview</h3>
            </div>

            <!-- Bagian 1: Total Sites -->
            <div class="mb-6">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="text-gray-700 font-medium">Total Sites</div>
                    <div class="text-gray-900 font-bold text-lg">{{ $totalSites }}</div>
                </div>
            </div>

            <!-- Bagian 2: Avg Performance -->
            <div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="text-gray-700 font-medium">Average Performance</div>
                    <div class="text-gray-900 font-bold text-lg">
                        {{ round($avgPerformance ?? 0, 1) }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Regional Coverage -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Regional Coverage</h3>
                <div class="text-sm text-gray-500">{{ $recapSatkers->count() }} Total Satker</div>
            </div>
            <div class="space-y-4 max-h-64 overflow-y-auto">
                @php
                    // Ambil jumlah satker per provinsi
                    $provinsiData = $recapSatkers
                        ->groupBy(fn($satker) => $satker->provinsi->nama_provinsi ?? 'Unknown Province')
                        ->map(fn($satkers) => $satkers->count())
                        ->sortDesc();

                    $totalSatker = $recapSatkers->count();
                @endphp

                @foreach ($provinsiData as $provinsi => $count)
                    @php
                        $percentage = $totalSatker > 0 ? ($count / $totalSatker) * 100 : 0;
                    @endphp
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-gray-700 font-medium">{{ $provinsi }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-sm text-gray-500">{{ round($percentage, 1) }}%</div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-bold">
                                {{ $count }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Stations Table -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">Station Monitoring</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Site</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">STASIUN PIC</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Avg SLA</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Avg OLA</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recapSites as $site)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $site->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $site->jenis_alat ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($site->satker ?? 'Unknown', 25) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-bold text-gray-900">
                                    {{ round($site->avg_sla ?? 0, 1) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm font-bold text-gray-900">
                                    {{ round($site->avg_ola ?? 0, 1) }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No stations available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Info -->
    {{-- <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-blue-900 font-medium">System Information</p>
                    <p class="text-blue-700 text-sm">Monitoring {{ $recapSites->count() }} weather stations across
                        Indonesia</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-blue-900 font-medium">Last Sync: {{ date('H:i:s') }} WIB</p>
                <p class="text-blue-700 text-sm">Next update in 5 minutes</p>
            </div>
        </div>
    </div> --}}
@endsection
