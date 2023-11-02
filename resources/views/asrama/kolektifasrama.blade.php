<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __(' Tambah Anggota Asrama ') }}
        </h2>
    </x-slot>

    <div class="p-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <livewire:list-kolektif-asrama :asramasiswa="$asramasiswa->id" />

                </div>
            </div>
        </div>
    </div>
</x-app-layout>