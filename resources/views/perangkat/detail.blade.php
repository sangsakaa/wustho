<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Perangkat')
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
            {{ __('Detail Perangkat') }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Informasi lengkap dan manajemen jabatan perangkat
        </p>
    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- BACK NAV -->
            <div>
                <a href="/data-perangkat"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke daftar perangkat
                </a>
            </div>

            <!-- PROFILE HEADER CARD -->
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-sky-500 px-6 py-8">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                            {{ strtoupper(substr($perangkat->nama_perangkat, 0, 2)) }}
                        </div>
                        <div class="text-white">
                            <h3 class="text-xl font-bold">{{ $perangkat->nama_perangkat }}</h3>
                            <p class="text-blue-100 text-sm mt-1">Perangkat Madrasah Diniyah</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 {{ $perangkat->jenis_kelamin == 'L' ? 'text-blue-500' : 'text-pink-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ $perangkat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Agama</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    {{ $perangkat->agama ?? '-' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $perangkat->tempat_lahir }}, {{ $perangkat->tanggal_lahir ? \Carbon\Carbon::parse($perangkat->tanggal_lahir)->isoFormat('D MMM Y') : '-' }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tanggal Masuk</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    {{ $perangkat->tanggal_masuk ? \Carbon\Carbon::parse($perangkat->tanggal_masuk)->isoFormat('D MMM Y') : '-' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JABATAN CARD -->
            <div x-data="{ openModal: false }">
                <!-- JABATAN CARD -->
                <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">

                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-500 to-green-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    Jabatan
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Daftar jabatan yang diampu
                                </p>
                            </div>
                        </div>

                        <button
                            @click="openModal = true"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Update
                        </button>
                    </div>

                    <div class="p-6">

                        @if($perangkat->jabatan->isEmpty())
                        <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                            <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm">Belum ada jabatan</p>
                        </div>
                        @else

                        <div class="flex flex-wrap gap-2">
                            @foreach($perangkat->jabatan as $jab)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                {{ $jab->nama_jabatan }}
                            </span>
                            @endforeach
                        </div>

                        @endif

                    </div>
                </div>

                <!-- MODAL -->
                <div
                    x-show="openModal"
                    x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4"
                    style="display:none">

                    <div
                        @click.away="openModal = false"
                        class="w-full max-w-lg bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden">

                        <!-- Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b dark:border-gray-800">

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                    Update Jabatan
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Pilih jabatan perangkat
                                </p>
                            </div>

                            <button
                                @click="openModal = false"
                                class="text-gray-400 hover:text-red-500 text-xl">
                                ×
                            </button>

                        </div>

                        <!-- Form -->
                        <form action="" method="POST">
                            @csrf

                            <div class="p-6">

                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jabatan
                                </label>

                                <select
                                    name="jabatan_id"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">

                                    <option value="">-- Pilih Jabatan --</option>

                                    @foreach($jabatan as $jab)
                                    <option
                                        value="{{ $jab->id }}"
                                        {{ $perangkat->jabatan->contains('id', $jab->id) ? 'selected' : '' }}>
                                        {{ $jab->nama_jabatan }}
                                    </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="flex justify-end gap-3 px-6 py-4 border-t dark:border-gray-800">

                                <button
                                    type="button"
                                    @click="openModal = false"
                                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700">
                                    Batal
                                </button>

                                <button
                                    type="submit"
                                    class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                                    Simpan
                                </button>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>