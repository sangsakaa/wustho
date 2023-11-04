<x-app-layout>
    <x-slot name="header">
        @section('title','| Daftar Peserta Kelas : '.$kelasmi->nama_kelas )
        <h2 class="font-semibold text-xl  leading-tight">
            Daftar Kelas : {{$kelasmi->nama_kelas}}
        </h2>
    </x-slot>

    <div class=" mx-auto ">
        <div class=" dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
            <div class=" overflow-auto">
                <livewire:list-peserta-kelas :kelasmi="$kelasmi->id"></livewire:list-peserta-kelas>
            </div>
        </div>
    </div>

</x-app-layout>