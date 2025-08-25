@extends('layouts.master')
@section('title', 'Data UPT')
@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">Data UPT</h2>
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-12">No</th>
                    <th class="px-4 py-3 text-left">Nama UPT</th>
                    <th class="px-4 py-3 text-left">Provinsi</th>
                    <th class="px-4 py-3 text-left">Longitude</th>
                    <th class="px-4 py-3 text-left">Latitude</th>
                    <th class="px-4 py-3 text-center">Detail Lokasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @foreach($upts as $index => $upt)
                <tr>
                    <td class="px-4 py-3">{{ $index+1 }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-800">
                        {{ $upt->nama_satker }}
                    </td>
                    <td class="px-4 py-3">{{ $upt->nama_provinsi }}</td>
                    <td class="px-4 py-3">{{ $upt->longitude ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $upt->latitude ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($upt->longitude && $upt->latitude)
                    <a href="{{ route('map') }}?lat={{ $upt->latitude }}&lon={{ $upt->longitude }}&nama={{ urlencode($upt->nama_satker) }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow mr-2 inline-flex items-center">
                        <i class="fas fa-map-marker-alt mr-1"></i> Lihat Map
                    </a>
                @endif
            </td>
        </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail UPT -->
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 relative">
        <button onclick="closeDetailModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">✖</button>
        <h3 id="detailModalTitle" class="text-xl font-bold mb-4 text-[#01377D]">Detail UPT</h3>
        <div id="detailModalContent" class="space-y-3 text-gray-700">
            <!-- konten detail akan dimasukkan lewat JS -->
        </div>
    </div>
</div>

<!-- Modal Map -->
<div id="mapModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-4xl h-5/6 rounded-lg shadow-lg p-6 relative">
        <button onclick="closeMapModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl z-10">✖</button>
        <h3 id="mapModalTitle" class="text-xl font-bold mb-4 text-[#01377D]">Lokasi UPT</h3>
        <div id="mapContainer" class="w-full h-5/6 rounded-lg border">
            <!-- Map akan dimuat di sini -->
        </div>
    </div>
</div>

<script>
    // Data detail UPT
    const uptDetails = @json($upts);
    
    function openDetailModal(id) {
        const upt = uptDetails.find(item => item.id === id);
        if (upt) {
            document.getElementById('detailModalTitle').innerText = `Detail ${upt.nama_satker}`;
            document.getElementById('detailModalContent').innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="mb-2"><b>Provinsi:</b> ${upt.nama_provinsi}</p>
                        <p class="mb-2"><b>Lokasi:</b> ${upt.lokasi}</p>
                        <p class="mb-2"><b>Longitude:</b> ${upt.longitude ?? '-'}</p>
                        <p class="mb-2"><b>Latitude:</b> ${upt.latitude ?? '-'}</p>
                        <p class="mb-2"><b>ASN Laki-laki:</b> ${upt.asn_laki}</p>
                        <p class="mb-2"><b>ASN Perempuan:</b> ${upt.asn_perempuan}</p>
                    </div>
                    <div>
                        <p class="mb-2"><b>Jumlah PPNPN:</b> ${upt.ppnpn ?? '-'}</p>
                        <p class="mb-2"><b>Radar Cuaca:</b> ${upt.radar ?? '-'}</p>
                        <p class="mb-2"><b>AWS:</b> ${upt.aws ?? '-'}</p>
                        <p class="mb-2"><b>AWOS:</b> ${upt.awos ?? '-'}</p>
                        <p class="mb-2"><b>ARG:</b> ${upt.arg ?? '-'}</p>
                        <p class="mb-2"><b>AAWS:</b> ${upt.aaws ?? '-'}</p>
                        <p class="mb-2"><b>Seismograf:</b> ${upt.seismograf ?? '-'}</p>
                        <p class="mb-2"><b>Lainnya:</b> ${upt.lainnya ?? '-'}</p>
                    </div>
                </div>
            `;
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }
    }
    
    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('flex');
        document.getElementById('detailModal').classList.add('hidden');
    }
    
    function openMapModal(id, nama_satker, latitude, longitude) {
        document.getElementById('mapModalTitle').innerText = `Lokasi ${nama_satker}`;
        
        // Clear previous map content
        document.getElementById('mapContainer').innerHTML = '';
        
        // Create iframe for Google Maps
        const mapIframe = document.createElement('iframe');
        mapIframe.src = `https://www.google.com/maps?q=${latitude},${longitude}&hl=id&z=14&amp;output=embed`;
        mapIframe.width = '100%';
        mapIframe.height = '100%';
        mapIframe.frameBorder = '0';
        mapIframe.style.border = '0';
        mapIframe.referrerPolicy = 'no-referrer-when-downgrade';
        
        document.getElementById('mapContainer').appendChild(mapIframe);
        
        // Add coordinates info below map
        const coordInfo = document.createElement('div');
        coordInfo.className = 'mt-3 p-3 bg-gray-100 rounded';
        coordInfo.innerHTML = `
            <p class="text-sm text-gray-600">
                <b>Koordinat:</b> ${latitude}, ${longitude}<br>
                <a href="https://www.google.com/maps?q=${latitude},${longitude}" target="_blank" 
                   class="text-blue-600 hover:text-blue-800 underline">
                    <i class="fas fa-external-link-alt mr-1"></i> Buka di Google Maps
                </a>
            </p>
        `;
        document.getElementById('mapContainer').appendChild(coordInfo);
        
        document.getElementById('mapModal').classList.remove('hidden');
        document.getElementById('mapModal').classList.add('flex');
    }
    
    function closeMapModal() {
        document.getElementById('mapModal').classList.remove('flex');
        document.getElementById('mapModal').classList.add('hidden');
        // Clear map content to stop loading
        document.getElementById('mapContainer').innerHTML = '';
    }
    
    // Close modals when clicking outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });
    
    document.getElementById('mapModal').addEventListener('click', function(e) {
        if (e.target === this) closeMapModal();
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDetailModal();
            closeMapModal();
        }
    });
</script>

<!-- Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endsection

@section('footer')
    @include('layouts.footer')
@endsection