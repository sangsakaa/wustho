<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas')

        @php
        $first = $Datasesikelas->first();

        $total = $Datasesikelas->count();

        $done = $Datasesikelas->filter(function ($item) {
        return ($item->absensi_count ?? 0) >= ($item->peserta_count ?? 0)
        && ($item->peserta_count ?? 0) > 0;
        })->count();

        $notDone = $total - $done;
        $percent = $total ? round(($done / $total) * 100) : 0;
        @endphp

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">
                    Presensi Kelas
                </h2>
                <p class="text-sm text-gray-500">
                    {{ $tgl?->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-xs text-gray-500">Periode Aktif</p>
                <p class="font-semibold text-indigo-600">
                    {{ $first->periode ?? '-' }}
                    {{ $first->ket_semester ?? '' }}
                </p>
            </div>
        </div>
    </x-slot>

    {{-- SUMMARY --}}
    <div class="px-4 mt-4">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

            <div class="bg-white rounded-xl shadow border p-4 text-center">
                <p class="text-xs text-gray-500">Total Kelas</p>
                <p class="text-2xl font-bold text-blue-600">{{ $total }}</p>
            </div>

            <div class="bg-white rounded-xl shadow border p-4 text-center">
                <p class="text-xs text-gray-500">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $done }}</p>
            </div>

            <div class="bg-white rounded-xl shadow border p-4 text-center">
                <p class="text-xs text-gray-500">Belum Selesai</p>
                <p class="text-2xl font-bold text-red-600">{{ $notDone }}</p>
            </div>

            <div class="bg-white rounded-xl shadow border p-4 text-center">
                <p class="text-xs text-gray-500">Progress</p>
                <p class="text-2xl font-bold text-purple-600">{{ $percent }}%</p>
            </div>

        </div>
    </div>

    {{-- ACTION --}}
    <div class="px-4 mt-4">
        <div class="bg-white shadow rounded-xl p-4 flex flex-col sm:flex-row justify-between gap-3">

            <form action="/sesikelas" method="GET" class="flex gap-2 items-center">
                <input
                    type="date"
                    name="tgl"
                    value="{{ $tgl?->toDateString() }}"
                    class="border rounded-lg px-3 py-2 text-sm">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                    Filter
                </button>
            </form>

            <div class="flex flex-wrap gap-2">
                <a href="/sesikelas/rekap"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                    Rekap
                </a>

                <form action="/sesikelas" method="POST">
                    @csrf
                    <input type="hidden" name="tgl" value="{{ $tgl?->toDateString() }}">

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        + Buat Sesi
                    </button>
                </form>

                <button
                    type="button"
                    onclick="document.getElementById('bulkDeleteForm').submit()"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="px-4 mt-4">
        <div class="bg-white shadow rounded-xl overflow-hidden">

            <div class="px-4 py-3 border-b font-semibold text-gray-700">
                Daftar Sesi Kelas
            </div>

            <form id="bulkDeleteForm" action="/sesikelas/bulk-delete" method="POST">
                @csrf
                @method('DELETE')

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-100">
                            <tr class="text-center">
                                <th class="p-3 w-10">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th class="p-3">No</th>
                                <th class="p-3 text-left">Kelas</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($Datasesikelas as $sesi)

                            @php
                            $absen = $sesi->absensi_count ?? 0;
                            $peserta = $sesi->peserta_count ?? 0;
                            $full = $peserta > 0 && $absen >= $peserta;
                            @endphp

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-3 text-center">
                                    <input type="checkbox" class="row-check" name="ids[]" value="{{ $sesi->id }}">
                                </td>

                                <td class="p-3 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="p-3">
                                    <a href="{{ url('/absensikelas/' . $sesi->id) }}"
                                        class="text-blue-600 hover:underline font-medium">
                                        {{ $sesi->nama_kelas }}
                                    </a>
                                </td>

                                <td class="p-3 text-center">

                                    @if($peserta == 0)
                                    <span class="text-xs text-gray-500">Tidak ada peserta</span>

                                    @elseif($absen == 0)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                        ✖ Belum (0/{{ $peserta }})
                                    </span>

                                    @elseif($full)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                        ✔ Lengkap ({{ $absen }}/{{ $peserta }})
                                    </span>

                                    @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                        ⏳ Progress ({{ $absen }}/{{ $peserta }})
                                    </span>
                                    @endif

                                </td>

                                <td class="p-3">
                                    <div class="flex justify-center gap-2 flex-wrap">

                                        <form action="/sesikelas/{{ $sesi->id }}" method="POST"
                                            onsubmit="return confirm('Hapus sesi ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                Hapus
                                            </button>
                                        </form>

                                        <a href="/absensi/monitor/{{ $sesi->id }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                            Monitor
                                        </a>

                                    </div>
                                </td>

                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-8 text-gray-500">
                                    Tidak ada data sesi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        const checkAll = document.getElementById('checkAll');

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                document.querySelectorAll('.row-check').forEach(item => {
                    item.checked = this.checked;
                });
            });
        }
    </script>

</x-app-layout>