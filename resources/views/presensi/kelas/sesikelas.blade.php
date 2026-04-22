<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas')
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <h2 class="font-semibold text-lg sm:text-xl">
                Presensi Kelas
            </h2>
            <span class="text-sm text-gray-500">
                {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
    </x-slot>

    {{-- ACTION BAR --}}
    <div class="bg-white shadow-sm rounded p-3 mb-3 flex flex-wrap gap-2 justify-between items-center">

        {{-- FILTER --}}
        <form action="/sesikelas" method="get" class="flex gap-2 items-center">
            <input type="date" name="tgl"
                value="{{ $tgl->format('Y-m-d') }}"
                class="border px-2 py-1 rounded focus:ring focus:ring-blue-200">

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                Filter
            </button>
        </form>

        {{-- ACTION --}}
        <div class="flex gap-2">
            <a href="/sesikelas/rekap"
                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded">
                Rekap
            </a>

            <form action="/sesikelas" method="post">
                @csrf
                <input type="hidden" name="tgl" value="{{ $tgl->format('Y-m-d') }}">
                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                    + Buat Sesi
                </button>
            </form>
        </div>
    </div>

    {{-- ALERT --}}
    @foreach (['success' => 'green', 'delete' => 'red', 'update' => 'blue'] as $key => $color)
    @if (session($key))
    <div class="mb-2 px-3 py-2 rounded bg-{{ $color }}-500 text-white shadow">
        {{ session($key) }}
    </div>
    @endif
    @endforeach

    {{-- TABLE CARD --}}
    <div class=" p-4 bg-white shadow-sm rounded overflow-hidden">

        <div class="p-3 border-b font-semibold text-gray-700">
            Daftar Sesi Kelas
        </div>

        <div class="overflow-auto">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="border px-2 py-2 w-12">No</th>
                        <th class="border px-2 py-2">Tanggal</th>
                        <th class="border px-2 py-2">Kelas</th>
                        <th class="border px-2 py-2">Periode</th>
                        <th class="border px-2 py-2">Status</th>
                        <th class="border px-2 py-2 w-20">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($Datasesikelas as $sesi)
                    <tr class="hover:bg-gray-50 text-center">
                        <td class="border px-2 py-2">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border px-2 py-2">
                            {{ \Carbon\Carbon::parse($sesi->tgl)->isoFormat('DD MMM YYYY') }}
                        </td>

                        <td class="border px-2 py-2">
                            <a href="/absensikelas/{{ $sesi->id }}"
                                class="text-blue-600 hover:underline font-medium">
                                {{ $sesi->nama_kelas }}
                            </a>
                        </td>

                        <td class="border px-2 py-2">
                            {{ $sesi->periode }} {{ $sesi->ket_semester }}
                        </td>

                        {{-- STATUS --}}
                        <td class="border px-2 py-2">
                            @if ($sesi->absensi->count())
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                ✔ Sudah Diisi
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                ✖ Belum
                            </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="border px-2 py-2">
                            <form action="/sesikelas/{{ $sesi->id }}" method="post">
                                @csrf
                                @method('delete')

                                <button
                                    onclick="return confirm('Hapus sesi {{ $sesi->nama_kelas }} tanggal {{ \Carbon\Carbon::parse($sesi->tgl)->isoFormat('DD MMMM Y') }} ?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Tidak ada data sesi pada tanggal ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- INFO --}}
    <div class=" px-4">
        <div class=" mt-3 bg-blue-50 border-l-4 border-blue-400 p-4 text-sm text-gray-700 rounded">
            <p class="font-semibold mb-1">Informasi:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Data presensi digunakan untuk rekap kehadiran siswa.</li>
                <li>Pastikan absensi diisi setelah sesi dibuat.</li>
                <li>Jika belum ada siswa, tambahkan di menu kelas terlebih dahulu.</li>
            </ul>
        </div>
    </div>

</x-app-layout>