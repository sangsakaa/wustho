<div class="space-y-5">

    {{-- ACTION BAR --}}
    <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl p-4 sm:p-5">

        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

            {{-- LEFT --}}
            <div class="flex flex-col lg:flex-row gap-3 w-full">

                {{-- BUTTONS --}}
                <div class="flex flex-col sm:flex-row gap-2">

                    <a href="/addsiswa"
                        class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-600/30 whitespace-nowrap">

                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Tambah Siswa
                    </a>

                    <a href="/export-siswa"
                        class="inline-flex items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Template Excel
                    </a>

                </div>

                {{-- FILTER --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 flex-1">

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search"
                            wire:model.live.debounce.500ms="search"
                            placeholder="Cari siswa..."
                            class="w-full pl-9 pr-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    <select wire:model.live="perPage"
                        class="border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="10">10 / halaman</option>
                        <option value="25">25 / halaman</option>
                        <option value="50">50 / halaman</option>
                        <option value="100">100 / halaman</option>
                        <option value="100">200 / halaman</option>
                    </select>

                    <select wire:model.live="angkatan"
                        class="border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        <option value="">Semua Angkatan</option>
                        @foreach($angkatanList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            {{-- IMPORT --}}
            <form action="/import-siswa" method="post" enctype="multipart/form-data"
                class="flex flex-col sm:flex-row gap-2 w-full xl:w-auto">
                @csrf
                <input type="file" name="file" id="fileInput"
                    class="text-sm border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 w-full bg-white dark:bg-gray-800 file:mr-2 file:px-3 file:py-1 file:border-0 file:bg-blue-50 file:text-blue-700 file:rounded-lg file:text-xs file:font-medium hover:file:bg-blue-100 transition">
                <button type="submit" id="submitButton" disabled
                    class="bg-gray-400 text-white px-5 py-2.5 rounded-xl text-sm font-medium cursor-not-allowed transition-all whitespace-nowrap">
                    Import
                </button>
            </form>

        </div>
    </div>

    {{-- STATS ROW --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-sky-400 flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Siswa</p>
                    <p class="text-xl font-bold text-slate-800 dark:text-white">{{ $data->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Per Halaman</p>
                    <p class="text-xl font-bold text-emerald-600">{{ $perPage }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-violet-400 flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Angkatan</p>
                    <p class="text-xl font-bold text-purple-600">{{ $angkatan ?: 'Semua' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center shadow-lg shadow-amber-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pencarian</p>
                    <p class="text-xl font-bold text-amber-600 truncate max-w-[80px]">{{ $search ?: 'Semua' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-[1100px] w-full text-sm">

                {{-- HEAD --}}
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100 text-slate-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3.5 text-center w-12">No</th>
                        <th class="px-4 py-3.5 text-center">NIS</th>
                        <th class="px-4 py-3.5 text-left">
                            <button wire:click="sortBy('nama_siswa')" class="flex items-center gap-1.5 hover:text-blue-600 transition">
                                Nama
                                <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 3l-3 3h6l-3-3zm0 14l3-3H7l3 3z" />
                                </svg>
                            </button>
                        </th>
                        <th class="px-4 py-3.5 text-center">JK</th>
                        <th class="px-4 py-3.5 text-center">Asrama</th>
                        <th class="px-4 py-3.5 text-center">Kelas</th>
                        <th class="px-4 py-3.5 text-center">Jenjang</th>
                        <th class="px-4 py-3.5 text-center">Angkatan</th>
                        <th class="px-4 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-slate-100">
                    @forelse ($data as $peserta)
                    <tr class="hover:bg-slate-50 transition-colors duration-150 even:bg-slate-50/50 text-xs sm:text-sm">

                        <td class="px-4 py-3.5 text-center text-slate-500">{{ $loop->iteration }}</td>

                        <td class="px-4 py-3.5 text-center">
                            <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded">
                                {{ $peserta->NisTerakhir->nis ?? '-' }}
                            </span>
                        </td>

                        <td class="px-4 py-3.5 capitalize font-medium text-slate-800 dark:text-white">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-sky-400 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($peserta->nama_siswa, 0, 1)) }}
                                </div>
                                <a href="/siswa/{{ $peserta->id }}" class="hover:text-blue-600 transition">
                                    {{ strtolower($peserta->nama_siswa) }}
                                </a>
                            </div>
                        </td>

                        <td class="px-4 py-3.5 text-center">
                            <span class="text-xs {{ $peserta->jenis_kelamin == 'L' ? 'text-blue-600' : 'text-pink-600' }}">
                                {{ $peserta->jenis_kelamin }}
                            </span>
                        </td>

                        <td class="px-4 py-3.5 text-center text-slate-600">
                            {{ $peserta->asramaTerkhir->asramaSiswa->asrama->nama_asrama ?? '-' }}
                        </td>

                        <td class="px-4 py-3.5 text-center text-slate-600">
                            {{ $peserta->kelasTerakhir->KelasMi->nama_kelas ?? '-' }}
                        </td>

                        <td class="px-4 py-3.5 text-center">
                            <span class="bg-purple-50 text-purple-700 border border-purple-200 px-2 py-0.5 rounded-full text-xs font-medium">
                                {{ $peserta->NisTerakhir->madrasah_diniyah ?? '-' }}
                            </span>
                        </td>

                        <td class="px-4 py-3.5 text-center text-slate-600">
                            {{ optional($peserta->NisTerakhir)->tanggal_masuk
                                    ? \Carbon\Carbon::parse($peserta->NisTerakhir->tanggal_masuk)->format('Y')
                                    : '-' }}
                        </td>

                        {{-- ACTION --}}
                        <td class="px-4 py-3.5">
                            <div class="flex justify-center gap-1.5">
                                <a href="/siswa/{{ $peserta->id }}"
                                    class="inline-flex items-center gap-1 bg-sky-500 hover:bg-sky-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>

                                @can('edit post')
                                <a href="/siswa/{{ $peserta->id }}/edit"
                                    class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                @endcan

                                @can('delete post')
                                <form action="/siswa/{{ $peserta->id }}" method="post"
                                    onsubmit="return confirm('Yakin hapus {{ $peserta->nama_siswa }}?')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-12 text-slate-400">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <span>Data tidak ditemukan</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800 bg-slate-50/50 dark:bg-gray-900/50">
            {{ $data->links() }}
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const btn = document.getElementById('submitButton');
                if (this.files.length > 0) {
                    btn.disabled = false;
                    btn.className = 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20 whitespace-nowrap';
                } else {
                    btn.disabled = true;
                    btn.className = 'bg-gray-400 text-white px-5 py-2.5 rounded-xl text-sm font-medium cursor-not-allowed transition-all whitespace-nowrap';
                }
            });
        }
    });
</script>