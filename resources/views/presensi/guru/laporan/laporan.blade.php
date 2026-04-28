<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Guru')
        <h2 class="font-semibold text-lg sm:text-xl leading-tight">
            Laporan Presensi Guru ({{ $tanggal->isoFormat('dddd, D MMMM YYYY') }})
        </h2>
    </x-slot>

    <div class="py-4 px-2 space-y-4">

        {{-- FILTER --}}
        <div class="flex flex-col sm:flex-row justify-between gap-2">
            <form action="/laporan-harian-guru" method="get" class="flex gap-2">
                <input type="date" name="tanggal"
                    class="border rounded px-2 py-1 dark:bg-dark-bg"
                    value="{{ $tanggal->toDateString() }}">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded">
                    Pilih
                </button>
            </form>

            <div class="flex gap-2">
                <a href="/sesi-presensi-guru"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-1 rounded">
                    Kembali
                </a>
                <a href="/laporan-harian-guru"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded">
                    Refresh
                </a>
            </div>
        </div>

        {{-- SUMMARY --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
            <div class="bg-green-100 p-3 rounded shadow">
                <p class="text-sm">Hadir</p>
                <p class="text-xl font-bold">{{ $Hadir }}</p>
                <p class="text-xs">{{ number_format($presentasiHadir,2) }}%</p>
            </div>
            <div class="bg-orange-100 p-3 rounded shadow">
                <p class="text-sm">Sakit</p>
                <p class="text-xl font-bold">{{ $Sakit }}</p>
                <p class="text-xs">{{ number_format($presentasiSakit,2) }}%</p>
            </div>
            <div class="bg-yellow-100 p-3 rounded shadow">
                <p class="text-sm">Izin</p>
                <p class="text-xl font-bold">{{ $Izin }}</p>
                <p class="text-xs">{{ number_format($presentasiIzin,2) }}%</p>
            </div>
            <div class="bg-red-100 p-3 rounded shadow">
                <p class="text-sm">Alfa</p>
                <p class="text-xl font-bold">{{ $Alfa }}</p>
                <p class="text-xs">{{ number_format($presentasiAlfa,2) }}%</p>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-auto bg-white dark:bg-dark-bg shadow rounded">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-200 dark:bg-purple-600 text-left">
                        <th class="px-2 py-2">No</th>
                        <th class="px-2">Tanggal</th>
                        <th class="px-2">Guru</th>
                        <th class="px-2">Kelas</th>
                        <th class="px-2">Status</th>
                        <th class="px-2">Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanGuru as $list)
                    <tr class="border-b">
                        <td class="px-2 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="px-2">
                            {{ \Carbon\Carbon::parse($list->tanggal)->isoFormat('dddd, DD MMMM Y') }}
                        </td>
                        <td class="px-2">{{ $list->nama_guru }}</td>
                        <td class="px-2">{{ $list->nama_kelas }}</td>

                        {{-- STATUS BADGE --}}
                        <td class="px-2">
                            @if($list->keterangan == 'hadir')
                            <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">Hadir</span>
                            @elseif($list->keterangan == 'sakit')
                            <span class="bg-orange-500 text-white px-2 py-1 rounded text-xs">Sakit</span>
                            @elseif($list->keterangan == 'izin')
                            <span class="bg-yellow-400 px-2 py-1 rounded text-xs">Izin</span>
                            @else
                            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs">Alfa</span>
                            @endif
                        </td>

                        <td class="px-2">{{ $list->alasan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Tidak ada data presensi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- NOTE --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <h3 class="font-semibold mb-2">Catatan:</h3>
            <ul class="list-disc ml-5 text-sm space-y-1">
                <li>Data presensi ditampilkan berdasarkan tanggal yang dipilih.</li>
                <li>Status presensi terdiri dari: Hadir, Sakit, Izin, dan Alfa.</li>
                <li>Persentase dihitung dari total guru yang terjadwal pada hari tersebut.</li>
                <li>Jika alasan kosong, berarti tidak ada keterangan tambahan dari guru.</li>
            </ul>
        </div>

    </div>
</x-app-layout>