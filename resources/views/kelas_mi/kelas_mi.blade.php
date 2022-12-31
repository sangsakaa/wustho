<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kelas Wustho' )
        <h2 class="font-semibold text-xl  leading-tight sm:text-left text-center">
            {{ __('Dashboard Kelas') }}
        </h2>
    </x-slot>
    <div class=" ">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="p-2">
                    <div class=" capitalize flex w-full gap-1">
                        <a href="/addkelas_mi">
                            <button class=" flex  uppercase text-xs bg-blue-500 text-white p-1 px-4 hover:bg-purple-600 ">
                                kelas mi
                            </button>
                        </a>
                        <a href="/addasramasiswa">
                            <button class=" flex  uppercase text-xs bg-blue-500 text-white p-1 px-4 hover:bg-purple-600 ">
                                asrama siswa
                            </button>
                        </a>
                        <a href="/sesiasrama">
                            <button class=" flex  uppercase text-xs bg-blue-500 text-white p-1 px-4 hover:bg-purple-600 ">
                                Presensi Asrama
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" mt-2">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm">
                <div class="p-2 ">
                    <div class=" w-full ">
                        <div class=" overflow-auto">
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
                            <div class=" overflow-auto">
                                <Table class=" w-full  border-collapse border border-slate-500 mt-2 ">
                                    <thead>
                                        <tr class=" border dark:bg-purple-600 uppercase text-xs sm:text-xs bg-gray-50 ">
                                            <th class=" border text-xs py-1">No</th>
                                            <th class=" border ">Periode</th>
                                            <th class=" border w-10 px-1">Kelas</th>
                                            <th class=" border ">Nama Kelas</th>
                                            <th class=" border w-10 text-xs text-center px-1">Kuota</th>
                                            <th class=" border  w-10 text-xs text-center">Jml</th>
                                            <th class=" border text-xs text-center">Status</th>
                                            <th class=" border text-xs text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @if($kelasMI->count() != null)
                                        @foreach ($kelasMI as $item)
                                        <tr class=" hover:bg-green-200 border dark:hover:bg-purple-600">
                                            <th class=" text-xs text-center border">{{$loop->iteration}}</th>
                                            <td class=" text-xs text-center border"> {{$item->periode}} {{$item->ket_semester}}</td>
                                            <td class=" text-xs text-center border"><a href="/pesertakelas/{{$item->id}}"> {{$item->kelas}}</a></td>
                                            <td class=" text-xs text-center py-2"><a href="/pesertakelas/{{$item->id}}" class=" text-xs  uppercase font-semibold py-1 px-2 rounded-md sm:xs">{{$item->nama_kelas}}</a></td>
                                            <td class=" text-xs text-center border"> {{$item->kuota}}</td>
                                            <td class=" text-xs text-center border"> {{$item->jumlah_nilai_ujian}}</td>
                                            <td class=" text-xs px-1 border text-center w-40">
                                                @if($item->kuota == $item->jumlah_nilai_ujian )
                                                <span class=" text-xs bg-yellow-300 px-4 py-1 rounded-md capitalize text-black">full</span>
                                                @elseif ($item->kuota <= $item->jumlah_nilai_ujian)
                                                    <span class=" text-xs bg-red-600 px-4 py-1 rounded-md capitalize text-white">over</span>
                                                    @elseif ($item->kuota >= $item->jumlah_nilai_ujian)
                                                    <span class=" text-xs bg-green-800 px-4 py-1 rounded-md capitalize text-white">still</span>
                                                    @endif
                                            </td>
                                            <td class=" text-xs  text-center mt-1   flex gap-1 justify-center  align-middle   ">
                                                <form action="/kelas_mi/{{$item->id}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class=" text-xs bg-red-500 text-white p-1 rounded-md" onclick=" return confirm('apakah anda yakin menhapus data ini: {{$item->nama_kelas}} {{$item->periode}} {{$item->ket_semester}}') "><svg xmlns="http://www.w3.org/2000/svg" class=" text-xsh-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg></button>
                                                </form>
                                                <a href="kelas_mi/{{$item->id}}/edit">
                                                    <button class=" bg-yellow-400 p-1 rounded-md">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                        </svg>
                                                    </button>

                                                </a>

                                            </td>

                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td class=" border text-center" colspan="5">
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
        </div>
    </div>
</x-app-layout>