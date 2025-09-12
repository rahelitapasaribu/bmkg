@extends('admin.layouts.admin')

@section('title', 'Edit Data UPT')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Data UPT</h2>

    <form action="{{ route('admin.dataupt.update', $upt->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Satker --}}
        <div class="mb-4">
            <label for="nama_satker" class="block font-medium">Nama Satker</label>
            <input type="text" name="nama_satker" id="nama_satker" 
                   value="{{ old('nama_satker', $upt->nama_satker) }}" 
                   class="w-full border rounded px-3 py-2" required>
        </div>

        {{-- Provinsi --}}
        <div class="mb-4">
            <label for="id_provinsi" class="block font-medium">Provinsi</label>
            <select name="id_provinsi" id="id_provinsi" class="w-full border rounded px-3 py-2" required>
                @foreach($provinsi as $p)
                    <option value="{{ $p->id }}" 
                        {{ old('id_provinsi', $upt->id_provinsi) == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_provinsi }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Latitude --}}
        <div class="mb-4">
            <label for="latitude" class="block font-medium">Latitude</label>
            <input type="text" name="latitude" id="latitude" 
                   value="{{ old('latitude', $upt->latitude) }}" 
                   class="w-full border rounded px-3 py-2" required>
        </div>

        {{-- Longitude --}}
        <div class="mb-4">
            <label for="longitude" class="block font-medium">Longitude</label>
            <input type="text" name="longitude" id="longitude" 
                   value="{{ old('longitude', $upt->longitude) }}" 
                   class="w-full border rounded px-3 py-2" required>
        </div>

        {{-- Data Staf --}}
        <h3 class="text-lg font-semibold mt-6 mb-2">Data Staf</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block">ASN Laki</label>
                <input type="number" name="asn_laki" 
                       value="{{ old('asn_laki', $upt->asn_laki) }}" 
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">ASN Perempuan</label>
                <input type="number" name="asn_perempuan" 
                       value="{{ old('asn_perempuan', $upt->asn_perempuan) }}" 
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">PPNPN Laki</label>
                <input type="number" name="ppnpn_laki" 
                       value="{{ old('ppnpn_laki', $upt->ppnpn_laki) }}" 
                       class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">PPNPN Perempuan</label>
                <input type="number" name="ppnpn_perempuan" 
                       value="{{ old('ppnpn_perempuan', $upt->ppnpn_perempuan) }}" 
                       class="w-full border rounded px-3 py-2">
            </div>
        </div>

        {{-- Tombol --}}
        <div class="mt-6 flex justify-between">
            <a href="{{ route('admin.dataupt.index') }}" 
               class="px-4 py-2 bg-gray-400 text-white rounded">Kembali</a>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
