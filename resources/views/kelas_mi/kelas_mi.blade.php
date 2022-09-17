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
                            <Table class=" w-full  border-collapse border border-slate-500 mt-2">
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
                                <tbody>
                                    @if($kelasMI->count() != null)
                                    @foreach ($kelasMI as $item)
                                    <tr class=" hover:bg-green-200 border">
                                        <th class=" text-center border">{{$loop->iteration}}</th>
                                        <td class=" text-center border"> {{$item->periode}} {{$item->ket_semester}}</td>
                                        <td class=" text-center border"><a href="/pesertakelas/{{$item->id}}"> {{$item->kelas}}</a></td>
                                        <td class=" text-center py-2"><a href="/pesertakelas/{{$item->id}}" class=" bg-blue-600 text-white py-1 px-2 rounded-md hover:bg-purple-600">Kelas {{$item->nama_kelas}}</a></td>
                                        <td class=" text-center border"> {{$item->kuota}}</td>
                                        <td class=" text-center border"> {{$item->jumlah_nilai_ujian}}</td>
                                        <td class=" px-2 border text-center w-40">
                                            @if($item->kuota == $item->jumlah_nilai_ujian )
                                            <span class=" bg-yellow-300 px-4 py-1 rounded-md capitalize text-black">full</span>
                                            @elseif ($item->kuota <= $item->jumlah_nilai_ujian)
                                                <span class=" bg-red-600 px-4 py-1 rounded-md capitalize text-white">over</span>
                                                @elseif ($item->kuota >= $item->jumlah_nilai_ujian)
                                                <span class=" bg-green-800 px-4 py-1 rounded-md capitalize text-white">still</span>
                                                @endif
                                        </td>
                                        <td class="  text-center py-1 grid grid-cols-1 ">
                                            <form action="/kelas_mi/{{$item->id}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="  bg-red-600 py-1 px-2 text-white hover:bg-purple-600 rounded-md ">delete</button>
                                            </form>

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