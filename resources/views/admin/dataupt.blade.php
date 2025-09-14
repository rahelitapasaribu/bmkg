@extends('admin.layouts.admin')

@section('title', 'Data UPT')

@section('content')
    <div class="container fluid mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar UPT</h2>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Satker</th>
                    <th class="border border-gray-300 px-4 py-2">Provinsi</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uptData as $index => $upt)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $upt->nama_satker }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $upt->nama_provinsi }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('admin.dataupt.edit', $upt->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
