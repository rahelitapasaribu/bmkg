@extends('admin.layouts.admin')

@section('title', 'Data Site')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Data Site</h2>

        {{-- Dropdown Jenis Alat --}}
        <form method="GET" action="{{ route('admin.sites.index') }}" class="flex items-center gap-2 mb-4">
            <select name="jenis_alat_id" class="border rounded p-2">
                <option value="">-- Pilih Jenis Alat --</option>
                @foreach ($jenisAlat as $j)
                    <option value="{{ $j->id }}" {{ $selectedJenis == $j->id ? 'selected' : '' }}>
                        {{ $j->nama_jenis }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tampilkan</button>

            {{-- Tombol Tambah Jenis Alat --}}
            <button type="button" class="bg-green-600 text-white px-4 py-2 rounded"
                onclick="document.getElementById('modal-jenis').classList.remove('hidden')">
                + Tambah Jenis Alat
            </button>
        </form>

        {{-- Modal Tambah Jenis Alat --}}
        <div id="modal-jenis" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow w-96">
                <h3 class="text-lg font-semibold mb-3">Tambah Jenis Alat</h3>
                <form method="POST" action="{{ route('admin.sites.storeJenis') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm">Nama Jenis</label>
                        <input type="text" name="nama_jenis" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Punya Site?</label>
                        <select name="punya_site" class="w-full border rounded p-2" required>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modal-jenis').classList.add('hidden')"
                            class="px-3 py-1 bg-gray-400 text-white rounded">Batal</button>
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Tambah Site --}}
        <div id="modal-site" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow w-[500px]">
                <h3 class="text-lg font-semibold mb-3">Tambah Site</h3>
                <form method="POST" action="{{ route('admin.sites.store') }}">
                    @csrf
                    <input type="hidden" name="id_jenis_alat" value="{{ $selectedJenis }}"> {{-- otomatis ikut kategori terpilih --}}
                    <div class="mb-3">
                        <label class="block text-sm">Nama Site</label>
                        <input type="text" name="nama_site" class="w-full border rounded p-2" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Merk</label>
                        <input type="text" name="merk" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Tahun Pengadaan</label>
                        <input type="number" name="tahun_pengadaan" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Stasiun PIC</label>
                        <select name="id_satker" class="w-full border rounded p-2" required>
                            <option value="">-- Pilih UPT --</option>
                            @foreach (DB::table('satker')->orderBy('nama_satker')->get() as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_satker }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Kondisi</label>
                        <select name="kondisi_id" class="w-full border rounded p-2" required>
                            <option value="">-- Pilih Kondisi --</option>
                            @foreach (DB::table('kondisi_alat')->orderBy('nama_kondisi')->get() as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modal-site').classList.add('hidden')"
                            class="px-3 py-1 bg-gray-400 text-white rounded">Batal</button>
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit Site --}}
        <div id="modal-edit-site" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow w-[500px]">
                <h3 class="text-lg font-semibold mb-3">Edit Site</h3>
                <form id="form-edit-site" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="block text-sm">Nama Site</label>
                        <input type="text" id="edit_nama_site" name="nama_site" class="w-full border rounded p-2"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Merk</label>
                        <input type="text" id="edit_merk" name="merk" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Tahun Pengadaan</label>
                        <input type="number" id="edit_tahun" name="tahun_pengadaan" class="w-full border rounded p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Stasiun PIC</label>
                        <select id="edit_satker" name="id_satker" class="w-full border rounded p-2" required>
                            @foreach (DB::table('satker')->orderBy('nama_satker')->get() as $s)
                                <option value="{{ $s->id }}">{{ $s->nama_satker }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm">Kondisi</label>
                        <select id="edit_kondisi" name="kondisi_id" class="w-full border rounded p-2" required>
                            @foreach (DB::table('kondisi_alat')->orderBy('nama_kondisi')->get() as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button"
                            onclick="document.getElementById('modal-edit-site').classList.add('hidden')"
                            class="px-3 py-1 bg-gray-400 text-white rounded">Batal</button>
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tampilkan data --}}
        @if ($selectedJenis)
            @if ($punyaSite)
                {{-- Tabel Site --}}
                <div class="mt-6">
                    <div class="flex justify-between mb-3">
                        <h3 class="text-lg font-semibold">Daftar Site</h3>
                        <button type="button" class="bg-blue-600 text-white px-3 py-1 rounded"
                            onclick="document.getElementById('modal-site').classList.remove('hidden')">
                            + Tambah Site
                        </button>
                    </div>
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-1">Nama Site</th>
                                <th class="border px-2 py-1">Merk</th>
                                <th class="border px-2 py-1">Tahun</th>
                                <th class="border px-2 py-1">Stasiun PIC</th>
                                <th class="border px-2 py-1">Kondisi</th>
                                <th class="border px-2 py-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sites as $s)
                                <tr>
                                    <td class="border px-2 py-1">{{ $s->nama_site }}</td>
                                    <td class="border px-2 py-1">{{ $s->merk ?? '-' }}</td>
                                    <td class="border px-2 py-1">{{ $s->tahun_pengadaan ?? '-' }}</td>
                                    <td class="border px-2 py-1">{{ $s->stasiun_pic }}</td>
                                    <td class="border px-2 py-1">{{ $s->nama_kondisi }}</td>
                                    <td class="border px-2 py-1 text-center">
                                        <button type="button" class="text-blue-600 hover:underline btn-edit-site"
                                            data-site='@json($s)'>
                                            Edit
                                        </button>
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
            @else
                {{-- Rekap Alat (punya_site = 0) --}}
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">Rekap Alat per UPT</h3>

                    {{-- Tombol tambah data alat --}}
                    <div class="mb-3">
                        <button type="button" class="bg-green-600 text-white px-4 py-2 rounded"
                            onclick="document.getElementById('modal-tambah-alat').classList.remove('hidden')">
                            + Tambah Data Alat
                        </button>
                    </div>

                    {{-- Tabel data alat (langsung row per alat_satker) --}}
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-2 py-1">No</th>
                                <th class="border px-2 py-1">UPT</th>
                                <th class="border px-2 py-1">Jenis Alat</th>
                                <th class="border px-2 py-1">Kondisi</th>
                                <th class="border px-2 py-1">Jumlah</th>
                                <th class="border px-2 py-1">Total (semua kondisi)</th>
                                <th class="border px-2 py-1">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alatRekap as $satkerId => $list)
                                @php
                                    $namaSatker = $list->first()->nama_satker ?? '-';
                                    $total = $list->sum('jumlah');
                                @endphp

                                @foreach ($list as $alat)
                                    <tr>
                                        @if ($loop->first)
                                            <td class="border px-2 py-1 text-center" rowspan="{{ $list->count() }}">
                                                {{ $loop->parent->iteration }}
                                            </td>
                                            <td class="border px-2 py-1" rowspan="{{ $list->count() }}">
                                                {{ $namaSatker }}
                                            </td>
                                        @endif

                                        <td class="border px-2 py-1">{{ $alat->nama_jenis }}</td>
                                        <td class="border px-2 py-1">{{ $alat->nama_kondisi }}</td>
                                        <td class="border px-2 py-1 text-center">{{ $alat->jumlah }}</td>

                                        @if ($loop->first)
                                            <td class="border px-2 py-1 text-center font-semibold"
                                                rowspan="{{ $list->count() }}">
                                                {{ $total }}
                                            </td>
                                            <td class="border px-2 py-1 text-center" rowspan="{{ $list->count() }}">
                                                <button type="button" class="text-blue-600 hover:underline btn-edit-alat"
                                                    data-list='@json($list)'>
                                                    Edit
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-gray-500 py-2">Belum ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ---------- MODAL: Tambah Alat ---------- --}}
                <div id="modal-tambah-alat"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded shadow w-[480px]">
                        <h3 class="text-lg font-semibold mb-3">Tambah Data Alat</h3>
                        <form method="POST" action="{{ route('admin.sites.store-alat') }}">
                            @csrf
                            <input type="hidden" name="jenis_alat_id" value="{{ $selectedJenis }}">

                            <div class="mb-3">
                                <label class="block text-sm">Stasiun PIC (UPT)</label>
                                <select name="satker_id" class="w-full border rounded p-2" required>
                                    <option value="">-- Pilih UPT --</option>
                                    @foreach ($satkers as $st)
                                        <option value="{{ $st->id }}">{{ $st->nama_satker }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm">Kondisi</label>
                                <select name="kondisi_id" class="w-full border rounded p-2" required>
                                    <option value="">-- Pilih kondisi --</option>
                                    @foreach ($kondisi as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_kondisi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm">Jumlah</label>
                                <input type="number" name="jumlah" class="w-full border rounded p-2" min="1"
                                    value="1" required>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    onclick="document.getElementById('modal-tambah-alat').classList.add('hidden')"
                                    class="px-3 py-1 bg-gray-400 text-white rounded">Batal</button>
                                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ---------- MODAL: Edit Alat (semua kondisi dalam 1 UPT) ---------- --}}
                <div id="modal-edit-alat"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded shadow w-[600px]">
                        <h3 class="text-lg font-semibold mb-3">Edit Data Alat per Kondisi</h3>
                        <form id="form-edit-alat" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="jenis_alat_id" value="{{ $selectedJenis }}">
                            <input type="hidden" id="edit_satker_id" name="satker_id">

                            <table class="w-full border text-sm mb-3">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-2 py-1">Kondisi</th>
                                        <th class="border px-2 py-1">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="edit-alat-rows">
                                    {{-- diisi via JS --}}
                                </tbody>
                            </table>

                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    onclick="document.getElementById('modal-edit-alat').classList.add('hidden')"
                                    class="px-3 py-1 bg-gray-400 text-white rounded">Batal</button>
                                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <script>
        // Buka modal tambah site
        document.querySelectorAll('[data-modal-target="modal-site"]').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('modal-site').classList.remove('hidden');
            });
        });

        // Buka modal edit site (pakai data-site di button)
        document.querySelectorAll('.btn-edit-site').forEach(btn => {
            btn.addEventListener('click', () => {
                let site = JSON.parse(btn.dataset.site);

                // set action form update
                document.getElementById('form-edit-site').action = '/admin/sites/' + site.id;

                // isi field modal
                document.getElementById('edit_nama_site').value = site.nama_site ?? '';
                document.getElementById('edit_merk').value = site.merk ?? '';
                document.getElementById('edit_tahun').value = site.tahun_pengadaan ?? '';
                document.getElementById('edit_satker').value = site.id_satker ?? '';
                document.getElementById('edit_kondisi').value = site.kondisi_id ?? '';

                // tampilkan modal
                document.getElementById('modal-edit-site').classList.remove('hidden');
            });
        });

        document.querySelectorAll(".btn-edit-alat").forEach(btn => {
            btn.addEventListener("click", function() {
                let list = JSON.parse(this.dataset.list); // kumpulan kondisi per UPT

                if (!list.length) return;

                // ambil satker_id dari salah satu data
                document.getElementById("edit_satker_id").value = list[0].satker_id;

                // set action form (pakai satker_id + jenis_alat_id)
                let form = document.getElementById("form-edit-alat");
                form.action = `/admin/sites/update-alat/${list[0].jenis_alat_id}/${list[0].satker_id}`;

                // isi tabel kondisi di modal
                let tbody = document.getElementById("edit-alat-rows");
                tbody.innerHTML = "";
                list.forEach(item => {
                    tbody.innerHTML += `
                <tr>
                    <td class="border px-2 py-1">${item.nama_kondisi}
                        <input type="hidden" name="alat[${item.kondisi_id}][id]" value="${item.id}">
                        <input type="hidden" name="alat[${item.kondisi_id}][kondisi_id]" value="${item.kondisi_id}">
                    </td>
                    <td class="border px-2 py-1">
                        <input type="number" name="alat[${item.kondisi_id}][jumlah]" value="${item.jumlah}" min="0"
                            class="w-24 border rounded p-1 text-center">
                    </td>
                </tr>
            `;
                });

                // buka modal
                document.getElementById("modal-edit-alat").classList.remove("hidden");
            });
        });
    </script>
@endsection
