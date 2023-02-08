<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Guru' )
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Dashboard Daftar Guru') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm">
        <div class="p-2">
            @if (session('delete'))
            <div class=" py-2 capitalize">
                <div class=" bg-red-500 px-2 py-1 text-white">
                    {{ session('delete') }}
                </div>
            </div>
            @endif
            @if (session('success'))
            <div class=" py-2 capitalize">
                <div class=" bg-green-500 px-2 py-1 text-white">
                    {{ session('success') }}
                </div>
            </div>
            @endif
            @if (session('update'))
            <div class=" py-2 capitalize">
                <div class=" bg-blue-500 px-2 py-1 text-white">
                    {{ session('update') }}
                </div>
            </div>
            @endif
            <div class=" grid gap-2  grid-cols-2   sm:grid-cols-2 w-full ">
                <div class=" sm:w-20 w-20    ">
                    <a href="/addGuru" class=" flex py-1 hover:bg-blue-600    bg-blue-500 text-white   text-center">
                        <span class=" px-1 ">
                            <x-icons.adduser></x-icons.adduser>
                        </span>
                        <span class=" ">
                            Guru
                        </span>
                    </a>
                </div>
                <div class=" flex grid-cols-1 justify-end">
                    <form action="/guru" method="get" class="  gap-1">
                        <div class=" flex gap-2  w-full  ">
                            <input type="text" name="cari" value="{{ request('cari') }}" class=" dark:bg-dark-bg border text-green-800 rounded-sm py-1 w-full  sm:w-full " placeholder=" Cari ...">
                            <button type="submit" class=" px-2 py-1 w-20     bg-blue-500  rounded-sm text-white">
                                Cari </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class=" overflow-auto rounded-md">
                <Table class=" sm:w-full w-full  mt-2">
                    <thead class=" bg-gray-50 dark:bg-purple-600">
                        <tr class=" border  ">
                            <th class="px-2 border py-1">No</th>
                            <th class="px-2 border text-center w-1/2 sm:w-1/4">Nama Guru</th>
                            <th class="px-2 border text-center">JK</th>
                            <th class="px-2 border text-center w-10">Agama</th>
                            <th class="px-2 border text-center">Tempat Lahir</th>
                            <th class="px-2 border text-center w-50">Tanggal Lahir</th>
                            <th class="px-2 border text-center">Tanggal Masuk</th>
                            <th class="px-2 border text-center">Status</th>
                            <th class="px-2 border text-center">Aksi</th>
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
                            <td class=" border px-2 text-center w-10"> {{$item->jenis_kelamin}}</td>
                            <td class=" border px-2 text-center"> {{$item->agama}}</td>
                            <td class=" border px-2 text-center capitalize"> {{$item->tempat_lahir}}</td>
                            <td class=" border px-2 text-center">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMM Y') }} </td>
                            <td class=" border px-2 text-center">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D/M/Y') }} </td>
                            <td class=" border px-2 text-center">{{ $item->status }} </td>
                            <td class="  text-center flex justify-center gap-1 p-1">
                                <form action="/guru/{{$item->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class=" bg-red-500 text-white p-1  rounded-md flex" onclick=" return confirm('apakah anda yakin menghapus data ini: {{$item->nama_guru}}')"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg></button>
                                </form>
                                <a href="/guru/{{$item->id}}/edit" class=" bg-yellow-500 rounded p-1 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg></a>
                                <a href="guru/{{$item->id}}" class=" text-white bg-sky-400 py-0 hover:bg-purple-600  px-2 rounded-sm">
                                    Detail
                                </a>
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
    <div class="bg-white overflow-hidden shadow-sm ">
        <div class="p-2 bg-blue-200 dark:bg-dark-bg ">
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
</x-app-layout>