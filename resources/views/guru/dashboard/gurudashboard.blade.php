<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Guru
        </h2>
    </x-slot>

    <div class="py-4 px-4 space-y-4">

        <!-- INFO GURU -->
        <div class="bg-white dark:bg-dark-bg shadow rounded-xl overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    Informasi Guru
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-500">NIG</span>
                        <p class="font-semibold">{{ $title->nig }}</p>
                    </div>

                    <div>
                        <span class="font-medium text-gray-500">Jenjang</span>
                        <p class="font-semibold">{{ $title->jenjang }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <span class="font-medium text-gray-500">Nama Guru</span>
                        <p class="font-semibold">{{ $title->nama_guru }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAPEL -->
        <div class="bg-white dark:bg-dark-bg shadow rounded-xl overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    Mata Pelajaran & Progress
                </h3>

                @forelse($mapelGuru as $list)
                @php
                $peserta = max($list->jumlah_peserta_kelas, 1);
                $harian = number_format(($list->jumlah_nilai_harian / $peserta) * 100, 0);
                $ujian = number_format(($list->jumlah_nilai_ujian / $peserta) * 100, 0);
                @endphp

                <div class="border rounded-xl p-4 mb-4">
                    <h4 class="font-semibold text-gray-800 mb-3">
                        {{ $loop->iteration }}.
                        {{ $list->nama_kelas }} -
                        {{ $list->mapel }}
                        ({{ $list->periode }} {{ $list->ket_semester }})
                    </h4>

                    <!-- Nilai Harian -->
                    <div class="flex justify-between items-center py-2 border-b">
                        <span>Nilai Harian</span>
                        <span class="flex items-center gap-2">
                            {{ $harian }}%

                            @if ($list->jumlah_nilai_harian == $list->jumlah_peserta_kelas)
                            <span class="text-green-600">✔</span>
                            @else
                            <span class="text-red-600">✘</span>
                            @endif
                        </span>
                    </div>

                    <!-- Nilai Ujian -->
                    <div class="flex justify-between items-center py-2">
                        <span>Nilai Ujian</span>
                        <span class="flex items-center gap-2">
                            {{ $ujian }}%

                            @if ($list->jumlah_nilai_ujian == $list->jumlah_peserta_kelas)
                            <span class="text-green-600">✔</span>
                            @else
                            <span class="text-red-600">✘</span>
                            @endif
                        </span>
                    </div>
                </div>

                @empty
                <div class="p-4 rounded-lg bg-red-50 text-red-600">
                    Tidak ada proses penilaian dan pembelajaran
                </div>
                @endforelse
            </div>
        </div>

        <!-- KETERANGAN -->
        <div class="bg-sky-500 text-white rounded-xl shadow overflow-hidden">
            <div class="p-4">
                <h3 class="font-bold uppercase mb-2">Keterangan</h3>
                <ul class="text-sm space-y-1">
                    <li>1. MP : Mata Pelajaran</li>
                    <li>2. IPK : Indeks Prestasi Kumulatif</li>
                </ul>
            </div>
        </div>

    </div>
</x-app-layout>