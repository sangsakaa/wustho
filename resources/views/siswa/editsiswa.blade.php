<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Edit Siswa')
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            Edit Data Siswa
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Perbarui data siswa {{ $siswa->nama_siswa }}
        </p>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- Toast --}}
            @if (session('update'))
            <script>
                Toastify({
                    text: "Data berhasil diupdate",
                    className: "success",
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }
                }).showToast();
            </script>
            @endif

            {{-- DATA DIRI --}}
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-amber-500/5 rounded-2xl p-6 sm:p-8">

                <form action="{{ url('/siswa/'.$siswa->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    {{-- SECTION HEADER --}}
                    <div class="flex items-center gap-3 pb-4 border-b border-gray-100 dark:border-gray-800">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-400 flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Data Pribadi</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi dasar siswa</p>
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="mt-1.5 relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm @error('nama_siswa') border-red-400 @enderror">
                        </div>
                        @error('nama_siswa')
                        <p class="text-sm text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grid 2 --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <div class="mt-1.5 relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <select name="jenis_kelamin"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm appearance-none">
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Agama <span class="text-red-500">*</span></label>
                            <div class="mt-1.5 relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <select name="agama"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm appearance-none">
                                    <option value="Islam" {{ old('agama', $siswa->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tempat Lahir <span class="text-red-500">*</span></label>
                            <div class="mt-1.5 relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <div class="mt-1.5 relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kota Asal <span class="text-red-500">*</span></label>
                            <div class="mt-1.5 relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <input type="text" name="kota_asal" value="{{ old('kota_asal', $siswa->kota_asal) }}"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            </div>
                        </div>
                    </div>

                    {{-- STATUS PENGAMAL --}}
                    <div class="flex items-center gap-3 pb-2 pt-2 border-b border-gray-100 dark:border-gray-800">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-purple-500 to-violet-400 flex items-center justify-center shadow-lg shadow-purple-500/20">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Status Pengamal</h3>
                    </div>

                    <div>
                        <select name="status_pengamal"
                            class="w-full md:w-1/2 px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm appearance-none">
                            <option value="Pengamal" {{ old('status_pengamal', $status_pengamal->status_pengamal ?? 'Pengamal') == 'Pengamal' ? 'selected' : '' }}>Pengamal</option>
                            <option value="Simpatisan" {{ old('status_pengamal', $status_pengamal->status_pengamal ?? '') == 'Simpatisan' ? 'selected' : '' }}>Simpatisan</option>
                        </select>
                    </div>

                    {{-- STATUS ANAK --}}
                    <div class="flex items-center gap-3 pb-2 pt-2 border-b border-gray-100 dark:border-gray-800">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-500 to-rose-400 flex items-center justify-center shadow-lg shadow-pink-500/20">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Status Anak & Orang Tua</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status Anak</label>
                            <select name="status_anak"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm appearance-none">
                                <option value="kandung" {{ old('status_anak', $statusAnak->status_anak ?? '') == 'kandung' ? 'selected' : '' }}>Kandung</option>
                                <option value="tiri" {{ old('status_anak', $statusAnak->status_anak ?? '') == 'tiri' ? 'selected' : '' }}>Tiri</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Anak Ke</label>
                            <input type="number" name="anak_ke" value="{{ old('anak_ke', $statusAnak->anak_ke ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Jumlah Saudara</label>
                            <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara', $statusAnak->jumlah_saudara ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                        </div>
                    </div>

                    {{-- ORANG TUA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Data Ayah
                            </h4>
                            <input type="text" name="nama_ayah" placeholder="Nama Ayah"
                                value="{{ old('nama_ayah', $statusAnak->nama_ayah ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            <input type="text" name="pekerjaan_ayah" placeholder="Pekerjaan"
                                value="{{ old('pekerjaan_ayah', $statusAnak->pekerjaan_ayah ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            <input type="text" name="nomor_hp_ayah" placeholder="No HP"
                                value="{{ old('nomor_hp_ayah', $statusAnak->nomor_hp_ayah ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                        </div>

                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Data Ibu
                            </h4>
                            <input type="text" name="nama_ibu" placeholder="Nama Ibu"
                                value="{{ old('nama_ibu', $statusAnak->nama_ibu ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            <input type="text" name="pekerjaan_ibu" placeholder="Pekerjaan"
                                value="{{ old('pekerjaan_ibu', $statusAnak->pekerjaan_ibu ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                            <input type="text" name="nomor_hp_ibu" placeholder="No HP"
                                value="{{ old('nomor_hp_ibu', $statusAnak->nomor_hp_ibu ?? '') }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition shadow-sm">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 dark:border-gray-800">
                        @role('super admin')
                        <a href="/siswa"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Batal
                        </a>
                        @endrole

                        @role('siswa')
                        <a href="/user"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Batal
                        </a>
                        @endrole

                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-medium text-sm transition-all shadow-lg shadow-amber-500/20 hover:shadow-amber-600/30 hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Update Data
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>