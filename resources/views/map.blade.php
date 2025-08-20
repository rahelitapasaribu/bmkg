@extends('layouts.master')

@section('title', 'Map')

@section('content')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Fullscreen Map -->
    <div id="map" class="fixed inset-0 z-0"></div>

    <!-- Side Panel -->
    <div id="sidePanel"
         class="fixed top-0 right-0 h-full w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-20 overflow-y-auto">
        <div class="p-5">
            <button onclick="closePanel()" class="mb-4 text-gray-500 hover:text-gray-700">✖ Tutup</button>
            <h2 id="panelTitle" class="text-2xl font-bold text-[#01377D] mb-4">Detail Satker</h2>
            <p><b>Provinsi:</b> <span id="panelProvinsi"></span></p>
            <p><b>Lokasi:</b> <span id="panelLokasi"></span></p>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        
        const satkers = @json($satkers);

        var map = L.map('map', { zoomControl: false })
            .setView([-2.5489, 118.0149], 6);

        L.control.zoom({ position: 'bottomleft' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Loop marker dari database
        satkers.forEach(function(s) {
            var marker = L.marker([s.latitude, s.longitude]).addTo(map);

            // Popup saat hover
            marker.bindTooltip(`<b>${s.nama_satker}</b><br>${s.provinsi?.nama_provinsi ?? '-'}`, {
                permanent: false,
                direction: "top"
            });

            // Klik marker -> buka side panel
            marker.on("click", function() {
                document.getElementById("panelTitle").innerText = s.nama_satker;
                document.getElementById("panelProvinsi").innerText = s.provinsi?.nama_provinsi ?? "-";
                document.getElementById("panelLokasi").innerText = s.latitude + ", " + s.longitude;

                document.getElementById("sidePanel").classList.remove("translate-x-full");
            });
        });

        function closePanel() {
            document.getElementById("sidePanel").classList.add("translate-x-full");
        }
    </script>
@endsection
