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

    <div class="p-3 sm:p-5 bg-gray-50 dark:bg-gray-950 min-h-screen space-y-5"
        x-data="{ tab: 'aktif' }">

        {{-- ACTION --}}
        <div
            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm rounded-2xl p-4">

            <div class="flex flex-col sm:flex-row gap-3">

                <a href="/form-perangkat"
                    class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-medium transition shadow-sm">

                    <span>+</span>
                    <span>Tambah Data</span>

                </a>

                <a href="/jabatan"
                    class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl text-sm font-medium transition shadow-sm">

                    <span>+</span>
                    <span>Tambah Jabatan</span>

                </a>

            </div>

        </div>

        {{-- TAB --}}
        <div class="flex flex-wrap gap-3">

            <button
                @click="tab='aktif'"
                :class="tab=='aktif'
                    ? 'bg-blue-600 text-white shadow-md'
                    : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700'"
                class="px-5 py-2.5 rounded-xl text-sm font-medium transition">

                Aktif
                <span class="ml-1 text-xs opacity-80">
                    ({{ $aktif->count() }})
                </span>

            </button>

            <button
                @click="tab='nonaktif'"
                :class="tab=='nonaktif'
                    ? 'bg-red-600 text-white shadow-md'
                    : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700'"
                class="px-5 py-2.5 rounded-xl text-sm font-medium transition">

                Non Aktif
                <span class="ml-1 text-xs opacity-80">
                    ({{ $nonAktif->count() }})
                </span>

            </button>

        </div>

        {{-- TABLE CARD --}}
        <div
            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 shadow-sm rounded-2xl overflow-hidden">

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
                <div x-show="tab==='aktif'" x-transition>

                    <table class="min-w-full text-sm">

                        @include('perangkat.table', ['data' => $aktif])

                    </table>

                </div>

                {{-- ================= NON AKTIF ================= --}}
                <div x-show="tab==='nonaktif'" x-transition>

                    <table class="min-w-full text-sm">

                        @include('perangkat.table', ['data' => $nonAktif])

                    </table>

                </div>

            </div>

        </div>

        {{-- NOTE --}}
        <div
            class="bg-gradient-to-r from-blue-50 to-sky-50 border border-blue-200 rounded-2xl p-5">

            <div class="flex items-start gap-3">

                {{-- ICON --}}
                <div
                    class="bg-blue-100 text-blue-600 p-2 rounded-xl">

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

                    <h4 class="font-semibold text-blue-700 mb-2">
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