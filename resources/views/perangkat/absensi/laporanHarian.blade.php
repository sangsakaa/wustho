<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Harian Perangkat')
        <h2 class="font-semibold text-xl leading-tight">
            Laporan Harian Perangkat
        </h2>
    </x-slot>

    {{-- NAV --}}
    <div class="bg-white p-3 mb-3 flex justify-between items-center shadow-sm rounded">
        <a href="/sesi-perangkat" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md">
            ← Kembali
        </a>

        <div class="text-sm text-gray-600 font-medium">
            {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, DD MMMM Y') }}
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white p-3 mb-3 shadow-sm rounded">
        <form action="/laporan-harian-perangkat" method="get" class="flex gap-2 flex-wrap items-center">
            <input type="date" name="tanggal"
                value="{{ is_string($tanggal) ? $tanggal : $tanggal->format('Y-m-d') }}"
                class="border px-2 py-1 rounded focus:ring focus:ring-blue-200">

            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                Pilih
            </button>
        </form>
    </div>

    {{-- LEGEND --}}
    <div class="bg-white p-3 mb-3 text-sm flex flex-wrap gap-3 shadow-sm rounded">
        <span class="px-2 py-1 bg-green-500 text-white rounded">Hadir</span>
        <span class="px-2 py-1 bg-yellow-400 rounded">Izin</span>
        <span class="px-2 py-1 bg-orange-500 text-white rounded">Sakit</span>
        <span class="px-2 py-1 bg-red-600 text-white rounded">Alfa</span>
    </div>

    {{-- TABEL --}}
    <div class="bg-white p-3 shadow-sm rounded overflow-auto">
        <table class="w-full border text-sm border-collapse">
            <thead>
                <tr class="bg-gray-200 text-center">
                    <th class="border px-2 py-2 w-12">No</th>
                    <th class="border px-2 py-2">Nama Perangkat</th>
                    <th class="border px-2 py-2 w-32">Status</th>
                    <th class="border px-2 py-2">Alasan</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($laporanHarian as $data)
                @php
                $warna = match($data->keterangan) {
                'hadir' => 'bg-green-500 text-white',
                'izin' => 'bg-yellow-400',
                'sakit' => 'bg-orange-500 text-white',
                'alfa' => 'bg-red-600 text-white',
                default => ''
                };
                @endphp

                <tr class="hover:bg-gray-50">
                    <td class="border px-2 py-2 text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td class="border px-2 py-2">
                        {{ $data->nama_perangkat }}
                    </td>

                    <td class="border px-2 py-2 text-center font-semibold {{ $warna }}">
                        {{ ucfirst($data->keterangan) }}
                    </td>

                    <td class="border px-2 py-2">
                        {{ $data->alasan ?: '-' }}
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">
                        Tidak ada data pada tanggal ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-app-layout>