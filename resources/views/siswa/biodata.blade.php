<x-app-layout>
    <x-slot name="header">
        @section('title','Biodata: ' . $siswa->nama_siswa )
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Biodata Siswa
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ $siswa->nama_siswa }} — Dokumen biodata lengkap
        </p>
    </x-slot>

    <script>
        function printContent(el) {
            let fullbody = document.body.innerHTML;
            let printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-6">

        {{-- PROFILE HEADER --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-sky-500 px-6 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xl font-bold shadow-lg">
                        {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                    </div>
                    <div class="text-white">
                        <h3 class="text-lg font-bold">{{ $siswa->nama_siswa }}</h3>
                        <p class="text-blue-100 text-sm">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 grid sm:grid-cols-2 gap-3 text-sm">
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 w-32 shrink-0">Jenis Kelamin</span>
                    <span class="font-medium text-slate-800 dark:text-white">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 w-32 shrink-0">Asrama</span>
                    <span class="font-medium text-slate-800 dark:text-white">
                        @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama)
                        {{$siswa->asramaTerkhir->asramaSiswa->asrama->nama_asrama}}
                        @else
                        <span class="text-amber-600">Belum ada</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- BIODATA CARD --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
            {{-- ACTION --}}
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-end gap-2">
                <a href="/siswa/{{$siswa->id}}"
                    class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <button onclick="printContent('div1')"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Biodata
                </button>
            </div>

            {{-- PRINT AREA --}}
            <div id="div1" class="p-6">

                <h2 class="text-center text-xl font-bold border-b-2 border-slate-300 pb-3 mb-6 bg-slate-50 dark:bg-gray-800 py-3 rounded-lg uppercase tracking-wide">
                    BIODATA MURID
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 text-sm">
                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">1. Nomor Induk Murid</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-bold text-base">{{ $biodata->nis ?? 'Belum ada NIS' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">2. Nama Lengkap</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->nama_siswa }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">3. Jenis Kelamin</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3">{{ $biodata->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">4. Agama</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3">{{ $biodata->agama }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">5. Tempat, Tanggal Lahir</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->tempat_lahir }}, {{ $biodata->tanggal_lahir ? \Carbon\Carbon::parse($biodata->tanggal_lahir)->isoFormat('DD MMMM Y') : '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">6. Status Pengamal</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->status_pengamal ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">7. Jumlah Saudara</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3">{{ $biodata->jumlah_saudara ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">8. Anak Ke</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3">{{ $biodata->anak_ke ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">9. Status Anak</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->status_anak ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">10. Nama Ayah</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->nama_ayah ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 pl-8 font-medium bg-slate-50 dark:bg-gray-800/50">&nbsp;&nbsp; Pekerjaan</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->pekerjaan_ayah ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 pl-8 font-medium bg-slate-50 dark:bg-gray-800/50">&nbsp;&nbsp; No HP</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3">{{ $biodata->nomor_hp_ayah ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">11. Nama Ibu</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->nama_ibu ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 pl-8 font-medium bg-slate-50 dark:bg-gray-800/50">&nbsp;&nbsp; Pekerjaan</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->pekerjaan_ibu ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 pl-8 font-medium bg-slate-50 dark:bg-gray-800/50">&nbsp;&nbsp; No HP</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3">{{ $biodata->nomor_hp_ibu ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">12. Nama Wali</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->nama_ayah ?? '-' }}</div>

                    <div class="border border-slate-200 dark:border-slate-700 p-3 font-medium bg-slate-50 dark:bg-gray-800/50">13. Daerah Asal</div>
                    <div class="border border-slate-200 dark:border-slate-700 p-3 capitalize">{{ $biodata->kota_asal ?? '-' }}</div>
                </div>

                {{-- FOOTER --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 mt-8 gap-6">
                    <div class="flex justify-center items-start">
                        <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 w-32 h-40 flex items-center justify-center text-slate-400 text-sm rounded-lg bg-slate-50 dark:bg-gray-800/50">
                            Foto 3x4
                        </div>
                    </div>
                    <div class="text-left text-sm">
                        <p>Kedunglo, {{ $biodata->tanggal_lahir ? \Carbon\Carbon::parse($biodata->tanggal_lahir)->isoFormat('DD MMMM Y') : now()->isoFormat('DD MMMM Y') }}</p>
                        <p class="mt-1">Kepala Madrasah</p>
                        <div class="h-20"></div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>