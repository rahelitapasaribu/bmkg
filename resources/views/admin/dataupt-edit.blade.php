@extends('admin.layouts.admin')

@section('title', 'Edit Data UPT')

@section('content')
    <div class="container fluid mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Data UPT</h2>

        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.dataupt.update', $upt->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Satker --}}
            <div class="mb-4">
                <label for="nama_satker" class="block font-medium">Nama Satker</label>
                <input type="text" name="nama_satker" id="nama_satker" value="{{ old('nama_satker', $upt->nama_satker) }}"
                    class="w-full border rounded px-3 py-2 @error('nama_satker') border-red-500 @enderror"
                    placeholder="Masukkan nama satker">
                @error('nama_satker')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Provinsi --}}
            <div class="mb-4">
                <label for="id_provinsi" class="block font-medium">Provinsi</label>
                <select name="id_provinsi" id="id_provinsi"
                    class="w-full border rounded px-3 py-2 @error('id_provinsi') border-red-500 @enderror">
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach ($provinsi as $p)
                        <option value="{{ $p->id }}"
                            {{ old('id_provinsi', $upt->id_provinsi) == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_provinsi }}
                        </option>
                    @endforeach
                </select>
                @error('id_provinsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Latitude --}}
            <div class="mb-4">
                <label for="latitude" class="block font-medium">Latitude</label>
                <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $upt->latitude) }}"
                    class="w-full border rounded px-3 py-2 @error('latitude') border-red-500 @enderror"
                    placeholder="-6.200000">
                @error('latitude')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Longitude --}}
            <div class="mb-4">
                <label for="longitude" class="block font-medium">Longitude</label>
                <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $upt->longitude) }}"
                    class="w-full border rounded px-3 py-2 @error('longitude') border-red-500 @enderror"
                    placeholder="106.816666">
                @error('longitude')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Data Staf --}}
            <h3 class="text-lg font-semibold mt-6 mb-2">Data Staf</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block">ASN Laki</label>
                    <input type="number" name="asn_laki" value="{{ old('asn_laki', $upt->asn_laki) }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block">ASN Perempuan</label>
                    <input type="number" name="asn_perempuan" value="{{ old('asn_perempuan', $upt->asn_perempuan) }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block">PPNPN Laki</label>
                    <input type="number" name="ppnpn_laki" value="{{ old('ppnpn_laki', $upt->ppnpn_laki) }}"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block">PPNPN Perempuan</label>
                    <input type="number" name="ppnpn_perempuan"
                        value="{{ old('ppnpn_perempuan', $upt->ppnpn_perempuan) }}"
                        class="w-full border rounded px-3 py-2">
                </div>
            </div>

            {{-- Data Alat --}}
            <div class="border-t pt-4 mt-6">
                <h3 class="text-lg font-semibold mb-3">Data Alat Satker</h3>
                <table class="w-full border mb-4 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">Jenis</th>
                            <th class="border px-2 py-1">Kondisi</th>
                            <th class="border px-2 py-1">Jumlah</th>
                            <th class="border px-2 py-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upt->alat_satker as $alat)
                            <tr>
                                <td class="border px-2 py-1">{{ $alat->nama_jenis }}</td>
                                <td class="border px-2 py-1">{{ $alat->nama_kondisi }}</td>
                                <td class="border px-2 py-1 text-center">{{ $alat->jumlah }}</td>
                                <td class="border px-2 py-1 text-center">
                                    <a href="{{ route('admin.sites.index', ['jenis_alat_id' => $alat->jenis_alat_id]) }}"
                                        class="text-blue-600 hover:underline text-sm">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-2">Belum ada alat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Data Site --}}
            <div class="border-t pt-4 mt-6">
                <h3 class="text-lg font-semibold mb-3">Data Site Satker</h3>
                <table class="w-full border mb-4 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-2 py-1">Nama Site</th>
                            <th class="border px-2 py-1">Merk</th>
                            <th class="border px-2 py-1">Tahun</th>
                            <th class="border px-2 py-1">Jenis Alat</th>
                            <th class="border px-2 py-1">Kondisi</th>
                            <th class="border px-2 py-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upt->site_satker as $site)
                            <tr>
                                <td class="border px-2 py-1">{{ $site->nama_site }}</td>
                                <td class="border px-2 py-1">{{ $site->merk ?? '-' }}</td>
                                <td class="border px-2 py-1">{{ $site->tahun_pengadaan ?? '-' }}</td>
                                <td class="border px-2 py-1">
                                    {{ $jenisAlat->firstWhere('id', $site->id_jenis_alat)->nama_jenis ?? '-' }}
                                </td>
                                <td class="border px-2 py-1">{{ $site->nama_kondisi ?? '-' }}</td>
                                <td class="border px-2 py-1 text-center">
                                    <a href="{{ route('admin.sites.index', ['jenis_alat_id' => $site->id_jenis_alat]) }}"
                                        class="text-blue-600 hover:underline text-sm">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-2">Belum ada site</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Tombol --}}
            <div class="mt-6 flex justify-between">
                <a href="{{ route('admin.dataupt.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
