<x-app-layout>
    <x-slot name="header">
        @section('title','| NOMINASI : ' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div class=" bg-white   px-2 py-2 gap-2">
        <div class=" grid grid-cols-4">
            <div>Kelas</div>
            <div> : {{$title->nama_kelas}}</div>
            <div>Periode Seleksi</div>
            <div> : {{$title->periode}} {{$title->ket_semester}}</div>
        </div>
        <div>
            <a href="/kolektif-daftar-nominasi/{{$title->id}}">Kolektif</a>
        </div>

    </div>
    <div class=" bg-white mt-2   px-2 py-2 gap-2">
        <table class=" w-full">
            <thead>
                <tr>
                    <th class=" border text-center px-1 ">No</th>
                    <th class=" border text-center px-1 ">Nomor Ujian</th>
                    <th class=" border text-center px-1 ">Nama Peserta Ujian</th>
                    <th class=" border text-center px-1 ">Kelas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarNominasi as $item)
                <tr>
                    <th class=" border px-1">{{$loop->iteration}}</th>
                    <td class=" border px-1 text-center">{{$item->nomor_ujian}}</td>
                    <td class=" border px-1 text-left capitalize">{{strtolower($item->nama_siswa)}}</td>
                    <td class=" border px-1 text-center uppercase">{{strtolower($item->nama_kelas)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>




</x-app-layout>