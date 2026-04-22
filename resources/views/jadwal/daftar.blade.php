<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Ploting Jadwal Guru
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola jadwal mengajar guru per periode
                </p>
            </div>

            <!-- ACTION -->
            <div class="flex gap-2">
                <a href="#"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm shadow transition">
                    + Tambah Jadwal
                </a>
            </div>
        </div>
    </x-slot>

    <!-- CONTENT -->
    <div class="p-4 space-y-5">

        <!-- ALERT -->
        @if (session('update'))
        <div class="flex items-center gap-2 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
            {{ session('update') }}
        </div>
        <meta http-equiv="refresh" content="5">
        @endif

        <!-- CARD TABLE -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100">

            <!-- HEADER CARD -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 p-4 border-b">
                <div>
                    <h3 class="font-semibold text-gray-800">
                        Daftar Jadwal Guru
                    </h3>
                    <p class="text-xs text-gray-500">
                        Data jadwal aktif yang telah dibuat
                    </p>
                </div>

                <!-- OPTIONAL ACTION -->
                <div class="flex gap-2">
                    <button class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-sm">
                        Refresh
                    </button>
                </div>
            </div>

            <!-- BODY -->
            <div class="p-4">
                <div class="overflow-x-auto rounded-xl border">
                    <livewire:list-jadwal-guru />
                </div>
            </div>

        </div>

        <!-- INFO -->
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-2xl p-5 text-sm text-gray-700 shadow-sm">
            <p class="font-semibold mb-2 text-yellow-800">Keterangan:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li>Digunakan untuk mengatur jadwal mengajar guru setiap periode.</li>
                <li>Pastikan guru sudah memiliki penugasan aktif.</li>
                <li>Data ini akan digunakan dalam sistem presensi dan laporan.</li>
            </ul>
        </div>

    </div>

</x-app-layout>