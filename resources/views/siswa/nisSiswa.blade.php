<x-app-layout>
    <x-slot name="header">
        @section('title', ' | NIS' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Nomor Induk Siswa ') }}
        </h2>
    </x-slot>
    <div class="py-2 px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" grid  sm:grid-cols-2 grid-cols-2 ">
                        <div class=" flex w-full">
                            <div class="grid w-36  ">Nama </div>
                            <div class=" px-4 grid uppercase font-semibold   text-sm ">: {{$siswa->nama_siswa}}</div>
                        </div>
                        <div class=" flex w-full">
                            <div class="grid w-36 ">Tanggal Lahir </div>
                            <div class=" px-4">: {{$siswa->tempat_lahir}} , {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat(' DD MMMM Y') }}</div>
                        </div>

                        <div class=" flex w-full">
                            <div class=" grid  w-36 ">Jenis Kelamin </div>
                            <div class=" px-4"> : {{$siswa->jenis_kelamin}}</div>
                        </div>
                        <div class=" flex w-full">
                            <div class="  grid w-36    ">Status Asrama </div>
                            <div class=" px-4  grid  "> :
                                {{$siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" flex grid-cols-1 justify-items-end">
                        <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1  hover:bg-purple-500 text-white">Kembali</a>
                        @role('super admin')
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/nis/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Nomor Induk siswa</a>
                        </div>
                        <div class=" grid grid-cols-1 justify-items-end">
                            <a href="/biodata/{{$siswa->id}}" class=" bg-blue-500 px-2 py-1 hover:bg-purple-500 text-white">Biodata Lengkap</a>
                        </div>
                        @endrole
                    </div>
                    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2">
                        <div class=" py-1">

                            <form action="/nis/{{$siswa->id}}" method="post">
                                @csrf
                                <input type="hidden" name="siswa_id" value="{{$siswa->id}}" class=" py-1" required>
                                <input type="text" name="nis" class=" py-1" placeholder="NIS : 2023010001" autofocus>
                                <select name="madrasah_diniyah" id="" class=" py-1">
                                    <option value="Ula">--Ula--</option>
                                    <option value="Wustho">--Wustho--</option>
                                    <option value="Ulya">--Ulya--</option>
                                </select>
                                <select name="nama_lembaga" id="" class=" py-1">
                                    <option value="Wahidiyah">--Wahidiyah--</option>
                                </select>
                                <input type="date" name="tanggal_masuk" id="" class=" py-1" required>
                                <button class=" bg-blue-600 py-1 px-2 text-white rounded-sm">Create NIS</button>
                            </form>

                        </div>
                    </div>
                    <div>
                        <span>Detail Nomor Induk Siswa</span>
                        <table class=" w-full">
                            <thead>
                                <tr class=" border bg-gray-100">
                                    <th class=" py-1 border">No</th>
                                    <th class=" py-1 border">Nomor Induk Siswa</th>
                                    <th class=" py-1 boder">Nama Lembaga</th>
                                    <th class=" py-1 boder">Madrasah</th>
                                    <th class=" py-1 boder">Tanggal Masuk</th>
                                    <th class=" py-1 boder"> Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($nis->count())
                                @foreach($nis as $nomor)
                                <tr class=" border">
                                    <td class=" px-2 py-1 text-center border">{{$loop->iteration}}</td>
                                    <td class=" px-2 text-center border">{{$nomor->nis}}</td>
                                    <td class=" px-2 text-center border">{{$nomor->nama_lembaga}}</td>
                                    <td class=" px-2 text-center border">{{$nomor->madrasah_diniyah}}</td>
                                    <td class=" px-2 text-center border">{{$nomor->tanggal_masuk}}</td>
                                    <td class="flex justify-center mt-1  gap-1">
                                        @role('super admin')
                                        <form action="/nis/{{$nomor->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class=" flex p-0  text-center text-white bg-red-600 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg></button>
                                        </form>
                                        <a href="nis/{{$nomor->id}}/edit" class=" bg-yellow-500 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg></a>
                                        @endrole
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class=" border text-center font-semibold text-red-600"> Belum memiliki NIS : Nomor induk Siswa</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" px-4 py-2">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-blue-200 border-b border-gray-200">
                    <div class=" ">
                        <p class=" font-semibold"> Keterangan :</p>
                        <p class=" font-semibold"> Mekanisme Pembuatan Nomor Induk Siswa</p>
                        <p class="px-2">
                            1.TAHUN MASUK-KODE MADRASAH-NOMOR URUT SISWA
                        </p>
                        <p class=" px-5">Contoh : 202002001</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>



</x-app-layout>