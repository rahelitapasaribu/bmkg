@extends('admin.layouts.admin')

@section('title', 'OLA')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-xl font-bold text-blue-700 mb-6">OLA Management</h1>

    <!-- Tabs -->
    <div class="border-b border-gray-300 flex space-x-6">
        @php
            $tabs = ['AWOS', 'RADAR', 'AWS', 'AWS Synoptic', 'AWS Maritim', 'AAWS', 'ARG', 'InaTEWS'];
            $active = request()->get('tab', 'AWOS'); // default ke AWOS
        @endphp

        @foreach($tabs as $tab)
            <a href="{{ route('admin.ola.index', ['tab' => $tab]) }}"
               class="pb-2 text-sm font-medium transition 
                      {{ $active === $tab ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                {{ $tab }}
            </a>
        @endforeach
    </div>

    <!-- Content -->
    <div class="mt-6">
        <!-- Filter Tahun dan Tombol Tambah & Edit -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center space-x-4">
                <label class="text-sm font-medium text-gray-700">Filter Tahun:</label>
                <select id="yearFilter" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                </select>
            </div>
            <div class="flex space-x-3">
                <button id="editDataBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    ✏️ Edit Data
                </button>
                <button id="addDataBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    + Tambah Data
                </button>
            </div>
        </div>

        @if($active === 'RADAR')
            <!-- Tabel untuk RADAR -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Merk</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stasiun PIC</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jan</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Feb</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mar</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apr</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mei</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jun</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jul</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agt</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sep</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Okt</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nov</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Des</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Sample data for RADAR -->
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">Jakarta</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">Vaisala</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">BMKG Jakarta</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">95%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">92%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">88%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">90%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">93%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">91%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">89%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">94%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">96%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">87%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">85%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">92%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <!-- Tabel untuk tab lainnya (AWOS, AWS, dll) -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Sites</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jan</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Feb</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mar</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apr</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mei</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jun</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jul</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agt</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sep</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Okt</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nov</th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Des</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Sample data -->
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">{{ $active }} Kategori 1 Bawean</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">95%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">92%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">88%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">90%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">93%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">91%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">89%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">94%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">96%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">87%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">85%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">92%</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">{{ $active }} Kategori 2 Semarang</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">98%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">96%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">94%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">92%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">97%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">95%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">93%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">99%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">98%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">96%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">94%</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm text-gray-900">97%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Success Notification Pop-up -->
<div id="successNotification" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="relative mx-auto p-6 border w-96 shadow-lg rounded-md bg-white">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Berhasil!</h3>
                <p id="successMessage" class="text-sm text-gray-600 mb-4">Data berhasil disimpan.</p>
                <button id="successOkBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pop-up untuk tab RADAR -->
<div id="radarModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="radarModalTitle" class="text-lg font-bold text-gray-900 mb-4">Tambah Data RADAR</h3>
            <form id="radarForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                    <select id="radarLokasi" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Lokasi</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Medan">Medan</option>
                        <option value="Makassar">Makassar</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Merk</label>
                    <select id="radarMerk" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Merk</option>
                        <option value="Vaisala">Vaisala</option>
                        <option value="Gematronik">Gematronik</option>
                        <option value="Baron">Baron</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stasiun PIC</label>
                    <select id="radarStasiun" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Stasiun PIC</option>
                        <option value="BMKG Jakarta">BMKG Jakarta</option>
                        <option value="BMKG Surabaya">BMKG Surabaya</option>
                        <option value="BMKG Medan">BMKG Medan</option>
                        <option value="BMKG Makassar">BMKG Makassar</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select id="radarBulan" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Bulan</option>
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <select id="radarTahun" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai (%)</label>
                    <input type="number" id="radarNilai" min="0" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan angka (contoh: 90)">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="radarCancelBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pop-up untuk tab lainnya -->
<div id="generalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 id="generalModalTitle" class="text-lg font-bold text-gray-900 mb-4">Tambah Data <span id="modalTitle"></span></h3>
            <form id="generalForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Sites</label>
                    <select id="generalSites" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Sites</option>
                        <!-- Options akan diisi dinamis berdasarkan tab yang aktif -->
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select id="generalBulan" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Bulan</option>
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember">Desember</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <select id="generalTahun" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nilai (%)</label>
                    <input type="number" id="generalNilai" min="0" max="100" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan angka (contoh: 90)">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" id="generalCancelBtn" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addDataBtn = document.getElementById('addDataBtn');
    const editDataBtn = document.getElementById('editDataBtn');
    const radarModal = document.getElementById('radarModal');
    const generalModal = document.getElementById('generalModal');
    const successNotification = document.getElementById('successNotification');
    const radarCancelBtn = document.getElementById('radarCancelBtn');
    const generalCancelBtn = document.getElementById('generalCancelBtn');
    const successOkBtn = document.getElementById('successOkBtn');
    const modalTitle = document.getElementById('modalTitle');
    const generalSites = document.getElementById('generalSites');
    const radarModalTitle = document.getElementById('radarModalTitle');
    const generalModalTitle = document.getElementById('generalModalTitle');
    
    // Get current active tab
    const currentTab = '{{ $active }}';
    
    // Variable to track current mode (add/edit)
    let currentMode = 'add';
    
    // Sites data untuk setiap tab
    const sitesData = {
        'AWOS': [
            'AWOS Kategori 1 Bawean',
            'AWOS Kategori 2 Semarang',
            'AWOS Kategori 1 Jakarta',
            'AWOS Kategori 3 Surabaya'
        ],
        'AWS': [
            'AWS Kategori 1 Bandung',
            'AWS Kategori 2 Yogyakarta',
            'AWS Kategori 1 Malang'
        ],
        'AWS Synoptic': [
            'AWS Synoptic Jakarta Pusat',
            'AWS Synoptic Bogor',
            'AWS Synoptic Depok'
        ],
        'AWS Maritim': [
            'AWS Maritim Tanjung Priok',
            'AWS Maritim Merak',
            'AWS Maritim Bakauheni'
        ],
        'AAWS': [
            'AAWS Stasiun 1 Medan',
            'AAWS Stasiun 2 Pekanbaru',
            'AAWS Stasiun 3 Padang'
        ],
        'ARG': [
            'ARG Unit 1 Makassar',
            'ARG Unit 2 Manado',
            'ARG Unit 3 Kendari'
        ],
        'InaTEWS': [
            'InaTEWS Point 1 Bali',
            'InaTEWS Point 2 Lombok',
            'InaTEWS Point 3 Flores'
        ]
    };
    
    // Function to show success notification
    function showSuccessNotification(message, type = 'add') {
        const successMessage = document.getElementById('successMessage');
        if (type === 'edit') {
            successMessage.textContent = `Data ${currentTab} berhasil diupdate!`;
        } else {
            successMessage.textContent = `Data ${currentTab} berhasil ditambahkan!`;
        }
        successNotification.classList.remove('hidden');
    }
    
    // Function to populate modal for edit mode
    function populateModalForEdit() {
        if (currentTab === 'RADAR') {
            // For RADAR, populate with existing data (you would get this from database)
            document.getElementById('radarLokasi').value = 'Jakarta'; // Example existing data
            document.getElementById('radarMerk').value = 'Vaisala';
            document.getElementById('radarStasiun').value = 'BMKG Jakarta';
            document.getElementById('radarBulan').value = 'Januari';
            document.getElementById('radarTahun').value = '2025';
            document.getElementById('radarNilai').value = '95';
        } else {
            // For other tabs, populate with existing data
            document.getElementById('generalSites').value = sitesData[currentTab][0]; // Example existing data
            document.getElementById('generalBulan').value = 'Januari';
            document.getElementById('generalTahun').value = '2025';
            document.getElementById('generalNilai').value = '95';
        }
    }
    
    // Event listener untuk tombol tambah
    addDataBtn.addEventListener('click', function() {
        currentMode = 'add';
        
        if (currentTab === 'RADAR') {
            radarModalTitle.textContent = 'Tambah Data RADAR';
            radarModal.classList.remove('hidden');
        } else {
            // Update modal title dan populate sites dropdown
            modalTitle.textContent = currentTab;
            generalModalTitle.textContent = 'Tambah Data ' + currentTab;
            
            // Clear existing options
            generalSites.innerHTML = '<option value="">Pilih Sites</option>';
            
            // Add sites for current tab
            if (sitesData[currentTab]) {
                sitesData[currentTab].forEach(function(site) {
                    const option = document.createElement('option');
                    option.value = site;
                    option.textContent = site;
                    generalSites.appendChild(option);
                });
            }
            
            generalModal.classList.remove('hidden');
        }
    });
    
    // Event listener untuk tombol edit
    editDataBtn.addEventListener('click', function() {
        currentMode = 'edit';
        
        if (currentTab === 'RADAR') {
            radarModalTitle.textContent = 'Edit Data RADAR';
            radarModal.classList.remove('hidden');
            populateModalForEdit();
        } else {
            // Update modal title dan populate sites dropdown
            modalTitle.textContent = currentTab;
            generalModalTitle.textContent = 'Edit Data ' + currentTab;
            
            // Clear existing options
            generalSites.innerHTML = '<option value="">Pilih Sites</option>';
            
            // Add sites for current tab
            if (sitesData[currentTab]) {
                sitesData[currentTab].forEach(function(site) {
                    const option = document.createElement('option');
                    option.value = site;
                    option.textContent = site;
                    generalSites.appendChild(option);
                });
            }
            
            generalModal.classList.remove('hidden');
            populateModalForEdit();
        }
    });
    
    // Event listener untuk tombol cancel
    radarCancelBtn.addEventListener('click', function() {
        radarModal.classList.add('hidden');
        document.getElementById('radarForm').reset();
    });
    
    generalCancelBtn.addEventListener('click', function() {
        generalModal.classList.add('hidden');
        document.getElementById('generalForm').reset();
    });
    
    // Event listener untuk tombol OK di success notification
    successOkBtn.addEventListener('click', function() {
        successNotification.classList.add('hidden');
    });
    
    // Event listener untuk form submit RADAR
    document.getElementById('radarForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const lokasi = document.getElementById('radarLokasi').value;
        const merk = document.getElementById('radarMerk').value;
        const stasiun = document.getElementById('radarStasiun').value;
        const bulan = document.getElementById('radarBulan').value;
        const tahun = document.getElementById('radarTahun').value;
        const nilai = document.getElementById('radarNilai').value;
        
        if (!lokasi || !merk || !stasiun || !bulan || !tahun || !nilai) {
            alert('Mohon lengkapi semua field');
            return;
        }
        
        // Di sini Anda bisa menambahkan logic untuk submit data ke server
        console.log('Data RADAR (' + currentMode + '):', { lokasi, merk, stasiun, bulan, tahun, nilai });
        
        // Close modal dan reset form
        radarModal.classList.add('hidden');
        this.reset();
        
        // Show success notification
        showSuccessNotification('', currentMode);
    });
    
    // Event listener untuk form submit General
    document.getElementById('generalForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const sites = document.getElementById('generalSites').value;
        const bulan = document.getElementById('generalBulan').value;
        const tahun = document.getElementById('generalTahun').value;
        const nilai = document.getElementById('generalNilai').value;
        
        if (!sites || !bulan || !tahun || !nilai) {
            alert('Mohon lengkapi semua field');
            return;
        }
        
        // Di sini Anda bisa menambahkan logic untuk submit data ke server
        console.log('Data ' + currentTab + ' (' + currentMode + '):', { sites, bulan, tahun, nilai });
        
        // Close modal dan reset form
        generalModal.classList.add('hidden');
        this.reset();
        
        // Show success notification
        showSuccessNotification('', currentMode);
    });
    
    // Close modal ketika klik di luar modal
    window.addEventListener('click', function(e) {
        if (e.target === radarModal) {
            radarModal.classList.add('hidden');
            document.getElementById('radarForm').reset();
        }
        if (e.target === generalModal) {
            generalModal.classList.add('hidden');
            document.getElementById('generalForm').reset();
        }
        if (e.target === successNotification) {
            successNotification.classList.add('hidden');
        }
    });
});
</script>
@endsection