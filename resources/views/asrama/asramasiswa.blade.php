<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Asrama Siswa' )
        <h2 class="font-semibold text-xl  leading-tight">
            @role('pengurus')
            {{ __('Dashboard Asrama Santri') }}
            @endrole
            @role('super admin')
            {{ __('Dashboard Asrama Siswa') }}
            @endrole
        </h2>
    </x-slot>
    <div class=" my-2 text-sm">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="p-2">
                    <div class=" overflow-auto p-1 md:overflow-auto">
                        <livewire:list-asrama />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-2 overflow-auto ">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm ">
                <div class="p-2 bg-blue-200 border-b border-gray-200">
                    <div class="flex justify-items-end grid-cols-1 gap-2  py-1">
                        <div class=" grid grid-cols-1">
                            <span class=" text-bold">Keterangan :</span>
                            <div class=" px-2">
                                <p class=" capitalize">1. Untuk penambahan <b>anggota asrama </b> <u>wajib</u> memiliki <b><u>NIS (nomor induk siswa)</u></b> </p>
                                <p class=" capitalize">2. jika tidak memili harap <b>NIS (nomor induk siswa)</b> konfimasi ke pihak madin bagian <b>kesiswaan & kepala sekolah</b> </p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>