@extends('layouts.master')

@section('title', 'Map')

@section('content')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Fullscreen Map -->
    <div id="map" class="fixed inset-0 z-0"></div>

    <!-- Side Panel -->
    <div id="sidePanel"
     class="fixed top-4 right-4 h-[calc(100%-2rem)] w-96 bg-gradient-to-b from-white to-gray-50 shadow-xl transition-transform duration-300 ease-in-out z-20 overflow-y-auto flex flex-col rounded-2xl translate-x-full">
        <div class="p-6 flex flex-col h-full">
            <!-- Navigation and Close Buttons -->
            <div class="flex justify-between items-center mb-4 -mt-2">
                <div class="flex gap-2">
                    <button id="prevBtn" onclick="navigateSatker(-1)" class="bg-[#01377D] text-white w-8 h-8 rounded-full hover:bg-[#7c3aed] transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center">
                        &lt;
                    </button>
                    <button id="nextBtn" onclick="navigateSatker(1)" class="bg-[#01377D] text-white w-8 h-8 rounded-full hover:bg-[#7c3aed] transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center">
                        &gt;
                    </button>
                </div>
                <!-- Close Button -->
                <button onclick="closePanel()" class="text-[#7c3aed] hover:text-[#01377D] transition-colors duration-200 text-xl font-semibold flex items-center gap-2 group">
                    <span class="group-hover:scale-110 transition-transform">✖</span> Tutup
                </button>
            </div>
            <!-- Panel Content -->
            <div class="flex-1">
                <h2 id="panelTitle" class="text-2xl font-bold text-[#01377D] mb-6 bg-gradient-to-r from-[#01377D] to-[#7c3aed] bg-clip-text text-transparent">Detail Satker</h2>
                <div class="space-y-4">
                    <p class="text-gray-700"><span class="font-semibold text-[#01377D]">Provinsi:</span> <span id="panelProvinsi" class="text-gray-600"></span></p>
                    <p class="text-gray-700"><span class="font-semibold text-[#01377D]">Lokasi:</span> <span id="panelLokasi" class="text-gray-600"></span></p>
                </div>
            </div>
            <!-- Footer/Accent -->
            <div class="mt-auto pt-4 border-t border-gray-200">
                <p class="text-sm text-gray-500 italic">Data updated: {{ date('F d, Y') }}</p>
            </div>
        </div>
    </div>
    <!-- Collapse Button -->
    <button id="collapseBtn"
        onclick="togglePanel()"
        class="fixed top-1/2 -translate-y-1/2 z-30 bg-white hover:bg-[#7c3aed] hover:text-white transition-all duration-200 rounded-full shadow-lg"
        style="right: calc(24rem - 2rem); width: 48px; height: 48px; display: none; align-items: center; justify-content: center;">
        <svg id="collapseIcon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <polygon points="8,12 16,6 16,18" />
        </svg>
    </button>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const satkers = @json($satkers);
        let currentSatkerIndex = -1;
        let markers = [];

        // Default and selected marker icons
        const defaultIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        const selectedIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        var map = L.map('map', { zoomControl: false })
            .setView([-2.5489, 118.0149], 6);

        L.control.zoom({ position: 'bottomleft' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Loop marker dari database
        satkers.forEach(function(s, index) {
            var marker = L.marker([s.latitude, s.longitude], { icon: defaultIcon }).addTo(map);
            markers.push(marker);

            // Popup saat hover
            marker.bindTooltip(`<b>${s.nama_satker}</b><br>${s.provinsi?.nama_provinsi ?? '-'}`, {
                permanent: false,
                direction: "top"
            });

            // Klik marker -> buka side panel
            marker.on("click", function() {
                selectSatker(index);
            });
        });

        function selectSatker(index) {
            currentSatkerIndex = index;
            const s = satkers[index];

            // Update panel content
            document.getElementById("panelTitle").innerText = s.nama_satker;
            document.getElementById("panelProvinsi").innerText = s.provinsi?.nama_provinsi ?? "-";
            document.getElementById("panelLokasi").innerText = s.latitude + ", " + s.longitude;

            // Update marker icons
            markers.forEach((marker, i) => {
                marker.setIcon(i === index ? selectedIcon : defaultIcon);
            });

            // Center map on selected marker
            map.setView([s.latitude, s.longitude], 10);

            // Show panel and button
            document.getElementById("sidePanel").classList.remove("translate-x-full");
            document.getElementById("collapseBtn").style.display = "flex";

            // Update button states
            document.getElementById("prevBtn").disabled = index === 0;
            document.getElementById("nextBtn").disabled = index === satkers.length - 1;
        }

        function navigateSatker(direction) {
            const newIndex = currentSatkerIndex + direction;
            if (newIndex >= 0 && newIndex < satkers.length) {
                selectSatker(newIndex);
            }
        }

        function closePanel() {
            document.getElementById("sidePanel").classList.add("translate-x-full");
            document.getElementById("collapseBtn").style.display = "none";
            currentSatkerIndex = -1;
            markers.forEach(marker => marker.setIcon(defaultIcon));
        }

        function togglePanel() {
            const panel = document.getElementById("sidePanel");
            const btn = document.getElementById("collapseBtn");
            const icon = document.getElementById("collapseIcon");
            if (!panel.classList.contains("collapsed")) {
                // Collapse: panel hilang, tombol tetap
                panel.classList.add("collapsed");
                panel.style.width = "0";
                panel.style.minWidth = "0";
                panel.style.background = "transparent";
                panel.querySelector(".p-6").style.display = "none";
                btn.style.right = "1rem"; // tombol di pinggir kanan dengan margin
                // Panah kanan
                icon.innerHTML = '<polygon points="16,12 8,6 8,18" />';
            } else {
                // Expand: panel muncul
                panel.classList.remove("collapsed");
                panel.style.width = "";
                panel.style.minWidth = "";
                panel.style.background = "";
                panel.querySelector(".p-6").style.display = "block";
                btn.style.right = "calc(24rem - 2rem)";
                // Panah kiri
                icon.innerHTML = '<polygon points="8,12 16,6 16,18" />';
            }
        }

        window.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const lat = urlParams.get('lat');
            const lon = urlParams.get('lon');
            const nama = urlParams.get('nama');
            if (lat && lon) {
    // Cari index satker berdasarkan koordinat
    const index = satkers.findIndex(s =>
        String(s.latitude) === String(lat) && String(s.longitude) === String(lon)
    );

    if (index !== -1) {
        // Kalau ketemu di data satker -> langsung buka sidebar
        selectSatker(index);
    } else {
        // Kalau nggak ketemu, tetap tampilkan marker biasa
        map.setView([lat, lon], 14);
        const tempMarker = L.marker([lat, lon], { icon: selectedIcon }).addTo(map);
        tempMarker.bindPopup(`<b>${nama ?? 'Lokasi UPT'}</b>`).openPopup();
    }
}


        });
    </script>

    <style>
        #sidePanel.collapsed {
            box-shadow: none !important;
            background: transparent !important;
            width: 0 !important;
            min-width: 0 !important;
            overflow: visible !important;
        }
        #sidePanel.translate-x-full {
            display: none !important;
        }
        #collapseBtn {
            transition: all 0.3s ease-in-out;
        }
        #collapseBtn:hover {
            transform: scale(1.1);
        }
        #sidePanel {
            backdrop-filter: blur(5px);
            background: linear-gradient(to bottom, rgba(255,255,255,0.95), rgba(249,250,251,0.95));
        }
    </style>
@endsection