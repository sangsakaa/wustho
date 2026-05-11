<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Status Anak' )
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Status Anak
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Data orang tua dan status anak {{ $siswa->nama_siswa }}
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Nama Lengkap</p>
                        <p class="font-medium text-gray-800 dark:text-white capitalize">{{ strtolower($siswa->nama_siswa) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Agama</p>
                        <p class="font-medium text-gray-800 dark:text-white">{{ $siswa->agama }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Tempat, Tanggal Lahir</p>
                        <p class="font-medium text-gray-800 dark:text-white capitalize">{{ strtolower($siswa->tempat_lahir) }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Asal Kota</p>
                        <p class="font-medium text-gray-800 dark:text-white capitalize">{{ $siswa->kota_asal }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Asrama</p>
                        <p class="font-medium text-gray-800 dark:text-white">
                            @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama !== null)
                            {{ $siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama }}
                            @else
                            <span class="text-amber-600">Belum memiliki asrama</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="flex flex-wrap gap-2">
            @role('siswa')
            <a href="/user"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            @endrole
            @role('super admin')
            <a href="/siswa/{{$siswa->id}}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Detail Siswa
            </a>
            <a href="/nis/{{$siswa->id}}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
                Nomor Induk
            </a>
            <a href="/biodata/{{$siswa->id}}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Biodata
            </a>
            <a href="/statuspengamal/{{$siswa->id}}"
                class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Status Pengamal
            </a>
            @endrole
        </div>

        {{-- TOAST --}}
        @if (session('create'))
        <script>
            Toastify({ text: "Data berhasil ditambahkan", className: "create", style: { background: "linear-gradient(to right, #00b09b, #96c93d)" } }).showToast();
        </script>
        @endif

        {{-- FORM STATUS ANAK --}}
        @if($sp->count() == 0)
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Tambah Status Anak & Orang Tua</h3>
            </div>
            <div class="p-5">
                <form action="/statusanak/{{$siswa->id}}" method="post" class="space-y-4">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{$siswa->id}}">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Anak Ke</label>
                            <input type="number" name="anak_ke" placeholder="Contoh: 5"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Jumlah Saudara</label>
                            <input type="number" name="jumlah_saudara" placeholder="Contoh: 5"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status Anak</label>
                            <select name="status_anak"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none">
                                <option value="kandung">Kandung</option>
                                <option value="tiri">Tiri</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Data Ayah
                            </h4>
                            <input type="text" name="nama_ayah" placeholder="Nama Ayah"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <select name="pekerjaan_ayah"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none">
                                <option value="">-- Pekerjaan Ayah --</option>
                                <option value="pns">PNS</option>
                                <option value="wirausaha">Wirausaha</option>
                                <option value="petani">Petani</option>
                                <option value="guru">Guru</option>
                                <option value="swasta">Swasta</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <input type="text" name="nomor_hp_ayah" placeholder="No HP Ayah"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        </div>

                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Data Ibu
                            </h4>
                            <input type="text" name="nama_ibu" placeholder="Nama Ibu"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <select name="pekerjaan_ibu"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none">
                                <option value="">-- Pekerjaan Ibu --</option>
                                <option value="irt">IRT</option>
                                <option value="pns">PNS</option>
                                <option value="wirausaha">Wirausaha</option>
                                <option value="petani">Petani</option>
                                <option value="guru">Guru</option>
                                <option value="swasta">Swasta</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <input type="text" name="nomor_hp_ibu" placeholder="No HP Ibu"
                                class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2.5 text-sm bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                        </div>
                    </div>

                    <button
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Data
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- TABLE STATUS ANAK --}}
        @role('super admin')
        @if($sp->count() > 0)
        <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-violet-400 flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-800 dark:text-white">Detail Status Anak & Orang Tua</h3>
            </div>
            <div class="overflow-x-auto p-1">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-gray-800/50 text-slate-600 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-3 py-2.5 text-center">Status</th>
                            <th class="px-3 py-2.5 text-center">Anak Ke</th>
                            <th class="px-3 py-2.5 text-center">Jml Saudara</th>
                            <th class="px-3 py-2.5 text-left">Ayah</th>
                            <th class="px-3 py-2.5 text-left">Pekerjaan</th>
                            <th class="px-3 py-2.5 text-left">HP Ayah</th>
                            <th class="px-3 py-2.5 text-left">Ibu</th>
                            <th class="px-3 py-2.5 text-left">Pekerjaan</th>
                            <th class="px-3 py-2.5 text-left">HP Ibu</th>
                            <th class="px-3 py-2.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-gray-800">
                        @foreach($sp as $org)
                        <tr class="hover:bg-slate-50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-3 py-2.5 text-center">
                                <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-full text-xs font-medium capitalize">{{ $org->status_anak }}</span>
                            </td>
                            <td class="px-3 py-2.5 text-center font-medium">{{ $org->anak_ke }}</td>
                            <td class="px-3 py-2.5 text-center">{{ $org->jumlah_saudara }}</td>
                            <td class="px-3 py-2.5 capitalize">{{ $org->nama_ayah ?? '-' }}</td>
                            <td class="px-3 py-2.5 capitalize">{{ $org->pekerjaan_ayah ?? '-' }}</td>
                            <td class="px-3 py-2.5">{{ $org->nomor_hp_ayah ?? '-' }}</td>
                            <td class="px-3 py-2.5 capitalize">{{ $org->nama_ibu ?? '-' }}</td>
                            <td class="px-3 py-2.5 capitalize">{{ $org->pekerjaan_ibu ?? '-' }}</td>
                            <td class="px-3 py-2.5">{{ $org->nomor_hp_ibu ?? '-' }}</td>
                            <td class="px-3 py-2.5">
                                <div class="flex justify-center gap-1.5">
                                    <form action="/statusanak/{{$org->id}}" method="post" onsubmit="return confirm('Hapus data status anak?')">
                                        @csrf
                                        @method('delete')
                                        <button class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                    <a href="/statusanak/{{$org->id}}/edit"
                                        class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1.5 rounded-lg text-xs font-medium transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 text-center text-amber-700 text-sm">
            Belum ada data status anak. Silakan isi form di atas.
        </div>
        @endif
        @endrole

    </div>
</x-app-layout>