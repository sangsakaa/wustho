<x-app-layout>
    <x-slot name="header">

        <div class="flex flex-col gap-3">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-base font-semibold text-gray-800 dark:text-white">
                        Data Siswa
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Manajemen data siswa pondok
                    </p>
                </div>

            </div>

            {{-- DASHBOARD STAT --}}


        </div>

    </x-slot>

    <div class="space-y-4">

        {{-- TABLE --}}
        <div class=" dark:bg-gray-900 shadow-sm rounded-xl p-4 border border-gray-200 dark:border-gray-700">
            <livewire:mahasiswa-table />
        </div>

        {{-- KETERANGAN --}}
        <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl p-4 border border-gray-200 dark:border-gray-700">

            <h3 class="font-medium text-sm mb-3 text-gray-700 dark:text-gray-200">
                Keterangan
            </h3>

            <div class="space-y-2 text-xs text-gray-600 dark:text-gray-300">

                <div class="flex gap-2">
                    <span class="text-green-600 font-semibold">1.</span>
                    <p>Siswa <b>Aktif</b> masih mengikuti pembelajaran.</p>
                </div>

                <div class="flex gap-2">
                    <span class="text-blue-600 font-semibold">2.</span>
                    <p>Siswa <b>Lulus</b> telah menyelesaikan pembelajaran.</p>
                </div>

                <div class="flex gap-2">
                    <span class="text-red-600 font-semibold">3.</span>
                    <p>Siswa <b>Boyong</b> sudah tidak aktif.</p>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>