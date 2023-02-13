<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Profil User' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Profile User') }}
        </h2>
    </x-slot>
    <div class=" p-2 sm:p-2 sm:flex grid sm:grid-cols-1  grid-cols-1 gap-2 ">
        <div class=" text-center  sm:text-center   rounded bg-white dark:bg-purple-600 ">
            <center>
                <img src={{ asset("asset/images/logo.png") }} alt="" width="200" class=" p-2">
            </center>
        </div>
        <div class=" p-1  grid  grid-cols-2 text-xs sm:text-sm sm:p-5   sm:grid-cols-2 w-full dark:bg-purple-600     bg-white ">
            <div class=" px-1 ">Nomor Induk siswa</div>
            <div class=" px-1 ">: {{$siswa->nis}}</div>
            <div class=" px-1 ">Nama Lengkap </div>
            <div class=" px-1 text-xs sm:text-sm "> : {{$siswa->nama_siswa}}</div>
            <div class=" px-1 ">Tempat, Tanggal Lahir</div>
            <div class=" px-1 capitalize "> : {{$siswa->tempat_lahir}},
                {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
            </div>
            <div class=" px-1 ">Asal Kota</div>
            <div class=" px-1 capitalize "> : {{$siswa->kota_asal}}</div>

        </div>

    </div>


</x-app-layout>