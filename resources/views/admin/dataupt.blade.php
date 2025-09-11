@extends('admin.layouts.admin')

@section('title', 'Data UPT Management')

@section('content')

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="p-2">
        <h1 class="text-2xl font-bold mb-4">Data UPT</h1>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">Nama UPT</th>
                        <th class="border px-4 py-2">Provinsi</th>
                        <th class="border px-4 py-2">Latitude</th>
                        <th class="border px-4 py-2">Longitude</th>
                        <th class="border px-4 py-2">ASN L/P</th>
                        <th class="border px-4 py-2">PPNPN L/P</th>
                        <th class="border px-4 py-2">Alat</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($uptData as $upt)
                        <tr>
                            <td class="border px-4 py-2 font-medium">{{ $upt->nama_satker }}</td>
                            <td class="border px-2 py-2">{{ $upt->provinsi->nama_provinsi ?? '' }}</td>
                            <td class="border px-2 py-2">{{ $upt->latitude }}</td>
                            <td class="border px-2 py-2">{{ $upt->longitude }}</td>
                            <td class="border px-2 py-2 text-center">
                                {{ $upt->staf->asn_laki ?? 0 }} / {{ $upt->staf->asn_perempuan ?? 0 }}
                            </td>
                            <td class="border px-2 py-2 text-center">
                                {{ $upt->staf->ppnpn_laki ?? 0 }} / {{ $upt->staf->ppnpn_perempuan ?? 0 }}
                            </td>
                            <td class="border px-2 py-2">
                                @if ($upt->alat_satker && count($upt->alat_satker) > 0)
                                    @foreach ($upt->alat_satker as $alatSatker)
                                        <div class="text-xs mb-1">
                                            {{ $alatSatker->nama_alat ?? '' }} ({{ $alatSatker->jumlah }})
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-gray-400">Belum ada alat</span>
                                @endif
                            </td>
                            <td class="border px-2 py-2 text-center">
                                <button onclick="openEditModal({{ $upt->id }})"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded text-xs hover:bg-yellow-600 mb-1">
                                    Edit
                                </button>
                                <br>
                                <button onclick="openAlatModal({{ $upt->id }})"
                                    class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">
                                    + Alat
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-4 text-gray-500">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah UPT --}}
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-2/3 max-w-2xl p-6 max-h-screen overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Tambah Data UPT</h2>
            <form action="{{ route('admin.dataupt.store') }}" method="POST">
                @csrf

                {{-- Data UPT --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama UPT</label>
                        <input type="text" name="nama_satker" required class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Provinsi</label>
                        <select name="id_provinsi" required class="w-full border rounded p-2" id="provinsi_select">
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinsi as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" required class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" required class="w-full border rounded p-2">
                    </div>
                </div>

                {{-- Data Staf --}}
                <div class="border-t pt-4 mb-4">
                    <h3 class="text-lg font-semibold mb-3">Data Pegawai</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">ASN Laki-laki</label>
                            <input type="number" name="asn_laki" min="0" value="0"
                                class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ASN Perempuan</label>
                            <input type="number" name="asn_perempuan" min="0" value="0"
                                class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">PPNPN Laki-laki</label>
                            <input type="number" name="ppnpn_laki" min="0" value="0"
                                class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">PPNPN Perempuan</label>
                            <input type="number" name="ppnpn_perempuan" min="0" value="0"
                                class="w-full border rounded p-2">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('createModal')"
                        class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit UPT --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-2/3 max-w-2xl p-6 max-h-screen overflow-y-auto">
            <h2 class="text-xl font-bold mb-4">Edit Data UPT</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                {{-- Data UPT --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama UPT</label>
                        <input type="text" name="nama_satker" id="edit_nama_satker" required
                            class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Provinsi</label>
                        <select name="id_provinsi" id="edit_id_provinsi" required class="w-full border rounded p-2">
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinsi as $prov)
                                <option value="{{ $prov->id }}">{{ $prov->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" id="edit_latitude" required
                            class="w-full border rounded p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" id="edit_longitude" required
                            class="w-full border rounded p-2">
                    </div>
                </div>

                {{-- Data Staf --}}
                <div class="border-t pt-4 mb-4">
                    <h3 class="text-lg font-semibold mb-3">Data Pegawai</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">ASN Laki-laki</label>
                            <input type="number" name="asn_laki" id="edit_asn_laki" min="0"
                                class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">ASN Perempuan</label>
                            <input type="number" name="asn_perempuan" id="edit_asn_perempuan" min="0"
                                class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">PPNPN Laki-laki</label>
                            <input type="number" name="ppnpn_laki" id="edit_ppnpn_laki" min="0"
                                class="w-full border rounded p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">PPNPN Perempuan</label>
                            <input type="number" name="ppnpn_perempuan" id="edit_ppnpn_perempuan" min="0"
                                class="w-full border rounded p-2">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('editModal')"
                        class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Tambah Alat --}}
    <div id="alatModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-xl font-bold mb-4">Tambah Alat</h2>
            <form id="alatForm" method="POST" action="{{ route('admin.dataupt.store-alat') }}">
                @csrf
                <input type="hidden" name="id_satker" id="alat_id_satker">

                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Nama Alat</label>
                    <select name="id_alat" id="select_alat" required class="w-full border rounded p-2"
                        onchange="toggleNewAlat(this)">
                        <option value="">Pilih Alat</option>
                        @foreach ($alat as $a)
                            <option value="{{ $a->id }}">{{ $a->nama_alat }}</option>
                        @endforeach
                        <option value="new">+ Tambah Alat Baru</option>
                    </select>

                    <input type="text" name="nama_alat_baru" id="nama_alat_baru"
                        class="w-full border rounded p-2 mt-2 hidden" placeholder="Masukkan nama alat baru">
                </div>


                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Jumlah</label>
                    <input type="number" name="jumlah" min="1" value="1" required
                        class="w-full border rounded p-2">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('alatModal')"
                        class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function openEditModal(id) {
            // Fetch data UPT via AJAX
            fetch(`/admin/dataupt/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_nama_satker').value = data.nama_satker || '';
                    document.getElementById('edit_id_provinsi').value = data.id_provinsi || '';
                    document.getElementById('edit_latitude').value = data.latitude || '';
                    document.getElementById('edit_longitude').value = data.longitude || '';

                    // Data staf
                    document.getElementById('edit_asn_laki').value = data.staf?.asn_laki || 0;
                    document.getElementById('edit_asn_perempuan').value = data.staf?.asn_perempuan || 0;
                    document.getElementById('edit_ppnpn_laki').value = data.staf?.ppnpn_laki || 0;
                    document.getElementById('edit_ppnpn_perempuan').value = data.staf?.ppnpn_perempuan || 0;

                    document.getElementById('editForm').action = `{{ url('admin/dataupt') }}/${id}`;
                    document.getElementById('editModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data');
                });
        }

        function openAlatModal(id) {
            document.getElementById('alat_id_satker').value = id;
            document.getElementById('alatModal').classList.remove('hidden');
        }

        $(document).ready(function() {
            $('#provinsi_select, #edit_id_provinsi, #select_alat').select2({
                width: '100%',
                placeholder: function() {
                    return $(this).attr('placeholder') || "Pilih...";
                }
            });
        });

        function toggleNewAlat(select) {
            if (select.value === "new") {
                document.getElementById("nama_alat_baru").classList.remove("hidden");
                document.getElementById("nama_alat_baru").setAttribute("required", "true");
            } else {
                document.getElementById("nama_alat_baru").classList.add("hidden");
                document.getElementById("nama_alat_baru").removeAttribute("required");
            }
        }
    </script>
@endsection
