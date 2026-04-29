<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Ploting Jadwal Guru
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Kelola pembagian jadwal mengajar guru per periode akademik
                </p>
            </div>

            <div class="flex gap-2">
                <a href="#"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-sm transition text-sm font-medium">
                    <span>+</span>
                    Tambah Jadwal
                </a>

                <a href="{{ url()->current() }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border hover:bg-gray-50 text-gray-700 rounded-xl shadow-sm transition text-sm font-medium">
                    Refresh
                </a>
            </div>
        </div>
    </x-slot>

    <div class="p-4 space-y-6">

        {{-- ALERT --}}
        @if (session('update'))
        <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl shadow-sm">
            <div class="mt-0.5">
                ✅
            </div>
            <div>
                <p class="font-medium">Berhasil</p>
                <p class="text-sm">{{ session('update') }}</p>
            </div>
        </div>
        <meta http-equiv="refresh" content="4">
        @endif

        {{-- SUMMARY CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-5">
                <p class="text-sm text-gray-500">Status</p>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mt-1">
                    Jadwal Aktif
                </h3>
                <p class="text-xs text-green-600 mt-2">
                    Periode berjalan sedang aktif
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-5">
                <p class="text-sm text-gray-500">Manajemen</p>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mt-1">
                    Guru & Mata Pelajaran
                </h3>
                <p class="text-xs text-gray-500 mt-2">
                    Pastikan semua guru sudah diplot
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-5">
                <p class="text-sm text-gray-500">Integrasi</p>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mt-1">
                    Presensi & Laporan
                </h3>
                <p class="text-xs text-gray-500 mt-2">
                    Digunakan untuk laporan akademik
                </p>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border overflow-hidden">

            <div class="px-5 py-4 border-b bg-gray-50 dark:bg-gray-900">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">
                            Daftar Jadwal Guru
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Jadwal yang sudah dibuat dan aktif pada periode ini
                        </p>
                    </div>

                    <div class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full w-fit">
                        Data aktif
                    </div>
                </div>
            </div>

            <div class="p-4">
                <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                    <livewire:list-jadwal-guru />
                </div>
            </div>
        </div>

        {{-- INFORMATION --}}
        <div
            class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-yellow-200 rounded-2xl p-5 shadow-sm">

            <h4 class="font-semibold text-yellow-800 mb-3">
                Informasi Sistem
            </h4>

            <ul class="space-y-2 text-sm text-gray-700">
                <li>• Digunakan untuk mengatur jadwal mengajar guru setiap periode akademik.</li>
                <li>• Pastikan guru, kelas, dan mata pelajaran sudah lengkap sebelum generate nilai.</li>
                <li>• Data jadwal akan digunakan untuk presensi, nilai, dan laporan akademik.</li>
            </ul>
        </div>

    </div>
</x-app-layout>