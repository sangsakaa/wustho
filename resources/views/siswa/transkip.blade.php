<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Transkip Nilai')
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Transkip Nilai
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ $siswa->nama_siswa }}
        </p>
    </x-slot>

    @push('styles')
    <style media="print">
        body * {
            visibility: hidden;
        }
        #print-area, #print-area * {
            visibility: visible;
        }
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    </style>
    @endpush

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-6">

        {{-- BACK --}}
        <div class="no-print">
            <a href="/siswa"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke daftar siswa
            </a>
        </div>

        {{-- ACTION BAR --}}
        <div class="no-print flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <button onclick="printContent()"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-green-500 hover:from-emerald-500 hover:to-green-400 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/25">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Transkip
                </button>
            </div>

            <form action="/transkip/{{ $siswa->id }}" method="get" class="flex items-center gap-2">
                <div class="relative">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="cari" value="{{ request('cari') }}"
                        class="pl-9 pr-3 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm text-gray-700 dark:text-gray-300 placeholder-gray-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 w-48"
                        placeholder="Cari semester...">
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter
                </button>
                @if(request('cari'))
                <a href="/transkip/{{ $siswa->id }}"
                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition px-3 py-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
                @endif
            </form>
        </div>

        {{-- TRANSCRIPT CONTENT --}}
        <div id="print-area">
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
                {{-- HEADER --}}
                <div class="bg-gradient-to-r from-blue-600 to-sky-500 px-6 py-5 no-print">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-lg font-bold shadow-lg">
                            {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                        </div>
                        <div class="text-white">
                            <h3 class="text-lg font-bold">Kartu Hasil Tadris</h3>
                            <p class="text-blue-100 text-sm">{{ $siswa->nama_siswa }}</p>
                        </div>
                    </div>
                </div>

                {{-- PRINT HEADER --}}
                <div class="hidden print:block text-center py-4">
                    <h1 class="text-2xl font-bold uppercase underline">Kartu Hasil Tadris</h1>
                    <p class="text-sm mt-1">{{ $siswa->nama_siswa }}</p>
                </div>

                <div class="p-5">
                    {{-- TABLE --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-gray-800/50 text-slate-600 dark:text-slate-400 text-xs uppercase tracking-wider">
                                    <th class="px-4 py-3 text-center w-10">No</th>
                                    <th class="px-4 py-3 text-center">Periode</th>
                                    <th class="px-4 py-3 text-left">Nama Guru</th>
                                    <th class="px-4 py-3 text-center">Kelas</th>
                                    <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                                    <th class="px-4 py-3 text-center w-16">NH</th>
                                    <th class="px-4 py-3 text-center w-16">NU</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                                @forelse($nilai as $item)
                                <tr class="hover:bg-slate-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-4 py-3 text-center text-slate-500 text-xs">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-center text-slate-700 dark:text-slate-300 font-medium">{{ $item->periode }} {{ $item->ket_semester }}</td>
                                    <td class="px-4 py-3 text-slate-700 dark:text-slate-300">{{ $item->nama_guru ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center text-slate-700 dark:text-slate-300">{{ $item->nama_kelas }}</td>
                                    <td class="px-4 py-3 text-slate-800 dark:text-white font-medium">{{ $item->mapel ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center font-semibold {{ $item->nilai_harian ? 'text-emerald-600' : 'text-slate-400' }}">{{ $item->nilai_harian ?? '-' }}</td>
                                    <td class="px-4 py-3 text-center font-semibold {{ $item->nilai_ujian ? 'text-blue-600' : 'text-slate-400' }}">{{ $item->nilai_ujian ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center">
                                        <div class="flex flex-col items-center gap-2 text-slate-400">
                                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <p class="text-sm">Belum ada nilai transkip</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER --}}
                    <div class="mt-6 pt-4 border-t border-slate-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between text-sm text-slate-500 dark:text-slate-400">
                        <p class="print:hidden">Ket: NH = Nilai Harian, NU = Nilai Ujian</p>
                        <div class="text-right mt-2 sm:mt-0">
                            <p>Kedunglo, {{ \Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</p>
                            <p class="mt-8 font-semibold text-slate-700 dark:text-slate-300">Al Mudir / Kepala</p>
                            <p class="mt-1 text-slate-600 dark:text-slate-400">Muh. Bahrul Ulum, S.H</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script class="no-print">
        function printContent() {
            var printContents = document.getElementById('print-area').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = `
                <style>
                    body { font-family: serif; padding: 40px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #000; padding: 8px; text-align: center; font-size: 14px; }
                    th { background: #f1f5f9; font-weight: 600; text-transform: uppercase; font-size: 12px; }
                    .text-left { text-align: left; }
                    h1 { font-size: 24px; font-weight: 700; text-transform: uppercase; text-align: center; margin-bottom: 8px; text-decoration: underline; }
                    .text-right { text-align: right; }
                    .mt-8 { margin-top: 32px; }
                    .mt-2 { margin-top: 8px; }
                    .mt-6 { margin-top: 24px; }
                    .pt-4 { padding-top: 16px; }
                    .border-t { border-top: 1px solid #000; }
                </style>
                ${printContents}
            `;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
</x-app-layout>
