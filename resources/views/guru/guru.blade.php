<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Guru' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Asrama') }}
        </h2>
    </x-slot>
    <div class=" px-4 mt-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    @if (session('delete'))
                    <div class=" py-2">
                        <div class=" bg-red-500 px-2 py-1 text-white">
                            {{ session('delete') }}
                        </div>
                    </div>
                    @endif
                    @if (session('success'))
                    <div class=" py-2">
                        <div class=" bg-green-500 px-2 py-1 text-white">
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif
                    @if (session('update'))
                    <div class=" py-2">
                        <div class=" bg-blue-500 px-2 py-1 text-white">
                            {{ session('update') }}
                        </div>
                    </div>
                    @endif
                    <div class=" grid gap-1 grid-cols-2 w-full ">
                        <div class=" flex  w-full">
                            <form action="/guru" method="get" class=" flex gap-1">
                                <input type="text" name="cari" value="{{ request('cari') }}" class=" border text-green-800 rounded-sdm py-1 " placeholder=" Cari ...">

                                <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                    Cari </button>
                            </form>
                        </div>
                        <div class=" flex gap-2 justify-end w-full ">
                            <a href="/addGuru">
                                <button class=" bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </a>
                            <a href="/asramasiswa">
                                <div class="">
                                    <button class=" bg-blue-500 text-white py-1 px-2 rounded-md d-inline-block">
                                        Asrama Siswa
                                    </button>
                                </div>

                            </a>
                        </div>
                    </div>
                    <Table class=" w-full ">
                        <thead class=" bg-gray-50">
                            <tr class=" border  ">
                                <th class="px-2 py-1 border">#</th>
                                <th class="px-2 text-left">Nama Guru</th>
                                <th class="px-2 text-left">JK</th>
                                <th class="px-2 text-left">Agama</th>
                                <th class="px-2 text-left">Tempat Lahir</th>
                                <th class="px-2 text-center">Tanggal Lahir</th>
                                <th class="px-2 text-center">Tanggal Masuk</th>
                                <th class="px-2 text-center">Angkatan</th>
                                <th class="px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dataGuru->count() != null)
                            @foreach ($dataGuru as $item)
                            <tr class=" border hover:bg-green-100">
                                <th class=" text-center border">{{$loop->iteration}}</th>
                                <td class=" px-2">
                                    <a href="guru/{{$item->id}}">
                                        {{$item->nama_guru}}
                                    </a>
                                </td>
                                <td class=" px-2"> {{$item->jenis_kelamin}}</td>
                                <td class=" px-2"> {{$item->agama}}</td>
                                <td class=" px-2"> {{$item->tempat_lahir}}</td>
                                <td class=" px-2 text-center"> {{$item->tanggal_lahir}}</td>
                                <td class=" px-2 text-center"> {{($item->tanggal_masuk)}}</td>
                                <td class=" px-2 text-center"> <?php
                                                                $date = date_create($item->tanggal_masuk);
                                                                echo date_format($date, "Y")
                                                                ?></td>
                                <td class=" text-center flex justify-center gap-1 p-1">
                                    <form action="/guru/{{$item->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class=" bg-red-500 text-white p-1  rounded-md flex"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg></button>
                                    </form>
                                    <a href="/guru/{{$item->id}}/edit" class=" bg-yellow-500 rounded p-1 flex ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td>
                                    Data Tidak ditemukan
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="9">
                                    {{$dataGuru->links()}}
                                </td>
                            </tr>
                        </tbody>
                    </Table>
                </div>
            </div>
        </div>
    </div>
    <div class=" px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 bg-blue-200 border-b border-gray-200">
                    <div class="flex justify-items-end grid-cols-1 gap-2  py-1">
                        <div class=" grid grid-cols-1">
                            <span class=" text-bold">Keterangan :</span>
                            <div class=" px-2">
                                <p>1. Siswa yang berstatus <b>Aktif</b> adalah siswa masih dalam pondok dan mengikuti pembelajaran</p>
                                <p>2. Siswa yang berstatus <b>Lulus</b> adalah siswa sudah dinytakan Selesai dalam mengikuti pembelajaran</p>
                                <p>3. Siswa yang berstatus <b>Boyong</b> adalah siswa yang sudah tidak didalam pondok dan tidak mengikuti pembelajaran</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>