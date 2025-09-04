@extends('layouts.master')

@section('title', 'Map')

@section('content')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- Fullscreen Map -->
    <div id="map" class="fixed inset-0 z-0"></div>

    <!-- Side Panel -->
    <div id="sidePanel"
        class="fixed top-4 right-4 h-[calc(100%-2rem)] w-[30rem] bg-gradient-to-b from-white to-gray-50 shadow-xl 
           transition-transform duration-300 ease-in-out z-20 overflow-y-auto flex flex-col rounded-2xl translate-x-full">
        <div class="p-6 flex flex-col h-full">
            <!-- Navigation and Close Buttons -->
            <div class="flex justify-between items-center mb-4 -mt-2">
                <div class="flex gap-2">
                    <button id="prevBtn" onclick="navigateSatker(-1)"
                        class="bg-[#01377D] text-white w-8 h-8 rounded-full hover:bg-[#7c3aed] transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center">
                        &lt;
                    </button>
                    <button id="nextBtn" onclick="navigateSatker(1)"
                        class="bg-[#01377D] text-white w-8 h-8 rounded-full hover:bg-[#7c3aed] transition-colors duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed flex items-center justify-center">
                        &gt;
                    </button>
                </div>
                <!-- Close Button -->
                <button onclick="closePanel()"
                    class="text-[#7c3aed] hover:text-[#01377D] transition-colors duration-200 text-xl font-semibold flex items-center gap-2 group">
                    <span class="group-hover:scale-110 transition-transform">✖</span> Tutup
                </button>
            </div>
            <!-- Panel Content -->
            <div class="flex-1">
                <h2 id="panelTitle"
                    class="text-2xl font-bold mb-6 bg-gradient-to-r from-[#01377D] to-[#7c3aed] bg-clip-text text-transparent">
                </h2>
                <div class="space-y-2 mb-4">
                    <p class="text-gray-700"><span class="font-semibold text-[#01377D]">Provinsi:</span> <span
                            id="panelProvinsi" class="text-gray-600"></span></p>
                    <p class="text-gray-700"><span class="font-semibold text-[#01377D]">Lokasi:</span> <span
                            id="panelLokasi" class="text-gray-600"></span></p>
                </div>

                <!-- Tabs -->
                <div class="flex border-b border-gray-200 mb-4">
                    <button id="tabPegawai" onclick="switchTab('pegawai')"
                        class="flex-1 py-2 text-center font-semibold text-[#01377D] border-b-2 border-[#01377D]">
                        Pegawai
                    </button>
                    <button id="tabAlat" onclick="switchTab('alat')"
                        class="flex-1 py-2 text-center font-semibold text-gray-500 border-b-2 border-transparent hover:text-[#01377D]">
                        Alat
                    </button>
                </div>

                <!-- Pegawai Content -->
<div id="pegawaiContent" class="space-y-2">
    <table class="table-auto w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">Kategori</th>
                <th class="px-4 py-2 border">Laki-laki</th>
                <th class="px-4 py-2 border">Perempuan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="px-4 py-2 border">ASN</td>
                <td class="px-4 py-2 border text-center"><span id="asnLaki">-</span></td>
                <td class="px-4 py-2 border text-center"><span id="asnPerempuan">-</span></td>
            </tr>
            <tr>
                <td class="px-4 py-2 border">PPNPN</td>
                <td class="px-4 py-2 border text-center"><span id="ppnpnLaki">-</span></td>
                <td class="px-4 py-2 border text-center"><span id="ppnpnPerempuan">-</span></td>
            </tr>
        </tbody>
    </table>
