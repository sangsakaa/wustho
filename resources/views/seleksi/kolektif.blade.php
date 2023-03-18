<x-app-layout>
    <x-slot name="header">
        @section('title','| Daftar Nominasi Kolektif ' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                Daftar Nominasi Kolektif
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

        </div>

    </div>
    <div class=" bg-white mt-2   px-2 py-2 gap-2">
        <form action="/daftar-nominasi/{{$title->id}}" method="post">
            <div>
                <button class=" bg-red-600 px-1 py-0  text-white">Simpan</button>
                <a href="/daftar-nominasi/{{$title->id}}" class=" bg-red-600 px-1  py-1 text-white">Kembali</a>
            </div>
            @csrf
            <table class=" w-full mt-1">
                <thead>
                    <tr>
                        <th class=" border text-center px-1 ">No</th>
                        <th class=" border text-center px-1 "><input type="checkbox" name="pesertakelas[]" id=""></th>
                        <th class=" border text-center px-1 ">Daftar Nominasi </th>
                        <th class=" border text-center px-1 ">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarNominasi as $list)
                    <tr>
                        <input type="hidden" name="nominasi_id" value="{{$nominasi->id}}">
                        <td class=" border px-1 capitalize text-center ">
                            {{$loop->iteration}}
                        </td>
                        <td class=" border px-1 capitalize text-center ">

                            <input type="checkbox" name="pesertakelas[]" value="{{$list->id}}" multiple>
                        </td>
                        <td class=" border px-1 capitalize ">
                            {{strtolower($list->nama_siswa)}}
                        </td>
                        <td class=" border px-1 capitalize text-center ">
                            {{$list->nama_kelas}}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class=" py-1">

            </div>

        </form>

    </div>




</x-app-layout>