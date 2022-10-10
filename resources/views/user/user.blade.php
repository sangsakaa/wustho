<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class=" p-2 sm:p-4 sm:flex grid sm:grid-cols-1  grid-cols-1 gap-2 ">

        <div class=" text-center  sm:text-center   rounded bg-white ">
            <center>
                <img src={{ asset("asset/images/logo_kop.jpeg") }} alt="" width="300" class=" h-300 p-2">
            </center>
        </div>
        <div class=" p-4    w-full    grid-cols-2 sm:grid-cols-2  bg-white ">
            <div class=" px-1 border">Nomor Induk siswa</div>
            <div class=" px-1 border"> {{$siswa->nis}}</div>
            <div class=" px-1 border">Nama Lengkap </div>
            <div class=" px-1 border"> {{$siswa->nama_siswa}}</div>
            <div class=" px-1 border">Tempat Lahir</div>
            <div class=" px-1 border"> {{$siswa->tempat_lahir}}</div>
            <div class=" px-1 border">Tanggal Lahir</div>
            <div class=" px-1 border"> {{$siswa->tanggal_lahir}}</div>
        </div>

    </div>


</x-app-layout>