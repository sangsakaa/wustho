<x-app-layout>

    <x-slot name="header">

        @section('title', ' | Perangkat')

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Dashboard Perangkat
                </h2>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola data perangkat dan jabatan dengan lebih modern
                </p>
            </div>

        </div>

    </x-slot>

    <div class="p-3 sm:p-5 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-950 dark:to-gray-900 min-h-screen space-y-5"
        x-data="{ tab: 'aktif' }">

        {{-- ACTION CARD --}}
        <div
            class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl p-5 transition hover:shadow-xl">

            <div class="flex flex-col sm:flex-row gap-3">

                <a href="/form-perangkat"
                    class="inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-600/30 hover:-translate-y-0.5 active:translate-y-0">

                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>Tambah Data</span>

                </a>

                <a href="/jabatan"
                    class="inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-6 py-3 rounded-xl text-sm font-medium transition-all shadow-lg shadow-emerald-500/20 hover:shadow-emerald-600/30 hover:-translate-y-0.5 active:translate-y-0">

                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Tambah Jabatan</span>

                </a>

            </div>

        </div>

        {{-- STATS ROW --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-sky-400 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Perangkat</p>
                        <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $aktif->count() + $nonAktif->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-green-400 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aktif</p>
                        <p class="text-2xl font-bold text-emerald-600">{{ $aktif->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-500 to-slate-400 flex items-center justify-center shadow-lg shadow-slate-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Non Aktif</p>
                        <p class="text-2xl font-bold text-slate-600">{{ $nonAktif->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB --}}
        <div class="flex flex-wrap gap-2">

            <button
                @click="tab='aktif'"
                :class="tab=='aktif'
                    ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/20'
                    : 'bg-white/80 dark:bg-gray-900/80 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800'"
                class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all">

                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Aktif
                    <span class="ml-0.5 text-xs opacity-80">({{ $aktif->count() }})</span>
                </div>

            </button>

            <button
                @click="tab='nonaktif'"
                :class="tab=='nonaktif'
                    ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-lg shadow-red-500/20'
                    : 'bg-white/80 dark:bg-gray-900/80 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800'"
                class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all">

                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Non Aktif
                    <span class="ml-0.5 text-xs opacity-80">({{ $nonAktif->count() }})</span>
                </div>

            </button>

        </div>

        {{-- TABLE CARD --}}
        <div
            class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border border-gray-200/60 dark:border-gray-800 shadow-lg shadow-blue-500/5 rounded-2xl overflow-hidden">

            {{-- HEADER --}}
            <div
                class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>

                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        Data Perangkat
                    </h3>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Daftar perangkat aktif dan non aktif
                    </p>

                </div>

                {{-- STATUS INFO --}}
                <div class="flex gap-2 flex-wrap">

                    <div
                        class="bg-blue-50 text-blue-700 border border-blue-100 px-3 py-1 rounded-full text-xs font-medium">

                        Aktif: {{ $aktif->count() }}

                    </div>

                    <div
                        class="bg-red-50 text-red-700 border border-red-100 px-3 py-1 rounded-full text-xs font-medium">

                        Non Aktif: {{ $nonAktif->count() }}

                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                {{-- ================= AKTIF ================= --}}
                <div x-show="tab==='aktif'" x-transition.opacity.duration.300ms>

                    <table class="min-w-full text-sm">

                        @include('perangkat.table', ['data' => $aktif])

                    </table>

                </div>

                {{-- ================= NON AKTIF ================= --}}
                <div x-show="tab==='nonaktif'" x-transition.opacity.duration.300ms>

                    <table class="min-w-full text-sm">

                        @include('perangkat.table', ['data' => $nonAktif])

                    </table>

                </div>

            </div>

        </div>

        {{-- NOTE --}}
        <div
            class="bg-gradient-to-r from-blue-50 to-sky-50 dark:from-blue-950/30 dark:to-sky-950/30 border border-blue-200/60 dark:border-blue-800/30 rounded-2xl p-5 shadow-sm">

            <div class="flex items-start gap-4">

                {{-- ICON --}}
                <div
                    class="bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 p-2.5 rounded-xl shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z" />

                    </svg>

                </div>

                {{-- CONTENT --}}
                <div>

                    <h4 class="font-semibold text-blue-700 dark:text-blue-400 mb-2">
                        Keterangan
                    </h4>

                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">

                        <li class="flex gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            Data perangkat aktif masih memiliki jabatan dan tugas aktif
                        </li>

                        <li class="flex gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            Data non aktif digunakan sebagai arsip perangkat sebelumnya
                        </li>

                        <li class="flex gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            Pastikan jabatan perangkat selalu diperbarui secara berkala
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>