<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data Siswa')

        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                Dashboard Detail Siswa
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-300">
                Informasi akademik dan riwayat siswa
            </p>
        </div>
    </x-slot>

    <div class="p-3 space-y-4">

        {{-- PROFILE --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl overflow-hidden">
            <div class="p-5 text-center">
                <h1 class="text-lg sm:text-xl font-bold text-slate-800 dark:text-white">
                    {{ Str::limit($title->nama_siswa, 30) }}
                </h1>
                <p class="text-sm text-slate-500 dark:text-slate-300 mt-1">
                    NIS: {{ $title->nis }}
                </p>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-sky-500 dark:bg-purple-600 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">Mata Pelajaran</p>
                <h3 class="text-2xl font-bold mt-2">{{ $jml }}</h3>
            </div>

            <div class="bg-emerald-500 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">IPK</p>
                <h3 class="text-2xl font-bold mt-2">
                    {{ number_format($b, 2, ',') }}
                </h3>
            </div>

            <div class="bg-amber-500 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">Status</p>
                <h3 class="text-lg font-semibold mt-2">Aktif</h3>
            </div>

            <div class="bg-rose-500 text-white rounded-2xl shadow p-4 text-center">
                <p class="text-xs uppercase tracking-wide">Semester</p>
                <h3 class="text-lg font-semibold mt-2">Berjalan</h3>
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            {{-- RIWAYAT ASRAMA --}}
            <div class="bg-white dark:bg-dark-bg shadow rounded-2xl">
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-slate-700 dark:text-white">
                        Riwayat Asrama
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[400px] text-sm">
                        <thead>
                            <tr class="bg-slate-100 dark:bg-purple-600 text-slate-700 dark:text-white">
                                <th class="p-3 border">No</th>
                                <th class="p-3 border">Periode</th>
                                <th class="p-3 border">Asrama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Asrama as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800">
                                <td class="border p-2 text-center">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="border p-2 text-center">
                                    {{ $user->periode }} {{ $user->ket_semester }}
                                </td>
                                <td class="border p-2 text-center">
                                    {{ $user->nama_asrama }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- RIWAYAT PRESENSI --}}
            <div class="bg-white dark:bg-dark-bg shadow rounded-2xl">
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-slate-700 dark:text-white">
                        Riwayat Kehadiran
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[500px] text-sm">
                        <thead>
                            <tr class="bg-slate-100 dark:bg-purple-600 text-slate-700 dark:text-white">
                                <th class="p-3 border">Periode</th>
                                <th class="p-3 border">Hadir</th>
                                <th class="p-3 border">Alfa</th>
                                <th class="p-3 border">Sakit</th>
                                <th class="p-3 border">Izin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presensi as $data)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800">
                                <td class="border p-2 text-center">
                                    {{ $data->periode }} {{ $data->ket_semester }}
                                </td>
                                <td class="border p-2 text-center">{{ $data->hadir }}</td>
                                <td class="border p-2 text-center">{{ $data->alfa }}</td>
                                <td class="border p-2 text-center">{{ $data->sakit }}</td>
                                <td class="border p-2 text-center">{{ $data->izin }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KETERANGAN --}}
        <div class="bg-sky-500 dark:bg-purple-600 text-white rounded-2xl shadow">
            <div class="p-4">
                <h3 class="font-bold mb-2">Keterangan</h3>
                <ul class="space-y-1 text-sm">
                    <li>1. MP = Mata Pelajaran</li>
                    <li>2. IPK = Indeks Prestasi Kumulatif</li>
                </ul>
            </div>
        </div>

    </div>
</x-app-layout>