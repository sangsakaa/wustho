<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class=" p-4">
        <div class=" grid p-4  bg-white ">
            <img src={{ asset("asset/images/logo_kop.jpeg") }} alt="" width="300px" class=" p-2">
        </div>
        <div>Nomor Induk siswa</div>
        <div> : {{$siswa->nis}}</div>
        <div>Nama Siswa</div>
        <div>{{$siswa->nama_siswa}}</div>
    </div>
</x-app-layout>