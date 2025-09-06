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
                    <p class="text-blue-200 text-sm mt-1">{{ date('l, d F Y') }} | Real-time Monitoring</p>
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

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Stations -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Stations</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $recapSites->count() }}</p>
                    <p class="text-green-600 text-sm mt-1">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Active
                        </span>
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H7m5 0v-9a2 2 0 00-2-2H8a2 2 0 00-2 2v9m8 0V9a2 2 0 012-2h2a2 2 0 012 2v9M7 7h.01M7 10h.01M7 13h.01"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- AWOS Stations -->
        @php
            $awosCount = $recapSites->filter(function($site) { 
                return $site->category && stripos($site->category->name, 'AWOS') !== false; 
            })->count();
        @endphp
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">AWOS Stations</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $awosCount }}</p>
                    <p class="text-blue-600 text-sm mt-1">Automatic Weather</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Average Performance -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Avg Performance</p>
                    @php
                        $avgPerf = $recapSites->flatMap(function($site) {
                            return $site->performances->pluck('percentage');
                        })->filter()->avg() ?? 0;
                    @endphp
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ round($avgPerf, 1) }}%</p>
                    <p class="text-{{ $avgPerf >= 80 ? 'green' : ($avgPerf >= 60 ? 'yellow' : 'red') }}-600 text-sm mt-1">
                        {{ $avgPerf >= 80 ? 'Excellent' : ($avgPerf >= 60 ? 'Good' : 'Needs Attention') }}
                    </p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Regional Coverage -->
        @php
            $regionalCount = $recapSites->groupBy(function($site) {
                return $site->satker->nama_satker ?? 'Unknown';
            })->count();
        @endphp
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Regional Coverage</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $regionalCount }}</p>
                    <p class="text-purple-600 text-sm mt-1">Areas Monitored</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analysis Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Performance Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Performance Overview</h3>
                <div class="flex space-x-2">
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Live Data</span>
                </div>
            </div>
            <div class="space-y-4">
                @php
                    $performanceRanges = [
                        'Excellent (≥90%)' => $recapSites->filter(function($site) { 
                            $avg = $site->performances->avg('percentage');
                            return $avg >= 90;
                        })->count(),
                        'Good (70-89%)' => $recapSites->filter(function($site) { 
                            $avg = $site->performances->avg('percentage');
                            return $avg >= 70 && $avg < 90;
                        })->count(),
                        'Fair (50-69%)' => $recapSites->filter(function($site) { 
                            $avg = $site->performances->avg('percentage');
                            return $avg >= 50 && $avg < 70;
                        })->count(),
                        'Poor (<50%)' => $recapSites->filter(function($site) { 
                            $avg = $site->performances->avg('percentage');
                            return $avg > 0 && $avg < 50;
                        })->count(),
                    ];
                    $totalSites = $recapSites->count();
                @endphp
                
                @foreach($performanceRanges as $range => $count)
                    @php
                        $percentage = $totalSites > 0 ? ($count / $totalSites) * 100 : 0;
                        $colorClass = match(true) {
                            str_contains($range, 'Excellent') => 'bg-green-500',
                            str_contains($range, 'Good') => 'bg-blue-500',
                            str_contains($range, 'Fair') => 'bg-yellow-500',
                            default => 'bg-red-500'
                        };
                    @endphp
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 {{ $colorClass }} rounded"></div>
                            <span class="text-gray-700 font-medium">{{ $range }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="{{ $colorClass }} h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-gray-900 font-bold text-sm w-12 text-right">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Regional Distribution -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Regional Distribution</h3>
                <div class="text-sm text-gray-500">{{ $recapSites->count() }} Total Stations</div>
            </div>
            <div class="space-y-4 max-h-64 overflow-y-auto">
                @php
                    $regionalData = $recapSites->groupBy(function($site) {
                        return $site->satker->nama_satker ?? 'Unknown Region';
                    })->map(function($sites) {
                        return $sites->count();
                    })->sortDesc();
                @endphp
                
                @foreach($regionalData as $region => $count)
                    @php
                        $percentage = $totalSites > 0 ? ($count / $totalSites) * 100 : 0;
                    @endphp
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-gray-700 font-medium">{{ Str::limit($region, 30) }}</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-sm text-gray-500">{{ round($percentage, 1) }}%</div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-bold">{{ $count }}</span>
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
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-600">Active</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <span class="text-sm text-gray-600">Warning</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <span class="text-sm text-gray-600">Critical</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Station</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recapSites as $site)
                        @php
                            $performance = $site->performances->avg('percentage') ?? 0;
                            $statusColor = $performance >= 80 ? 'green' : ($performance >= 60 ? 'yellow' : 'red');
                            $statusText = $performance >= 80 ? 'Active' : ($performance >= 60 ? 'Warning' : 'Critical');
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-{{ $statusColor }}-500 rounded-full mr-3"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $site->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $site->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $site->category->name ?? 'Unknown' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ Str::limit($site->satker->nama_satker ?? 'Unknown', 25) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    <div class="text-sm font-bold text-gray-900">{{ round($performance, 1) }}%</div>
                                    <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                        <div class="bg-{{ $statusColor }}-500 h-2 rounded-full transition-all duration-500" style="width: {{ min($performance, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                <button class="text-green-600 hover:text-green-900">Monitor</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-lg font-medium">No stations available</p>
                                    <p class="text-sm">Check your data connection and try again</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-blue-900 font-medium">System Information</p>
                    <p class="text-blue-700 text-sm">Monitoring {{ $recapSites->count() }} weather stations across Indonesia</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-blue-900 font-medium">Last Sync: {{ date('H:i:s') }} WIB</p>
                <p class="text-blue-700 text-sm">Next update in 5 minutes</p>
            </div>
        </div>
    </div>
@endsection