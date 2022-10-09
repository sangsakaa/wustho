<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class=" flex grid-cols-2 p-4 gap-2 ">
        <div class="  rounded bg-white ">
            <img src={{ asset("asset/images/logo_kop.jpeg") }} alt="" width="300px" class=" p-2">
        </div>
        <div class=" p-4   grid-cols-2 w-full bg-white ">
            <div class=" px-4 border">Nomor Induk siswa</div>
            <div class=" px-4 border"> {{$siswa->nis}}</div>
            <div class=" px-4 border">Nama Lengkap </div>
            <div class=" px-4 border"> {{$siswa->nama_siswa}}</div>
            <div class=" px-4 border">Tempat Lahir</div>
            <div class=" px-4 border"> {{$siswa->tempat_lahir}}</div>
            <div class=" px-4 border">Tanggal Lahir</div>
            <div class=" px-4 border"> {{$siswa->tanggal_lahir}}</div>



        </div>
    </div>


</x-app-layout>