@extends('admin.layouts.admin')

@section('title', 'OLA Management')

@section('content')
    <div class="p-2">
        <h1 class="text-2xl font-bold mb-4">OLA - {{ $tab }}</h1>

        {{-- Tabs --}}
        <div class="border-b mb-4 flex space-x-6">
            @foreach (['AWOS', 'RADAR', 'AWS', 'AWS Synoptic', 'AWS Maritim', 'AAWS', 'ARG', 'InaTEWS'] as $t)
                <a href="{{ route('admin.ola.index', ['tab' => $t, 'year' => $year]) }}"
                   class="pb-2 text-sm font-medium {{ $tab === $t ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                    {{ $t }}
                </a>
            @endforeach
        </div>

        {{-- Tombol Aksi & Filter Tahun --}}
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-3">
                <button onclick="openModal('createModal')"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    + Tambah Data
                </button>
                <button onclick="openModal('editModal')"
                        class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                    ✏ Edit Data
                </button>
            </div>
            <form method="GET" action="{{ route('admin.ola.index', ['tab' => $tab]) }}">
                <select name="year" class="border rounded p-2" onchange="this.form.submit()">
                    @foreach ($availableYears ?? [] as $y)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 w-56 text-left">{{ $tab === 'RADAR' ? 'Lokasi' : 'Nama Site' }}</th>
                    <th class="border px-4 py-2 w-32">Merk</th>
                    <th class="border px-4 py-2 w-40">Stasiun PIC</th>
                    <th class="border px-4 py-2 w-32">Tahun Pengadaan</th>
                    @foreach (['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'] as $bulan)
                        <th class="border px-2 py-2 w-12 text-center">{{ $bulan }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @forelse ($sites as $site)
                    <tr>
                        <td class="border px-4 py-2 font-medium">{{ $site->name }}</td>
                        <td class="border px-2 py-2">{{ $site->merk }}</td>
                        <td class="border px-2 py-2">{{ $site->satker->name ?? '' }}</td>
                        <td class="border px-2 py-2">{{ $site->tahun_pengadaan ?? '' }}</td>
                        @foreach (range(1, 12) as $m)
                            @php
                                $perf = $performances
                                    ->where('site_id', $site->id)
                                    ->where('month', $m)
                                    ->where('year', $year)
                                    ->first();
                            @endphp
                            <td class="border px-2 py-2 text-center">
                                {{ $perf ? $perf->percentage.'%' : '' }}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="16" class="text-center p-4 text-gray-500">Tidak ada data</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-xl font-bold mb-4">Tambah Data OLA</h2>
            <form action="{{ route('admin.ola.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="mb-3">
                    <label class="block text-sm">Site</label>
                    <select name="site_id" class="w-full border rounded p-2">
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Tahun</label>
                    <input type="number" name="year" value="{{ $year }}" class="w-full border rounded p-2">
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Bulan</label>
                    <select name="month" class="w-full border rounded p-2">
                        @foreach ([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                   7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
                            <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Persentase</label>
                    <input type="number" step="0.01" name="percentage" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-xl font-bold mb-4">Edit Data OLA</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-3">
                    <label class="block text-sm">Site</label>
                    <select name="site_id" id="edit_site_id" class="w-full border rounded p-2">
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Tahun</label>
                    <input type="number" name="year" id="edit_year" class="w-full border rounded p-2">
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Bulan</label>
                    <select name="month" id="edit_month" class="w-full border rounded p-2">
                        @foreach ([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                   7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $nama)
                            <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Persentase</label>
                    <input type="number" step="0.01" name="percentage" id="edit_percentage" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        function openEditModal(id, site_id, year, month, percentage) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_site_id').value = site_id;
            document.getElementById('edit_year').value = year;
            document.getElementById('edit_month').value = month;
            document.getElementById('edit_percentage').value = percentage;
            document.getElementById('editForm').action = `/admin/ola/${id}`;
            openModal('editModal');
        }
    </script>
@endsection
