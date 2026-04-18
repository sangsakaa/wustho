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
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">

                <div class="bg-white dark:bg-gray-900 border rounded-lg p-3">
                    <p class="text-gray-400">Total</p>
                    <p class="text-lg font-bold text-gray-700 dark:text-white">
                        {{ $total ?? 0 }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 border rounded-lg p-3">
                    <p class="text-gray-400">Aktif</p>
                    <p class="text-lg font-bold text-green-600">
                        {{ $aktif ?? 0 }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 border rounded-lg p-3">
                    <p class="text-gray-400">Lulus</p>
                    <p class="text-lg font-bold text-blue-600">
                        {{ $lulus ?? 0 }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-900 border rounded-lg p-3">
                    <p class="text-gray-400">Boyong</p>
                    <p class="text-lg font-bold text-red-600">
                        {{ $boyong ?? 0 }}
                    </p>
                </div>

            </div>

        </div>

    </x-slot>

    <div class="space-y-4">

        {{-- TABLE --}}
        <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl p-4 border border-gray-200 dark:border-gray-700">
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