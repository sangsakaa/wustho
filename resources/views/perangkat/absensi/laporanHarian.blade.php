<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Harian Perangkat')
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Laporan Harian Perangkat
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, DD MMMM Y') }}
        </p>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-5">

        {{-- NAV --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <a href="/sesi-perangkat"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <form action="/laporan-harian-perangkat" method="get" class="flex gap-2 flex-1 sm:flex-none">
                    <input type="date" name="tanggal"
                        value="{{ is_string($tanggal) ? $tanggal : $tanggal->format('Y-m-d') }}"
                        class="border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-xl text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">

                    <button
                        class="inline-flex items-center gap-1.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Pilih
                    </button>
                </form>
            </div>
        </div>

        {{-- LEGEND --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl p-4">
            <div class="flex flex-wrap gap-3 text-sm">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full font-medium">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                    Hadir
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-full font-medium">
                    <span class="w-2 h-2 bg-amber-400 rounded-full"></span>
                    Izin
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-orange-50 text-orange-700 border border-orange-200 rounded-full font-medium">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                    Sakit
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 rounded-full font-medium">
                    <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                    Alfa
                </span>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-slate-50 to-slate-100 text-xs uppercase text-slate-600 tracking-wider">
                        <tr>
                            <th class="px-4 py-3.5 text-center w-12">No</th>
                            <th class="px-4 py-3.5 text-left">Nama Perangkat</th>
                            <th class="px-4 py-3.5 text-center">Status</th>
                            <th class="px-4 py-3.5 text-left">Alasan</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($laporanHarian as $data)
                        @php
                        $warna = match($data->keterangan) {
                        'hadir' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'izin' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'sakit' => 'bg-orange-50 text-orange-700 border-orange-200',
                        'alfa' => 'bg-red-50 text-red-700 border-red-200',
                        default => 'bg-slate-50 text-slate-600 border-slate-200'
                        };
                        $dot = match($data->keterangan) {
                        'hadir' => 'bg-emerald-500',
                        'izin' => 'bg-amber-400',
                        'sakit' => 'bg-orange-500',
                        'alfa' => 'bg-red-500',
                        default => 'bg-slate-400'
                        };
                        @endphp

                        <tr class="hover:bg-slate-50 transition-colors duration-150 even:bg-slate-50/50">
                            <td class="px-4 py-3.5 text-center text-slate-500 text-xs">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3.5 font-medium text-slate-800 dark:text-white">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-sky-400 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                        {{ strtoupper(substr($data->nama_perangkat, 0, 1)) }}
                                    </div>
                                    {{ $data->nama_perangkat }}
                                </div>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $warna }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dot }}"></span>
                                    {{ ucfirst($data->keterangan) }}
                                </span>
                            </td>

                            <td class="px-4 py-3.5 text-slate-600 dark:text-slate-400">
                                {{ $data->alasan ?: '-' }}
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Tidak ada data pada tanggal ini</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</x-app-layout>