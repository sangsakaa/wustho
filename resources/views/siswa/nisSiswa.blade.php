<x-app-layout>
    <x-slot name="header">
        @section('title', ' | NIS : '.$siswa->nama_siswa )
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Nomor Induk Siswa
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ $siswa->nama_siswa }}
        </p>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-5">

        {{-- INFO SISWA --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-sky-400 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Informasi Siswa</h3>
            </div>
            <div class="p-5">
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Nama</p>
                        <p class="font-semibold text-gray-800 dark:text-white uppercase">{{ $siswa->nama_siswa }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Tanggal Lahir</p>
                        <p class="text-gray-800 dark:text-white">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Jenis Kelamin</p>
                        <p class="text-gray-800 dark:text-white">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Asrama</p>
                        <p class="text-gray-800 dark:text-white">{{ optional($siswa->asramaTerkhir?->asramaSiswa?->asrama)->nama_asrama ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="flex flex-wrap gap-2">
            <a href="/siswa/{{ $siswa->id }}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            @role('super admin')
            <a href="/biodata/{{ $siswa->id }}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Biodata
            </a>
            @endrole
        </div>

        {{-- FORM NIS --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Tambah Nomor Induk Siswa</h3>
            </div>
            <div class="p-5">
                <form action="/nis/{{$siswa->id}}" method="POST">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{$siswa->id}}">
                    <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                        <input type="text" name="nis" placeholder="Contoh: 2023010001"
                            class="sm:col-span-2 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <select name="madrasah_diniyah"
                            class="border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="">Jenjang</option>
                            <option value="Ula">Ula</option>
                            <option value="Wustho">Wustho</option>
                            <option value="Ulya">Ulya</option>
                        </select>
                        <select name="nama_lembaga"
                            class="border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="Wahidiyah">Wahidiyah</option>
                        </select>
                        <input type="date" name="tanggal_masuk"
                            class="border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                    <div class="mt-4">
                        <button
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan NIS
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE NIS --}}
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-violet-400 flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Riwayat NIS</h3>
            </div>
            <div class="overflow-x-auto p-1">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-gray-800/50 text-slate-600 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2.5 text-center w-12">No</th>
                            <th class="px-4 py-2.5 text-center">NIS</th>
                            <th class="px-4 py-2.5 text-center">Lembaga</th>
                            <th class="px-4 py-2.5 text-center">Jenjang</th>
                            <th class="px-4 py-2.5 text-center">Masuk</th>
                            <th class="px-4 py-2.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                        @forelse($nis as $i => $nomor)
                        <tr class="hover:bg-slate-50 dark:hover:bg-gray-800/30 transition-colors even:bg-slate-50/50">
                            <td class="px-4 py-2.5 text-center text-slate-500">{{ $i+1 }}</td>
                            <td class="px-4 py-2.5 text-center">
                                <span class="font-mono text-sm font-bold text-slate-800 dark:text-white">{{ $nomor->nis }}</span>
                            </td>
                            <td class="px-4 py-2.5 text-center text-slate-700 dark:text-slate-300">{{ $nomor->nama_lembaga }}</td>
                            <td class="px-4 py-2.5 text-center">
                                <span class="bg-purple-50 text-purple-700 border border-purple-200 px-2 py-0.5 rounded-full text-xs font-medium">{{ $nomor->madrasah_diniyah }}</span>
                            </td>
                            <td class="px-4 py-2.5 text-center text-slate-700 dark:text-slate-300">{{ $nomor->tanggal_masuk ? \Carbon\Carbon::parse($nomor->tanggal_masuk)->isoFormat('D MMM Y') : '-' }}</td>
                            <td class="px-4 py-2.5">
                                <div class="flex justify-center gap-1.5">
                                    @role('super admin')
                                    <form action="/nis/{{$nomor->id}}" method="POST" onsubmit="return confirm('Hapus data ini?')" class="inline">
                                        @csrf
                                        @method('delete')
                                        <button class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                    @endrole
                                    <a href="/nis/{{$nomor->id}}/edit"
                                        class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                                    <span>Belum memiliki NIS</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- INFO --}}
        <div class="bg-gradient-to-r from-blue-50 to-sky-50 dark:from-blue-950/30 dark:to-sky-950/30 border border-blue-200/60 dark:border-blue-800/30 rounded-2xl p-4 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 p-2 rounded-xl shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z"/></svg>
                </div>
                <div class="text-sm">
                    <p class="font-semibold text-blue-700 dark:text-blue-400 mb-1">Keterangan</p>
                    <p class="text-gray-600 dark:text-gray-400">Mekanisme NIS: <strong>TAHUN MASUK - KODE MADRASAH - NOMOR URUT</strong></p>
                    <p class="text-gray-500 dark:text-gray-500 mt-0.5">Contoh: 202002001</p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>