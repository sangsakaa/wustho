<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Peserta Kelas ' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Peserta Kelas') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" grid mx-auto gap-2 ">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <livewire:list-kolektif-kelas :kelasmi="$kelasmi->id" />
                </div>
            </div>
            <div class=" bg-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2  bg-blue-200 border-b border-gray-200">

                    <p class=" font-semibold">Keterangan :</p>
                    <p class=" px-2">- Fitur ini digunakan untuk menambah peserta kelas secara kolektif</p>


                </div>
            </div>

        </div>
    </div>
</x-app-layout>