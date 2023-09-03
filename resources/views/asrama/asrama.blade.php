<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Asrama' )
        <h2 class="font-semibold text-xl  leading-tight">
            Dashboard Asrama
        </h2>
    </x-slot>
    <div class="px-4 mt-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" grid grid-cols-1 gap-1">
                        <div class=" flex gap-1 mt-1 justify-end">
                            <a href="/addasrama">
                                <button class=" bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </a>
                            <a href="/asramasiswa">
                                <button class=" bg-blue-500 text-white py-1 px-2 rounded-md d-inline-block">
                                    ASRAMA SISWA
                                </button>
                            </a>
                            <a href="/sesiasrama">
                                <button class=" bg-blue-500 text-white py-1 px-2 rounded-md d-inline-block uppercase">
                                    Presensi Harian
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2 px-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" grid sm:grid-cols-2 grid-cols-1 p-2 bg-white border-b border-gray-200 gap-2 ">
                    <div>
                        <span>Daftar Asrama Putra</span>
                        <Table class=" w-full ">
                            <thead class=" bg-gray-50">
                                <tr class=" border ">
                                    <th class=" py-1">#</th>
                                    <th class=" text-center">Asrama</th>
                                    <th class=" text-center">Type Asrama</th>
                                    @role('super admin')
                                    <th class=" text-center">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @if($Putra->count() != null)
                                @foreach ($Putra as $buah)
                                <tr class=" border hover:bg-green-100 even:bg-gray-100">
                                    <th class=" text-center border">{{$loop->iteration}}</th>
                                    <td class=" text-center border"> {{$buah->nama_asrama}}</td>
                                    <td class=" text-center border"> {{$buah->type_asrama}}</td>
                                    @role('super admin')
                                    <td class=" text-center py-1">
                                        <form action="/asrama/{{$buah->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class=" bg-red-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg></button>
                                        </form>
                                    </td>
                                    @endrole
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>
                                        Data Tidak ditemukan
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </Table>
                    </div>
                    <div>
                        <span>Daftar Asrama Putri</span>
                        <Table class=" w-full ">
                            <thead class=" bg-gray-50">
                                <tr class=" border ">
                                    <th class=" py-1">#</th>
                                    <th class=" text-center">Asrama</th>
                                    <th class=" text-center">Type Asrama</th>
                                    @role('super admin')
                                    <th class=" text-center">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody>
                                @if($Putri->count() != null)
                                @foreach ($Putri as $buah)
                                <tr class=" border hover:bg-green-100 even:bg-gray-100">
                                    <th class=" text-center border">{{$loop->iteration}}</th>
                                    <td class=" text-center border"> {{$buah->nama_asrama}}</td>
                                    <td class=" text-center border"> {{$buah->type_asrama}}</td>
                                    @role('super admin')
                                    <td class=" text-center py-1">
                                        <form action="/asrama/{{$buah->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class=" bg-red-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg></button>
                                        </form>
                                    </td>
                                    @endrole
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>
                                        Data Tidak ditemukan
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </Table>
                    </div>
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
                                <p>1. Untuk Penamabahan <b>Asrama</b> jika tidak ada</p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>