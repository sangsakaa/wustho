<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Siswa')
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Detail Siswa
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Informasi lengkap data siswa
        </p>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-6">

        {{-- BACK --}}
        <div>
            <a href="/siswa"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke daftar siswa
            </a>
        </div>

        {{-- PROFILE HEADER --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-sky-500 px-6 py-8">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                        {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                    </div>
                    <div class="text-white">
                        <h3 class="text-xl font-bold">{{ $siswa->nama_siswa }}</h3>
                        <p class="text-blue-100 text-sm mt-1">Santri {{ optional($siswa->NisTerakhir)->madrasah_diniyah ?? 'Madrasah Diniyah' }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white flex items-center gap-1.5">
                            <svg class="w-4 h-4 {{ $siswa->jenis_kelamin == 'L' ? 'text-blue-500' : 'text-pink-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white capitalize">
                            {{ strtolower($siswa->tempat_lahir) }},
                            {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Asrama</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">
                            @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama)
                            {{ $siswa->asramaTerkhir->asramaSiswa->asrama->nama_asrama }}
                            @else
                            <span class="text-amber-600">-</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Kota Asal</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $siswa->kota_asal }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="flex flex-wrap gap-2">
            <a href="/nis/{{ $siswa->id }}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                Nomor Induk
            </a>

            @role('super admin')
            <a href="/biodata/{{ $siswa->id }}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Biodata
            </a>

            <a href="/statuspengamal/{{ $siswa->id }}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Status Pengamal
            </a>

            <a href="/statusanak/{{ $siswa->id }}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Status Anak
            </a>
            @endrole
        </div>

        {{-- TABLE SECTION --}}
        <div class="space-y-6">

            {{-- GRID: KELAS & ASRAMA --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- KELAS --}}
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Riwayat Kelas</h3>
                    </div>
                    <div class="overflow-x-auto p-1">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 dark:bg-gray-800/50 text-slate-600 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-2.5 text-center w-12">No</th>
                                    <th class="px-4 py-2.5 text-center">Periode</th>
                                    <th class="px-4 py-2.5 text-center">Kelas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                                @forelse($pesertakelas as $kelas)
                                <tr class="hover:bg-slate-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-4 py-2.5 text-center text-slate-500 text-xs">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2.5 text-center text-slate-700 dark:text-slate-300">{{ $kelas->periode }} {{ $kelas->ket_semester }}</td>
                                    <td class="px-4 py-2.5 text-center font-medium text-slate-800 dark:text-white">{{ $kelas->nama_kelas }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-6 text-slate-400">Data tidak tersedia</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ASRAMA --}}
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-violet-400 flex items-center justify-center shadow-lg shadow-purple-500/20">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Riwayat Asrama</h3>
                    </div>
                    <div class="overflow-x-auto p-1">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 dark:bg-gray-800/50 text-slate-600 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-4 py-2.5 text-center w-12">No</th>
                                    <th class="px-4 py-2.5 text-center">Periode</th>
                                    <th class="px-4 py-2.5 text-center">Asrama</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                                @forelse($historiAsrama as $item)
                                <tr class="hover:bg-slate-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-4 py-2.5 text-center text-slate-500 text-xs">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2.5 text-center text-slate-700 dark:text-slate-300">{{ $item->periode }} {{ $item->ket_semester }}</td>
                                    <td class="px-4 py-2.5 text-center font-medium text-slate-800 dark:text-white">{{ $item->nama_asrama }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-6 text-slate-400">Data tidak tersedia</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- PRESENSI --}}
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Rekap Presensi</h3>
                    </div>
                    <div class="flex items-center gap-2">
                    <button onclick="printPresensi()"
                        class="inline-flex items-center gap-1.5 text-xs bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 px-3 py-2 rounded-xl font-medium transition-all shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak
                    </button>
                    <form method="get" class="flex items-center gap-2">
                        @if(request('filter_periode'))
                        <input type="hidden" name="filter_periode" value="">
                        @endif
                        <select name="filter_periode" onchange="this.form.submit()"
                            class="text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                            <option value="">Semua Periode</option>
                            @foreach($daftarPeriode as $p)
                            <option value="{{ $p }}" {{ request('filter_periode') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @if(request('filter_periode'))
                        <a href="{{ url()->current() }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition px-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                        @endif
                    </form>
                </div>
                <div class="overflow-x-auto p-1">
                    <table id="presensi-table" class="w-full text-sm">
                        <thead class="bg-slate-50 dark:bg-gray-800/50 text-slate-600 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-2.5 text-center border-b" rowspan="2">Periode</th>
                                <th class="px-4 py-2.5 text-center border-b" rowspan="2">Sesi</th>
                                <th class="px-4 py-2.5 text-center border-b" colspan="4">Keterangan</th>
                                <th class="px-4 py-2.5 text-center border-b" rowspan="2">% Hadir</th>
                                <th class="px-4 py-2.5 text-center border-b" rowspan="2">Status</th>
                            </tr>
                            <tr class="bg-slate-50 dark:bg-gray-800/50">
                                <th class="px-3 py-2 text-center text-emerald-600">H</th>
                                <th class="px-3 py-2 text-center text-orange-600">S</th>
                                <th class="px-3 py-2 text-center text-amber-600">I</th>
                                <th class="px-3 py-2 text-center text-red-600">A</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                            @foreach($PresensiKelas as $item)
                            @php
                            $pct = $item->presentase_kehadiran;
                            $statusClass = $pct >= 75 ? 'text-emerald-600' : 'text-red-600';
                            $statusLabel = $pct >= 75 ? 'M' : 'TM';
                            $barColor = $pct >= 80 ? 'bg-emerald-500' : ($pct >= 60 ? 'bg-amber-500' : 'bg-red-500');
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-gray-800/30 transition-colors text-center">
                                <td class="px-4 py-2.5 text-slate-700 dark:text-slate-300">{{ $item->periode }} {{ $item->ket_semester }}</td>
                                <td class="px-4 py-2.5 font-medium">{{ $item->count_sesikelas_id }}</td>
                                <td class="px-4 py-2.5 text-emerald-600 font-medium">{{ $item->hadir }}</td>
                                <td class="px-4 py-2.5 text-orange-600 font-medium">{{ $item->sakit }}</td>
                                <td class="px-4 py-2.5 text-amber-600 font-medium">{{ $item->izin }}</td>
                                <td class="px-4 py-2.5 text-red-600 font-medium">{{ $item->alfa }}</td>
                                <td class="px-4 py-2.5">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="font-bold text-slate-800 dark:text-white">{{ number_format($pct, 0) }}%</span>
                                        <div class="w-12 h-1.5 bg-slate-200 rounded-full overflow-hidden hidden sm:block">
                                            <div class="h-full rounded-full {{ $barColor }}" style="width: {{ min($pct, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-2.5">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $pct >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $pct >= 75 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <script>
        function printPresensi() {
            var tableHtml = document.querySelector('#presensi-table').outerHTML;
            var title = 'Rekap Presensi - {{ $siswa->nama_siswa }}';
            var win = window.open('', '', 'width=800,height=600');
            win.document.write(`
                <html><head><title>${title}</title>
                <style>
                    body { font-family: sans-serif; padding: 40px; }
                    h2 { text-align: center; margin-bottom: 24px; font-size: 18px; }
                    table { width: 100%; border-collapse: collapse; font-size: 13px; }
                    th, td { border: 1px solid #333; padding: 8px; text-align: center; }
                    th { background: #f1f5f9; font-weight: 600; }
                </style>
                </head><body>
                <h2>Rekap Presensi<br>{{ $siswa->nama_siswa }}</h2>
                ${tableHtml}
                </body></html>
            `);
            win.document.close();
            win.print();
        }
    </script>
</x-app-layout>