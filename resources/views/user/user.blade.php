<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Profil User' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Profile User') }}
        </h2>
    </x-slot>
    <div class=" p-2 sm:p-2 sm:flex grid sm:grid-cols-1  grid-cols-1 gap-2 ">
        <div class=" text-center  sm:text-center    bg-white dark:bg-purple-600 ">
            <center>
                <img src={{ asset("asset/images/logo.png") }} alt="" width="200" class=" p-2">
            </center>
        </div>
        <div class=" gap-4 bg-white w-full flex grid-cols-2  ">
            <div class=" w-full grid grid-cols-2 px-2 py-1  ">
                <div class=" px-1 text-xs sm:text-lg    ">Nomor Induk siswa</div>
                <div class=" px-1 text-xs sm:text-lg   ">: {{$siswa->nis}}</div>
                <div class=" px-1 text-xs sm:text-lg  ">Nama Lengkap </div>
                <div class=" px-1 text-xs sm:text-lg "> : {{$siswa->nama_siswa}}</div>
                <div class=" px-1 text-xs sm:text-lg  ">Agama </div>
                <div class=" px-1 text-xs sm:text-lg "> : {{$siswa->agama}}</div>
                <div class=" px-1 text-xs sm:text-lg ">Tempat, Tanggal Lahir</div>
                <div class=" px-1 capitalize text-xs sm:text-lg"> : {{strtolower($siswa->tempat_lahir)}},

                    {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}
                </div>
                <div class=" px-1 text-xs sm:text-lg ">Asal Kota</div>
                <div class=" px-1 text-xs sm:text-lg capitalize "> : {{$siswa->kota_asal}}</div>
            </div>
        </div>
    </div>
    <div class=" p-2">
        <div class=" bg-white p-2 px-2 w-full grid-cols-2 flex gap-2 justify-center sm:justify-start">
            <div>
                <a href="/siswa/{{$siswa->id}}/edit" class="     bg-yellow-500  px-2 py-1  text-center">
                    Update Data Siswa
                </a>
            </div>
            <div>
                <a href="/statusanak/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">
                    edit data status Anak
                </a>
            </div>
        </div>
    </div>



</x-app-layout>