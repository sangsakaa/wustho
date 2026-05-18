<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas')

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center sm:text-left">
                Dashboard Presensi Kelas
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 space-y-6">

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="bg-white p-4 rounded-xl shadow border">
                <div class="text-gray-500 text-sm">Total Kelas</div>
                <div class="text-2xl font-bold">{{ $kelasMI->count() }}</div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow border">
                <div class="text-gray-500 text-sm">Total Siswa</div>
                <div class="text-2xl font-bold">
                    {{ $kelasMI->sum('total_peserta') }}
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow border">
                <div class="text-gray-500 text-sm">Sudah Presensi</div>
                <div class="text-2xl font-bold text-green-600">
                    {{ $kelasMI->sum('sudah_diisi') }}
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow border">
                <div class="text-gray-500 text-sm">Belum Presensi</div>
                <div class="text-2xl font-bold text-red-600">
                    {{ $kelasMI->sum('belum_diisi') }}
                </div>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow rounded-xl border overflow-hidden">

            <div class="p-4 border-b bg-gray-50">
                <h3 class="font-semibold text-gray-700">Daftar Kelas MI</h3>
                <p class="text-xs text-gray-500">Progress presensi setiap kelas</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">

                    <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Peserta</th>
                            <th class="px-4 py-3">Progress</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Izin/Sakit/Alfa</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach ($kelasMI as $item)
                        @php
                        $percent = $item->total_peserta > 0
                        ? round(($item->sudah_diisi / $item->total_peserta) * 100)
                        : 0;
                        @endphp

                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 py-3 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-semibold text-gray-800">
                                {{ $item->nama_kelas }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->total_peserta }}
                            </td>

                            {{-- PROGRESS BAR --}}
                            <td class="px-4 py-3">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full"
                                        style="width: {{ $percent }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $percent }}%
                                </div>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-4 py-3 text-center">
                                @if ($item->belum_diisi == 0 && $item->total_peserta > 0)
                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Lengkap
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                    Belum Lengkap
                                </span>
                                @endif
                            </td>

                            {{-- REKAP --}}
                            <td class="px-4 py-3 text-center text-xs">
                                <div>I: {{ $item->total_izin }}</div>
                                <div>S: {{ $item->total_sakit }}</div>
                                <div>A: {{ $item->total_alfa }}</div>
                            </td>

                            {{-- ACTION --}}
                            <td class="px-4 py-3 text-center">
                                <a href="/presensikelas/{{ $item->id }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs">
                                    Detail
                                </a>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </div>
</x-app-layout>