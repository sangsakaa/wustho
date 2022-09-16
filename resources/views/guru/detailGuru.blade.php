<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Asrama') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" p-4 grid grid-cols-4 gap-1">
                        <div>Nama Lengkap</div>
                        <div>: {{$guru->nama_guru}}</div>
                        <div>Jenia Kelamin</div>
                        <div>: {{$guru->jenis_kelamin}}</div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>