<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kelas Wustho' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:text-left text-center">
            {{ __('Dashboard Kelas') }}
        </h2>
    </x-slot>
    <div class=" ">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 border-b border-gray-200">
                    <div class=" flex w-full gap-1">
                        <a href="/addkelas_mi">
                            <button class=" flex bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                create kelas mi
                            </button>
                        </a>
                        <a href="/addasramasiswa">
                            <button class=" flex bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                create asrama siswa
                            </button>
                        </a>
                        <a href="/sesiasrama">
                            <button class=" flex bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>

                                Presensi Asrama
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
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
                                        <tr class=" text-xs border bg-gray-100 ">
                                            <th class=" text-xs py-1">No</th>
                                            <th>Periode</th>
                                            <th>Kelas</th>
                                            <th>Nama Kelas</th>
                                            <th class=" text-xs text-center">Kapasitas</th>
                                            <th class=" text-xs text-center">Jml Peserta</th>
                                            <th class=" text-xs text-center">Status Kelas</th>
                                            <th class=" text-xs text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        @if($kelasMI->count() != null)
                                        @foreach ($kelasMI as $item)
                                        <tr class=" hover:bg-green-200 border">
                                            <th class=" text-xs text-center border">{{$loop->iteration}}</th>
                                            <td class=" text-xs text-center border"> {{$item->periode}} {{$item->ket_semester}}</td>
                                            <td class=" text-xs text-center border"><a href="/pesertakelas/{{$item->id}}"> {{$item->kelas}}</a></td>
                                            <td class=" text-xs text-center py-2"><a href="/pesertakelas/{{$item->id}}" class=" text-xs bg-blue-600 text-white py-1 px-2 rounded-md hover:bg-purple-600">Kelas {{$item->nama_kelas}}</a></td>
                                            <td class=" text-xs text-center border"> {{$item->kuota}}</td>
                                            <td class=" text-xs text-center border"> {{$item->jumlah_nilai_ujian}}</td>
                                            <td class=" text-xs px-2 border text-center w-40">
                                                @if($item->kuota == $item->jumlah_nilai_ujian )
                                                <span class=" text-xs bg-yellow-300 px-4 py-1 rounded-md capitalize text-black">full</span>
                                                @elseif ($item->kuota <= $item->jumlah_nilai_ujian)
                                                    <span class=" text-xs bg-red-600 px-4 py-1 rounded-md capitalize text-white">over</span>
                                                    @elseif ($item->kuota >= $item->jumlah_nilai_ujian)
                                                    <span class=" text-xs bg-green-800 px-4 py-1 rounded-md capitalize text-white">still</span>
                                                    @endif
                                            </td>
                                            <td class=" text-xs  text-center mt-2  flex gap-1 justify-center  align-middle   ">
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