</div>

                <!-- Alat Content -->
                <div id="alatContent" class="hidden">
                    <!-- tabel alat akan di-render via JS -->
                </div>

            </div>



        </div>
    </div>

    <!-- Dropdown Filter Provinsi -->
    <div class="absolute top-4 left-4 z-30 bg-white shadow-md rounded-lg p-2">
        <select id="provinsiFilter" onchange="filterByProvinsi()"
            class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Semua Provinsi --</option>
            @foreach ($provinsi as $p)
                <option value="{{ $p->id }}">{{ $p->nama_provinsi }}</option>
            @endforeach
        </select>
    </div>


    <!-- Collapse Button -->
    <button id="collapseBtn" onclick="togglePanel()"
        class="fixed top-1/2 -translate-y-1/2 z-30 bg-white hover:bg-[#7c3aed] hover:text-white transition-all duration-200 rounded-full shadow-lg flex items-center justify-center"
        style="width:48px;height:48px;display:none;">
        <svg id="collapseIcon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
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

        var map = L.map('map', {
                zoomControl: false
            })
            .setView([-2.5489, 118.0149], 6);

        L.control.zoom({
            position: 'bottomleft'
        }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Loop marker dari database
        satkers.forEach(function(s, index) {
            var marker = L.marker([s.latitude, s.longitude], {
                icon: defaultIcon
            }).addTo(map);
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

        // ===== pilih satker & isi konten =====
        function selectSatker(index) {
            currentSatkerIndex = index;
            const s = satkers[index];

            // header
            document.getElementById("panelTitle").innerText = s.nama_satker ?? "";
            document.getElementById("panelProvinsi").innerText = s.provinsi?.nama_provinsi ?? "-";
            document.getElementById("panelLokasi").innerText = `${s.latitude}, ${s.longitude}`;

            // isi tab Pegawai (pakai relasi 'staf' satu baris per satker)
            const staf = s.staf ?? {};
            document.getElementById("asnLaki").innerText = staf.asn_laki ?? 0;
            document.getElementById("asnPerempuan").innerText = staf.asn_perempuan ?? 0;
            document.getElementById("ppnpnLaki").innerText = staf.ppnpn_laki ?? 0;
            document.getElementById("ppnpnPerempuan").innerText = staf.ppnpn_perempuan ?? 0;

            // isi tab Alat (relasi 'alat_satker' -> 'alat')
            document.getElementById("alatContent").innerHTML = renderAlatTable(s.alat_satker || []);

            // default ke tab Pegawai tiap kali buka
            switchTab("pegawai");

            // update ikon marker
            markers.forEach((m, i) => m.setIcon(i === index ? selectedIcon : defaultIcon));

            // center map
            map.setView([s.latitude, s.longitude], 10);

            // tampilkan panel & handle
            // tampilkan panel & handle
            const panel = document.getElementById("sidePanel");

            // selalu buka full panel kalau pilih satker baru
            panel.classList.remove("translate-x-full", "collapsed");
            panel.style.width = "";
            panel.style.minWidth = "";
            panel.style.background = "";
            const inner = panel.querySelector(".p-6");
            if (inner) inner.style.display = "block";

            document.getElementById("collapseBtn").style.display = "flex";
            positionHandle();


            // update prev/next
            document.getElementById("prevBtn").disabled = index === 0;
            document.getElementById("nextBtn").disabled = index === satkers.length - 1;
        }

        function navigateSatker(direction) {
            const newIndex = currentSatkerIndex + direction;
            if (newIndex >= 0 && newIndex < satkers.length) {
                selectSatker(newIndex);
            }
        }

        // ===== close panel total =====
        function closePanel() {
            document.getElementById("sidePanel").classList.add("translate-x-full");
            document.getElementById("collapseBtn").style.display = "none";
            currentSatkerIndex = -1;
            markers.forEach(marker => marker.setIcon(defaultIcon));
        }

        // ===== collapse / expand panel =====
        function togglePanel() {
            const panel = document.getElementById("sidePanel");
            const icon = document.getElementById("collapseIcon");

            if (!panel.classList.contains("collapsed")) {
                panel.classList.add("collapsed");
                panel.style.width = "0";
                panel.style.minWidth = "0";
                panel.style.background = "transparent";
                panel.querySelector(".p-6").style.display = "none";
                icon.innerHTML = '<polygon points="16,12 8,6 8,18" />'; // panah ke kanan
            } else {
                panel.classList.remove("collapsed");
                panel.style.width = "";
                panel.style.minWidth = "";
                panel.style.background = "";
                panel.querySelector(".p-6").style.display = "block";
                icon.innerHTML = '<polygon points="8,12 16,6 16,18" />'; // panah ke kiri
            }
            positionHandle();
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
                    const tempMarker = L.marker([lat, lon], {
                        icon: selectedIcon
                    }).addTo(map);
                    tempMarker.bindPopup(`<b>${nama ?? 'Lokasi UPT'}</b>`).openPopup();
                }
            }


        });

        function filterByProvinsi() {
            const selectedProvinsi = document.getElementById("provinsiFilter").value;

            // hapus semua marker dari map
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];

            let filtered = [];

            // tampilkan marker sesuai filter
            satkers.forEach(function(s, index) {
                if (!selectedProvinsi || s.id_provinsi == selectedProvinsi) {
                    var marker = L.marker([s.latitude, s.longitude], {
                        icon: defaultIcon
                    }).addTo(map);
                    markers.push(marker);

                    marker.bindTooltip(`<b>${s.nama_satker}</b><br>${s.provinsi?.nama_provinsi ?? '-'}`);

                    marker.on("click", function() {
                        selectSatker(index);
                    });

                    filtered.push([s.latitude, s.longitude]);
                }
            });

            // atur zoom sesuai provinsi
            if (!selectedProvinsi) {
                map.setView([-2.5489, 118.0149], 6); // default zoom Indonesia
            } else if (filtered.length > 0) {
                const bounds = L.latLngBounds(filtered);
                map.fitBounds(bounds);
            }
        }

        // ===== tab switcher (tetap seperti punyamu) =====
        function switchTab(tab) {
            const tabPegawai = document.getElementById("tabPegawai");
            const tabAlat = document.getElementById("tabAlat");
            const pegawaiContent = document.getElementById("pegawaiContent");
            const alatContent = document.getElementById("alatContent");

            if (tab === "pegawai") {
                pegawaiContent.classList.remove("hidden");
                alatContent.classList.add("hidden");
                tabPegawai.classList.add("text-[#01377D]", "border-[#01377D]");
                tabPegawai.classList.remove("text-gray-500", "border-transparent");
                tabAlat.classList.add("text-gray-500", "border-transparent");
                tabAlat.classList.remove("text-[#01377D]", "border-[#01377D]");
            } else {
                pegawaiContent.classList.add("hidden");
                alatContent.classList.remove("hidden");
                tabAlat.classList.add("text-[#01377D]", "border-[#01377D]");
                tabAlat.classList.remove("text-gray-500", "border-transparent");
                tabPegawai.classList.add("text-gray-500", "border-transparent");
                tabPegawai.classList.remove("text-[#01377D]", "border-[#01377D]");
            }
        }

        function positionHandle() {
            const panel = document.getElementById("sidePanel");
            const btn = document.getElementById("collapseBtn");

            // kalau panel disembunyikan penuh (translate-x-full), taruh 1rem dari kanan layar
            if (panel.classList.contains("translate-x-full")) {
                btn.style.right = "1rem";
                return;
            }
            // kalau panel collapsed paksa 1rem dari kanan
            if (panel.classList.contains("collapsed")) {
                btn.style.right = "1rem";
                return;
            }
            // panel terbuka: letakkan di tepi kiri panel (offsetWidth - half of button)
            const panelWidth = panel.offsetWidth || 480;
            // tambah offset biar tombol keluar sedikit
            btn.style.right = (panelWidth - 24 + 16) + "px"; // +16px nongol keluar

        }

        // ===== builder tabel alat =====
        function renderAlatTable(items = []) {
            if (!items || items.length === 0) {
                return `<div class="text-gray-500 text-sm">Tidak ada data alat</div>`;
            }
            const rows = items.map(it => `
    <tr>
      <td class="px-3 py-2 border border-gray-200">${it.alat?.nama_alat ?? '-'}</td>
      <td class="px-3 py-2 border border-gray-200 text-center">${it.jumlah ?? 0}</td>
    </tr>
  `).join("");
            return `
    <div class="overflow-x-auto">
      <table class="w-full text-sm border border-gray-200 rounded-md">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-3 py-2 text-center">Nama Alat</th>
            <th class="px-3 py-2 text-center">Jumlah</th>
          </tr>
        </thead>
        <tbody>${rows}</tbody>
      </table>
    </div>
  `;
        }

        // ===== posisikan handle saat load & resize =====
        window.addEventListener("resize", positionHandle);
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
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.95), rgba(249, 250, 251, 0.95));
        }
    </style>
@endsection
