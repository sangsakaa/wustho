<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekap Kelas') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 border-b border-gray-200">

                {{-- BUTTON ACTION --}}
                <div class="flex justify-end mb-4">
                    <a href="{{ url('sesi-presensi-guru') }}"
                        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        + Sesi Presensi Guru
                    </a>
                </div>

                <livewire:rekap-kelas />

            </div>
        </div>
    </div>
</x-app-layout>