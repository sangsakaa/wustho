<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kelas Wustho' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight sm:text-left text-center">
            {{ __('Dashboard Kelas') }}
        </h2>
    </x-slot>
    <div class="p-2 md:p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class=" grid grid-cols-2 justify-items-end">
                        <!-- <a href="/pesertakolektif">
                            <button class=" bg-blue-600 text-white rounded-sm px-2 py-1 "> Kolektif</button>
                        </a> -->
                        <!-- <a href="/addkelas_mi">
                            <button class=" bg-blue-600 text-white rounded-sm px-2 py-1 "> Kelas Mi</button>
                        </a> -->
                    </div>
                    <div class=" w-full ">
                        <form action="/kelas_mi" method="post">
                            @csrf
                            <div class=" grid grid-cols-1 sm:grid-cols-5 gap-2 sm:gap-2  ">
                                <select name="kelas_id" id="" class=" px-2 py-1    ">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($dataKelas as $item)
                                    <option value="{{$item->id}}">{{$item->kelas}} </option>
                                    @endforeach
                                </select>

                                <select name="periode_id" id="" class=" px-2 py-1    ">
                                    <option value="">-- Pilih Periode --</option>
                                    @foreach ($dataPeriode as $item)
                                    <option value="{{$item->id}}">{{$item->periode}} {{$item->ket_semester}}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="nama_kelas" class=" py-1  " placeholder=" Nama Kelas : 1A">
                                <input type="text" name="kuota" class=" py-1  " placeholder=" Kuota Kelas : 40">
                                <button class=" bg-blue-600 text-white rounded-sm px-2 py-1   "> simpan</button>
                            </div>
                        </form>
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
                            <Table class=" w-full  border-collapse border border-slate-500 ">
                                <thead>
                                    <tr class=" border bg-gray-100 ">
                                        <th class=" py-1">No</th>
                                        <th>Periode</th>
                                        <th>Kelas</th>
                                        <th>Nama Kelas</th>
                                        <th class=" text-center">Kapasitas</th>
                                        <th class=" text-center">Jml Peserta</th>
                                        <th class=" text-center">Status Kelas</th>
                                        <th class=" text-center">Aksi</th>
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
                                                <button class=" text-xs bg-red-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class=" text-xsh-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
</x-app-layout>