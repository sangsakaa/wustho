<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Guru')

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Laporan Presensi Guru
                </h2>

                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                    {{ $tanggal->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <form action="/laporan-harian-guru" method="GET" class="flex gap-2">
                    <input type="date"
                        name="tanggal"
                        value="{{ $tanggal->toDateString() }}"
                        class="rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">

                    <button
                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium shadow-sm transition">
                        Filter
                    </button>
                </form>

                <a href="/sesi-presensi-guru"
                    class="px-4 py-2 rounded-xl bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium shadow-sm transition">
                    Kembali
                </a>

                <a href="/laporan-harian-guru"
                    class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium shadow-sm transition">
                    Refresh
                </a>
            </div>
        </div>
    </x-slot>

    @php
    $total = $Hadir + $Sakit + $Izin + $Alfa;
    @endphp

    <div class="p-4 md:p-6 bg-slate-100 dark:bg-slate-900 min-h-screen space-y-6">

        {{-- SUMMARY CARD --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- HADIR --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Hadir
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-emerald-600">
                            {{ $Hadir }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ number_format($presentasiHadir, 2) }}%
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-2xl">
                        ✅
                    </div>
                </div>
            </div>

            {{-- SAKIT --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Sakit
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-orange-500">
                            {{ $Sakit }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ number_format($presentasiSakit, 2) }}%
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl">
                        🤒
                    </div>
                </div>
            </div>

            {{-- IZIN --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Izin
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-yellow-500">
                            {{ $Izin }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ number_format($presentasiIzin, 2) }}%
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                        📄
                    </div>
                </div>
            </div>

            {{-- ALFA --}}
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Alfa
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-red-500">
                            {{ $Alfa }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ number_format($presentasiAlfa, 2) }}%
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                        ❌
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                            Data Presensi Guru
                        </h3>

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Total {{ $total }} data presensi guru
                        </p>
                    </div>
                </div>
            </div>

            {{-- TABLE CONTENT --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-center w-14">No</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Guru</th>
                            <th class="px-4 py-3 text-left">Kelas</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-left">Alasan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">

                        @forelse($laporanGuru as $list)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">

                            <td class="px-4 py-4 text-center text-slate-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="font-medium text-slate-700 dark:text-slate-200">
                                    {{ \Carbon\Carbon::parse($list->tanggal)->isoFormat('DD MMMM YYYY') }}
                                </div>

                                <div class="text-xs text-slate-400">
                                    {{ \Carbon\Carbon::parse($list->tanggal)->isoFormat('dddd') }}
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800 dark:text-white">
                                    {{ $list->nama_guru }}
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <span class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-medium">
                                    {{ $list->nama_kelas }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-center">

                                @if($list->keterangan == 'hadir')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                    Hadir
                                </span>

                                @elseif($list->keterangan == 'sakit')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">
                                    Sakit
                                </span>

                                @elseif($list->keterangan == 'izin')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                    Izin
                                </span>

                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                    Alfa
                                </span>
                                @endif

                            </td>

                            <td class="px-4 py-4 text-slate-600 dark:text-slate-300">
                                {{ $list->alasan ?: '-' }}
                            </td>

                        </tr>
                        @empty

                        <tr>
                            <td colspan="6" class="py-14 text-center">

                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-5xl mb-4">
                                        📋
                                    </div>

                                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-200">
                                        Belum Ada Data Presensi
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Tidak ditemukan data presensi guru pada tanggal ini
                                    </p>
                                </div>

                            </td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- NOTE --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-3xl p-5">

            <div class="flex items-start gap-4">

                <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-800 flex items-center justify-center text-2xl">
                    ℹ️
                </div>

                <div>
                    <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">
                        Informasi Laporan
                    </h3>

                    <ul class="space-y-2 text-sm text-blue-700 dark:text-blue-300">
                        <li>• Data presensi ditampilkan berdasarkan tanggal yang dipilih.</li>
                        <li>• Status presensi terdiri dari Hadir, Sakit, Izin, dan Alfa.</li>
                        <li>• Persentase dihitung berdasarkan total guru yang terjadwal.</li>
                        <li>• Jika alasan kosong maka tidak ada keterangan tambahan.</li>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>