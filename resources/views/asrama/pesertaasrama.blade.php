<x-app-layout>

    <x-slot name="header">

        @section('title', ' | Asrama : ' . ($tittle?->nama_asrama ?? 'asrama tidak ditemukan'))

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-purple-500">
                    Peserta Asrama
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $tittle?->nama_asrama ?? 'Asrama tidak ditemukan' }}
                </p>
            </div>

            <div class="text-sm text-gray-500 dark:text-gray-400">
                Detail Data Peserta
            </div>

        </div>

    </x-slot>

    {{-- INFO CARD --}}
    <div class="px-4 py-4">

        <div class="bg-white dark:bg-dark-bg border dark:border-gray-700 rounded-xl shadow-sm p-4">

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-y-2 text-sm">

                <div class="text-gray-500 dark:text-gray-400">Nama Asrama</div>
                <div class="font-semibold uppercase text-gray-800 dark:text-purple-400">
                    {{ $tittle?->nama_asrama ?? 'Asrama tidak ditemukan' }}
                </div>

                <div class="text-gray-500 dark:text-gray-400">Kuota Asrama</div>
                <div class="font-semibold text-gray-800 dark:text-purple-400">
                    {{ $tittle?->kuota ?? 'kuota kosong' }} org
                </div>

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="px-4 pb-6">

        <div class="bg-white dark:bg-dark-bg border dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">

            {{-- HEADER SMALL --}}
            <div class="px-4 py-3 border-b dark:border-gray-700 flex justify-between items-center">

                <h3 class="font-semibold text-gray-700 dark:text-purple-400">
                    Daftar Peserta Asrama
                </h3>

                <span class="text-xs text-gray-500 dark:text-gray-400">
                    ID: {{ $asramasiswa->id }}
                </span>

            </div>

            {{-- LIVEWIRE --}}
            <div class="p-3">
                <livewire:list-peserta-asrama :asramasiswa="$asramasiswa->id" />
            </div>

        </div>

    </div>

</x-app-layout>