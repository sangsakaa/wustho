<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Profil User' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Profile User') }}
        </h2>
    </x-slot>
    <div class=" p-2 sm:p-4 sm:flex grid sm:grid-cols-1  grid-cols-1 gap-2 ">

        <div class=" text-center  sm:text-center   rounded bg-white ">
            <center>
                <img src={{ asset("asset/images/logo_kop.jpeg") }} alt="" width="250" class=" p-2">
            </center>
        </div>
        <div class=" p-6  grid  grid-cols-1  sm:grid-cols-2  bg-white ">
            <div class=" px-1 ">Nomor Induk siswa</div>
            <div class=" px-1 ">: {{$siswa->nis}}</div>
            <div class=" px-1 ">Nama Lengkap </div>
            <div class=" px-1 "> : {{$siswa->nama_siswa}}</div>
            <div class=" px-1 ">Tempat Lahir</div>
            <div class=" px-1 "> : {{$siswa->tempat_lahir}}</div>
            <div class=" px-1 ">Tanggal Lahir</div>
            <div class=" px-1 "> : {{$siswa->tanggal_lahir}}</div>
        </div>

    </div>


</x-app-layout>