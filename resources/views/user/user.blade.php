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
        <div class=" p-4 grid w-full bg-white ">
            <div class=" grid grid-cols-4">Nomor Induk siswa</div>
            <div> {{$siswa->nis}}</div>
            <div>Nama Siswa</div>
            <div> {{$siswa->nama_siswa}}</div>
            <div>Tempat ,Tanggal Lahir</div>
            <div> {{$siswa->tempat_lahir}}, {{$siswa->tanggal_lahir}}</div>

        </div>
    </div>


</x-app-layout>