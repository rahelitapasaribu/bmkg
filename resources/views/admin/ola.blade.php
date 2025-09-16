@extends('admin.layouts.admin')

@section('title', 'OLA Management')

@section('content')

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="p-2">
        <h1 class="text-2xl font-bold mb-4">OLA - {{ $tab }}</h1>

        {{-- Tabs --}}
        <div class="border-b mb-4 flex space-x-6">
            <a href="{{ route('admin.ola.index', ['tab' => 'rekapan', 'year' => $year]) }}"
                class="pb-2 text-sm font-medium {{ $tab === 'rekapan' ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                Rekapan
            </a>
            @foreach (['AWOS', 'RADAR', 'AWS DIGI', 'AWS POSMET', 'AWS MARITIM', 'RASON', 'AAWS', 'AWS', 'ARG', 'InaTEWS'] as $t)
                <a href="{{ route('admin.ola.index', ['tab' => $t, 'year' => $year]) }}"
                    class="pb-2 text-sm font-medium {{ $tab === $t ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-blue-600' }}">
                    {{ $t }}
                </a>
            @endforeach
        </div>


        {{-- Tombol Aksi & Filter Tahun --}}
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-3">
                @if ($tab !== 'rekapan')
                    <button onclick="openModal('createModal')"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        + Tambah Data
                    </button>
                @endif
            </div>
            <form method="GET" action="{{ route('admin.ola.index') }}" class="flex space-x-2 mb-3">
                <input type="hidden" name="tab" value="{{ $tab }}">

                {{-- Pilih Tahun --}}
                <select name="year" onchange="this.form.submit()" class="border rounded p-1">
                    @foreach ($availableYears as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>

                {{-- Pilih Bulan (khusus tab Rekapan) --}}
                @if ($tab === 'rekapan')
                    <select name="month" onchange="this.form.submit()" class="border rounded p-1">
                        @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $nama)
                            <option value="{{ $num }}" {{ $num == $month ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </form>

        </div>

        @if ($tab === 'rekapan')
            <div class="grid grid-cols-1 gap-6">
                {{-- Meteorologi --}}
                <div class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b">
                        <h2 class="text-xl font-bold text-gray-700">Aloptama Meteorologi</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-sm">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-3 py-2 border">No</th>
                                    <th class="px-3 py-2 border">Nama Alat</th>
                                    <th class="px-3 py-2 border">Jumlah Site</th>
                                    <th class="px-3 py-2 border">% Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapanDetail['Meteorologi'] as $i => $alat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-3 py-2 text-center">{{ $i + 1 }}</td>
                                        <td class="border px-3 py-2">{{ $alat['nama'] }}</td>
                                        <td class="border px-3 py-2 text-center">{{ $alat['jumlah'] }}</td>
                                        <td class="border px-3 py-2 text-center font-semibold text-blue-600">
                                            {{ number_format($alat['persentase'], 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-blue-100 font-bold">
                                    <td colspan="3" class="px-3 py-2 border">Total Persentase Meteorologi</td>
                                    <td class="px-3 py-2 border text-center text-blue-700">
                                        {{ number_format($rekapan['Meteorologi'], 1) }}%
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Geofisika --}}
                <div class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b">
                        <h2 class="text-xl font-bold text-gray-700">Aloptama Geofisika</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-sm">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-3 py-2 border">No</th>
                                    <th class="px-3 py-2 border">Nama Alat</th>
                                    <th class="px-3 py-2 border">Jumlah Site</th>
                                    <th class="px-3 py-2 border">% Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapanDetail['Geofisika'] as $i => $alat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-3 py-2 text-center">{{ $i + 1 }}</td>
                                        <td class="border px-3 py-2">{{ $alat['nama'] }}</td>
                                        <td class="border px-3 py-2 text-center">{{ $alat['jumlah'] }}</td>
                                        <td class="border px-3 py-2 text-center font-semibold text-green-600">
                                            {{ number_format($alat['persentase'], 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-green-100 font-bold">
                                    <td colspan="3" class="px-3 py-2 border">Total Persentase Geofisika</td>
                                    <td class="px-3 py-2 border text-center text-green-700">
                                        {{ number_format($rekapan['Geofisika'], 1) }}%
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Klimatologi --}}
                <div class="bg-white rounded-lg shadow">
                    <div class="p-4 border-b">
                        <h2 class="text-xl font-bold text-gray-700">Aloptama Klimatologi</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-sm">
                            <thead class="bg-yellow-50">
                                <tr>
                                    <th class="px-3 py-2 border">No</th>
                                    <th class="px-3 py-2 border">Nama Alat</th>
                                    <th class="px-3 py-2 border">Jumlah Site</th>
                                    <th class="px-3 py-2 border">% Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekapanDetail['Klimatologi'] as $i => $alat)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-3 py-2 text-center">{{ $i + 1 }}</td>
                                        <td class="border px-3 py-2">{{ $alat['nama'] }}</td>
                                        <td class="border px-3 py-2 text-center">{{ $alat['jumlah'] }}</td>
                                        <td class="border px-3 py-2 text-center font-semibold text-yellow-600">
                                            {{ number_format($alat['persentase'], 1) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-yellow-100 font-bold">
                                    <td colspan="3" class="px-3 py-2 border">Total Persentase Klimatologi</td>
                                    <td class="px-3 py-2 border text-center text-yellow-700">
                                        {{ number_format($rekapan['Klimatologi'], 1) }}%
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Rata-rata keseluruhan --}}
                <div class="p-4 bg-gray-50 border rounded-lg text-center font-bold text-lg">
                    Persentase Rata-Rata Keseluruhan :
                    <span class="text-indigo-600">
                        {{ number_format(collect([$rekapan['Meteorologi'], $rekapan['Geofisika'], $rekapan['Klimatologi']])->avg(), 1) }}%
                    </span>
                </div>
            </div>
        @endif

        @if ($tab !== 'rekapan')
            {{-- Info jumlah site --}}
            <div class="mb-4">
                <span class="text-gray-700 font-semibold">Jumlah Site: </span>
                <span class="text-blue-600 font-bold">{{ $sites->count() }}</span>
            </div>

            {{-- Search --}}
            <div class="mb-4">
                <input type="text" id="searchInput" placeholder="Cari site..."
                    class="w-full md:w-1/3 border rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            {{-- Tabel Data --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm" id="sitesTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 w-12 text-center">No</th>
                            <th class="border px-4 py-2 w-56 text-left">{{ $tab === 'RADAR' ? 'Lokasi' : 'Nama Site' }}
                            </th>
                            <th class="border px-4 py-2 w-32">Merk</th>
                            <th class="border px-4 py-2 w-40">Tahun Pengadaan</th>
                            <th class="border px-4 py-2 w-40">Stasiun PIC</th>
                            @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'] as $bulan)
                                <th class="border px-2 py-2 w-12 text-center">{{ $bulan }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sites as $site)
                            <tr>
                                <td class="border px-4 py-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2 font-medium">{{ $site->nama_site }}</td>
                                <td class="border px-2 py-2">{{ $site->merk }}</td>
                                <td class="border px-2 py-2 text-center">{{ $site->tahun_pengadaan ?? '-' }}</td>
                                <td class="border px-2 py-2">{{ $site->satker->nama_satker ?? '' }}</td>

                                @foreach (range(1, 12) as $m)
                                    @php
                                        $perf = $performances
                                            ->where('site_id', $site->id)
                                            ->where('bulan', $m)
                                            ->where('tahun', $year)
                                            ->first();
                                    @endphp
                                    <td class="border px-2 py-2 text-center">
                                        @if ($perf)
                                            {{ $perf->persentase }}%
                                            <br>
                                            <button type="button"
                                                onclick="openEditModal({{ $perf->id }}, {{ $perf->site_id }}, {{ $perf->tahun }}, {{ $perf->bulan }}, {{ $perf->persentase }})"
                                                class="text-xs text-yellow-600 underline">
                                                Edit
                                            </button>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center p-4 text-gray-500">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

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
                    <select name="site_id" id="site_id" class="w-full border rounded p-2">
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->nama_site }}</option>
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
                        @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $nama)
                            <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Persentase</label>
                    <input type="number" step="0.01" name="percentage" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('createModal')"
                        class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
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
                    <select name="site_id" id="edit_site_id" class="w-full border rounded p-2" disabled>
                        @foreach ($sites as $site)
                            <option value="{{ $site->id }}">{{ $site->nama_site }}</option>
                        @endforeach
                    </select>
                    <!-- agar value tetap terkirim saat submit -->
                    <input type="hidden" name="site_id" id="hidden_edit_site_id">
                </div>

                <div class="mb-3">
                    <label class="block text-sm">Tahun</label>
                    <input type="number" name="year" id="edit_year" class="w-full border rounded p-2" readonly>
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Bulan</label>
                    <select name="month" id="edit_month" class="w-full border rounded p-2" disabled>
                        @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $num => $nama)
                            <option value="{{ $num }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="month" id="hidden_edit_month">
                </div>
                <div class="mb-3">
                    <label class="block text-sm">Persentase</label>
                    <input type="number" step="0.01" name="percentage" id="edit_percentage"
                        class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('editModal')"
                        class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
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

        function openEditModal(id, site_id, year, month, percentage, tahun_pengadaan) {
            document.getElementById('edit_id').value = id;

            document.getElementById('edit_site_id').value = site_id;
            document.getElementById('hidden_edit_site_id').value = site_id;

            document.getElementById('edit_year').value = year;

            document.getElementById('edit_month').value = month;
            document.getElementById('hidden_edit_month').value = month;

            document.getElementById('edit_percentage').value = percentage;

            document.getElementById('editForm').action = `/admin/ola/${id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        $(document).ready(function() {
            $('#site_id, #edit_site_id').select2({
                width: '100%',
                placeholder: "Pilih site...",
            });
        });

        // Live search filter
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                let value = $(this).val().toLowerCase();
                $("#sitesTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Select2
            $('#site_id, #edit_site_id').select2({
                width: '100%',
                placeholder: "Pilih site...",
            });
        });
    </script>
@endsection
