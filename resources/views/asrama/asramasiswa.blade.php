<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Asrama Siswa') }}
        </h2>
    </x-slot>
    <div class="  overflow-auto ">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 border-b border-gray-200">
                    <div class=" sm:flex  grid sm:w-full w-full grid-cols-3 text-xs sm:grid-cols-3 gap-1">
                        @can('show post')
                        <a href="/addasrama">
                            <button class=" flex  w-full bg-blue-500 text-white p-2 rounded-md">
                                Tambah Asrama
                            </button>
                        </a>
                        <a href="/addasramasiswa">
                            <button class=" flex w-full bg-blue-500 text-white p-2  rounded-md">
                                Tambah Asrama Siswa
                            </button>
                        </a>
                        @endcan
                        <a href="/sesiasrama">
                            <button class=" flex w-full   bg-blue-500 text-white p-2 rounded-md">
                                Presensi Asrama
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" my-2">
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
                    <div class=" overflow-auto p-1">
                        <Table class=" sm:w-full  w-full">
                            <thead class=" bg-gray-100">
                                <tr class=" border capitalize ">
                                    <th class=" text-center px-1 border py-1">#</th>
                                    @role('super admin')
                                    <th class=" text-center px-1 border ">periode</th>
                                    @endrole
                                    <th class=" text-center px-1 border ">anggota</th>
                                    <th class=" text-center px-1 border "> asrama</th>
                                    <th class=" text-center px-1 border ">asrama </th>
                                    @role('super admin')
                                    <th class=" text-center px-1 border "> kuota</th>
                                    <th class=" text-center px-1 border "> jml</th>
                                    <th class=" text-center px-1 border "> sisa</th>
                                    @endrole
                                    <th class=" text-center px-1 border "> Status</th>
                                    <th class=" text-center px-1 border ">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count())
                                @foreach ($data as $item)
                                <tr class=" border hover:bg-purple-100 ">
                                    <td class=" px-2 border text-center">
                                        {{$loop->iteration}}
                                    </td>
                                    @role('super admin')
                                    <td class=" px-2 border text-center">
                                        <a href="pesertaasrama/{{$item->id}}">
                                            {{$item->periode}}
                                            {{$item->ket_semester}}
                                        </a>
                                    </td>
                                    @endrole
                                    <td class=" px-2 border text-center">
                                        <a href="pesertaasrama/{{$item->id}}" class=" py-1 px-2 hover:bg-purple-600 bg-blue-600 rounded-md capitalize text-center text-white">peserta</a>
                                    </td>
                                    <td class=" px-2 border text-center">
                                        {{$item->nama_asrama}}
                                    </td>
                                    <td class=" px-2 border text-center">
                                        {{$item->type_asrama}}
                                    </td>
                                    @role('super admin')
                                    <td class=" px-2 border text-center">
                                        {{$item->kuota}}
                                    </td>
                                    <td class=" px-2 border text-center ">
                                        {{$item->jumlah_nilai_ujian}}
                                    </td>
                                    <td class=" px-2 border text-center ">
                                        {{($item->kuota)-($item->jumlah_nilai_ujian)}}
                                    </td>
                                    @endrole
                                    <td class=" px-2 border text-center ">
                                        @if($item->kuota == $item->jumlah_nilai_ujian )
                                        <span class=" bg-yellow-300 px-4 py-1 rounded-md capitalize text-black">full</span>
                                        @elseif ($item->kuota <= $item->jumlah_nilai_ujian)
                                            <span class=" bg-red-600 px-4 py-1 rounded-md capitalize text-white">over</span>
                                            @elseif ($item->kuota >= $item->jumlah_nilai_ujian)
                                            <span class=" bg-green-800 px-4 py-1 rounded-md capitalize text-white">still</span>
                                            @endif
                                    </td>
                                    <td class="  py-1 px-2 sm:flex  justify-center gap-2">
                                        @role('super admin')
                                        <form action="/asramasiswa/{{$item->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class=" bg-red-500 text-white p-1 rounded-md" onclick=" return confirm('apakah anda yakin menghapus data ini : {{$item->nama_asrama}}')"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg></button>
                                        </form>
                                        @endrole
                                        <a href="asramasiswa/{{$item->id}}/edit">
                                            <button class=" bg-yellow-400 p-1 rounded-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </button>
                                        </a>
                                        <a href="pesertaasrama/{{$item->id}}">
                                            <button class=" bg-sky-400 p-1 rounded-md hover:bg-purple-600 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class=" text-center border">
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
    <div class="my-2 overflow-auto ">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 bg-blue-200 border-b border-gray-200">
                    <div class="flex justify-items-end grid-cols-1 gap-2  py-1">
                        <div class=" grid grid-cols-1">
                            <span class=" text-bold">Keterangan :</span>
                            <div class=" px-2">
                                <p class=" capitalize">1. Untuk penambahan <b>anggota asrama </b> <u>wajib</u> memiliki <b><u>NIS (nomor induk siswa)</u></b> </p>
                                <p class=" capitalize">2. jika tidak memili harap <b>NIS (nomor induk siswa)</b> konfimasi ke pihak madin bagian <b>kesiswaan & kepala sekolah</b> </p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>