<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Bulanan Perangkat ' . \Carbon\Carbon::parse($bulan)->isoFormat('MMMM Y'))
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Laporan Bulanan Perangkat
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ \Carbon\Carbon::parse($bulan)->isoFormat('MMMM Y') }}
        </p>
    </x-slot>

    <style>
        @media print {
            body { margin: 0; padding: 0; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            body * { visibility: hidden; }
            #div1, #div1 * { visibility: visible; }
            #div1 { position: absolute; top: 0; left: 0; width: 100%; }
            table { page-break-inside: auto; border-collapse: collapse; }
            tr { page-break-inside: avoid; }
            thead { display: table-header-group; }
            @page { size: A4; margin: 1mm 1mm; }
            img { display: block !important; max-width: 100% !important; }
            .no-print { display: none !important; }
        }
    </style>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-5">

        {{-- HEADER ACTION --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl p-4 no-print">
            <div class="flex flex-col sm:flex-row justify-between gap-3">
                <div class="flex gap-2">
                    <a href="/sesi-perangkat"
                        class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                    <button onclick="window.print()"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak
                    </button>
                </div>

                <div>
                    <form action="/laporan-Bulanan-perangkat" method="get" class="flex gap-2">
                        <input type="month" name="bulan" value="{{ $bulan->format('Y-m') }}"
                            class="border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-xl text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <button
                            class="inline-flex items-center gap-1.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20">
                            Pilih
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRINT AREA --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
            <div id="div1" class="p-6 sm:p-8">

                {{-- KOP --}}
                <div class="text-center text-green-700 dark:text-green-400">
                    <div class="flex items-center justify-center gap-4">
                        <img src="{{ asset('asset/images/logo.png') }}" width="80" class="shrink-0">
                        <div>
                            <p class="uppercase text-sm sm:text-lg font-medium">Departemen Pendidikan Diniyah Wahidiyah</p>
                            <p class="uppercase text-xl sm:text-2xl font-bold">Madrasah Diniyah Wustho Wahidiyah</p>
                            <p class="uppercase text-xs sm:text-sm font-semibold">
                                Tahun Pelajaran {{ $periode->periode }} {{ $periode->ket_semester }}
                            </p>
                        </div>
                    </div>

                    <hr class="border-2 border-green-700 dark:border-green-500 mt-4 mb-3">
                    <p class="uppercase font-bold text-sm sm:text-base">
                        Laporan Presensi Perangkat Bulan {{ \Carbon\Carbon::parse($bulan)->isoFormat('MMMM') }}
                    </p>
                </div>

                {{-- TABEL --}}
                <div class="overflow-auto mt-6">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-center w-12">No</th>
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-left">Nama Perangkat</th>
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-center">Sesi/<br>Jml Hari</th>
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-center">Alfa</th>
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-center">Hadir</th>
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-center">Izin</th>
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-center">Sakit</th>
                                <th class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-center">% Hadir</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($laporanBulanan->groupBy('nama_perangkat') as $nama => $items)
                            @php
                            $total = $items->sum('total');
                            $hadir = $items->sum('jumlah_hadir');
                            $alfa = $items->sum('jumlah_alfa');
                            $izin = $items->sum('jumlah_izin');
                            $sakit = $items->sum('jumlah_sakit');
                            $persen = $total > 0 ? round(($hadir * 100) / $total) : 0;
                            $barColor = $persen >= 80 ? 'bg-green-500' : ($persen >= 60 ? 'bg-amber-500' : 'bg-red-500');
                            @endphp

                            <tr class="text-center even:bg-green-50/50 dark:even:bg-green-900/10 hover:bg-green-50/80 dark:hover:bg-green-900/20 transition-colors">
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-slate-500">{{ $loop->iteration }}</td>
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-left font-medium text-slate-800 dark:text-white">{{ $nama }}</td>
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5">{{ $total }}</td>
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-red-600 font-medium">{{ $alfa }}</td>
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-emerald-600 font-medium">{{ $hadir }}</td>
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-amber-600 font-medium">{{ $izin }}</td>
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5 text-orange-600 font-medium">{{ $sakit }}</td>
                                <td class="border border-green-200 dark:border-green-700 px-3 py-2.5">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="font-bold text-slate-800 dark:text-white">{{ $persen }}%</span>
                                        <div class="w-12 h-1.5 bg-slate-200 rounded-full overflow-hidden hidden sm:block">
                                            <div class="h-full rounded-full {{ $barColor }}" style="width: {{ $persen }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- TTD --}}
                <div class="mt-12 flex justify-end">
                    <div class="text-center text-green-800 dark:text-green-400 text-sm">
                        <p>Kedunglo, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
                        <p class="font-semibold mt-1">Al Mudir / Kepala</p>
                        <br><br><br>
                        @if($kelasmi->jenjang == "Wustho")
                        <p class="font-semibold underline">{{$kepalaSekolah->nama_perangkat}}</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

</x-app-layout>