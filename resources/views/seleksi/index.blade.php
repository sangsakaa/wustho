<x-app-layout>
    <x-slot name="header">
        @section('title','| NOMINASI : ' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard Nominasi') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white   px-2 py-2 gap-2">
        <form action="/daftar-seleksi" method="post" class="   w-full">
            @csrf
            <div class=" w-full grid grid-cols-2 gap-1">
                <div class=" grid grid-cols-1">
                    <label for="">Kelas</label>
                    <select name="kelasmi_id" id="" class=" py-1 " required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($daftarKelas as $item)
                        <option value="{{$item->id}}">
                            {{$item->nama_kelas}}
                            {{$item->periode}}
                            {{$item->ket_semester}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class=" grid grid-cols-1">
                    <label for="">Periode Ujian</label>
                    <select name="periode_id" id="" class=" py-1 " required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach($dataPeriode as $item)
                        <option value="{{$item->id}}">
                            {{$item->periode}}
                            {{$item->ket_semester}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class=" grid grid-cols-1">
                    <label for="">Tanggal Mulai</label>
                    <input name="tanggal_mulai" type="date" class=" w-full sm:w-full py-1 " placeholder="  Mapel : Fiqih">
                </div>
                <div class=" grid grid-cols-1">
                    <label for="">Tanggal Selesai</label>
                    <input name="tanggal_selesai" type="date" class=" w-full sm:w-full py-1 " placeholder="  Mapel : Fiqih">
                </div>
                <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 capitalize ">nominasi</button>
            </div>
        </form>
    </div>
    <div class=" bg-white mt-2   px-2 py-2 gap-2">
        <table class=" w-full">
            <thead>
                <tr>
                    <th class=" border text-center px-1 ">No</th>
                    <th class=" border text-center px-1 ">Kelas </th>
                    <th class=" border text-center px-1 ">Periode</th>
                    <th class=" border text-center px-1 ">Tanggal Mulai</th>
                    <th class=" border text-center px-1 ">Tanggal Selesai</th>
                    <th class=" border text-center px-1 capitalize ">act</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nominasi as $item)
                <tr class=" border ">
                    <th>{{$loop->iteration}}</th>
                    <td class=" border text-center">
                        <a href="/daftar-nominasi/{{$item->id}}">
                            {{$item->nama_kelas}}
                        </a>
                    </td>
                    <td class=" border text-center">
                        {{$item->periode}}
                        {{$item->ket_semester}}
                    </td>
                    <td class=" border text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat(' DD MMMM Y') }}
                    </td>
                    <td class=" border text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat(' DD MMMM Y') }}
                    </td>
                    <td class=" border text-center">
                        <form action="daftar-seleksi/{{$item->id}}" method="post" class=" text-red-600">
                            @csrf
                            @method('delete')
                            <button>
                                <x-icons.hapus></x-icons>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>




</x-app-layout>