{{-- @extends('layouts.master')

@section('title', 'Data UPT')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Data UPT</h2>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-12">No</th>
                    <th class="px-4 py-3 text-left">Nama UPT</th>
                    <th class="px-4 py-3 text-left">Provinsi</th>
                    <th class="px-4 py-3 text-left">Lokasi (Koordinat)</th>
                    <th class="px-4 py-3 text-left">ASN (L/P)</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @foreach($upts as $index => $upt)
                <tr>
                    <td class="px-4 py-3">{{ $index+1 }}</td>
                    <td class="px-4 py-3">{{ $upt->nama }}</td>
                    <td class="px-4 py-3">{{ $upt->provinsi }}</td>
                    <td class="px-4 py-3">{{ $upt->lokasi }}</td>
                    <td class="px-4 py-3">
                        {{ $upt->asn_laki }} / {{ $upt->asn_perempuan }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button onclick="openModal({{ $upt->id }})"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                            Detail & Lokasi
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 relative">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">✖</button>
        <h3 id="modalTitle" class="text-xl font-bold mb-4 text-[#01377D]">Detail UPT</h3>
        <div id="modalContent" class="space-y-3 text-gray-700">
            <!-- konten detail akan dimasukkan lewat JS -->
        </div>
    </div>
</div>

<script>
    // Data detail UPT (dummy contoh, nanti ambil dari DB/Controller)
    const uptDetails = @json($upts);

    function openModal(id) {
        const upt = uptDetails.find(item => item.id === id);
        if (upt) {
            document.getElementById('modalTitle').innerText = upt.nama;

            document.getElementById('modalContent').innerHTML = `
                <p><b>Provinsi:</b> ${upt.provinsi}</p>
                <p><b>Lokasi:</b> ${upt.lokasi}</p>
                <p><b>ASN:</b> ${upt.asn_laki} Laki-laki / ${upt.asn_perempuan} Perempuan</p>
                <p><b>Jumlah PPNPN:</b> ${upt.ppnpn ?? '-'}</p>
                <p><b>Radar Cuaca:</b> ${upt.radar ?? '-'}</p>
                <p><b>AWS:</b> ${upt.aws ?? '-'}</p>
                <p><b>AWOS:</b> ${upt.awos ?? '-'}</p>
                <p><b>ARG:</b> ${upt.arg ?? '-'}</p>
                <p><b>AAWS:</b> ${upt.aaws ?? '-'}</p>
                <p><b>Seismograf:</b> ${upt.seismograf ?? '-'}</p>
                <p><b>Lainnya:</b> ${upt.lainnya ?? '-'}</p>
            `;

            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }
    }

    function closeModal() {
        document.getElementById('detailModal').classList.remove('flex');
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection --}}
