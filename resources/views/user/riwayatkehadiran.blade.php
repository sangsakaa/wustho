<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Riwayat Kehadiran')

        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                Riwayat Kehadiran
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-300">
                Detail kehadiran siswa
            </p>
        </div>
    </x-slot>

    <div class="p-3 space-y-4">

        {{-- PROFILE --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl">
            <div class="p-5 text-center">
                <h1 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-white">
                    {{ Str::limit($title->nama_siswa, 30) }}
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">
                    NIS: {{ $title->nis }}
                </p>
            </div>
        </div>

        {{-- INFO KELAS + PERIODE --}}
        @if($siswa->count())
        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">

                <div class="flex justify-between border-b pb-2">
                    <span class="font-medium text-slate-600 dark:text-slate-300">
                        Kelas
                    </span>
                    <span>
                        {{ $siswa->first()->nama_kelas }}
                    </span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="font-medium text-slate-600 dark:text-slate-300">
                        Periode
                    </span>
                    <span>
                        {{ $siswa->first()->periode }}
                        {{ $siswa->first()->ket_semester }}
                    </span>
                </div>

            </div>
        </div>
        @endif

        {{-- STATISTIK --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-emerald-500 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">Hadir</p>
                <h3 class="text-2xl font-bold mt-2">{{ $hadir }}</h3>
            </div>

            <div class="bg-amber-500 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">Izin</p>
                <h3 class="text-2xl font-bold mt-2">{{ $izin }}</h3>
            </div>

            <div class="bg-blue-500 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">Sakit</p>
                <h3 class="text-2xl font-bold mt-2">{{ $sakit }}</h3>
            </div>

            <div class="bg-red-500 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">Alfa</p>
                <h3 class="text-2xl font-bold mt-2">{{ $alfa }}</h3>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl">
            <div class="p-4 border-b">
                <h3 class="font-semibold text-slate-700 dark:text-white">
                    Detail Kehadiran
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-100 dark:bg-purple-600 text-slate-700 dark:text-white">
                            <th class="border p-3 w-16">No</th>
                            <th class="border p-3">Tanggal</th>
                            <th class="border p-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($siswa->count())
                        @foreach($siswa as $kelas)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800">
                            <td class="border p-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border p-2 text-center">
                                {{ date('d/m/Y', strtotime($kelas->tgl)) }}
                            </td>

                            <td class="border p-2 text-center capitalize">
                                @php
                                $color = match(strtolower($kelas->keterangan)) {
                                'hadir' => 'text-emerald-600',
                                'izin' => 'text-amber-600',
                                'sakit' => 'text-blue-600',
                                'alfa' => 'text-red-600',
                                default => 'text-slate-600'
                                };
                                @endphp

                                <span class="font-medium {{ $color }}">
                                    {{ $kelas->keterangan }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3"
                                class="border text-center py-6 text-red-500 font-semibold">
                                Presensi kehadiran tidak tersedia
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>