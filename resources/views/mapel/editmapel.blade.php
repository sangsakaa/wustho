<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Edit Mata Pelajaran' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mata Pelajaran') }}
        </h2>
    </x-slot>
    <div class="  px-2 py-2">
        <div class=" w-full sm:w-1/2">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" p-6 grid grid-cols-1 sm:grid-cols-1">
                        <form action="/mapel/{{$mapel->id}}" method="post">
                            @csrf
                            @method('patch')
                            <div class=" grid grid-cols-1 w-full ">
                                <label for=""> Mata Pelajaran</label>
                                <input name="mapel" type="text" value="{{$mapel->mapel}}" class=" w-full sm:w-full py-1 " placeholder="  Mapel : Fiqih">
                                <label for="">Nama Kitab</label>
                                <input name="nama_kitab" type="text" value="{{$mapel->nama_kitab}}" class=" w-full py-1 " placeholder="  Mapel : Mabadi' Fiqiyah Juz 1">
                                <label for="">Kelas</label>
                                <select name="kelas_id" id="" class=" py-1  uppercase">
                                    @foreach($datakelas as $list)
                                    {{$list->id}}
                                    <option value="{{$list->id}}" {{ $mapel->kelas_id == $list->id ? "selected" : "" }}>{{$loop->iteration}} </option>
                                    @endforeach
                                </select>
                                <label for="">Periode Pembelajaran</label>
                                <select name="periode_id" id="" class=" py-1  uppercase">
                                    @foreach($dataPeriode as $list)
                                    {{$list->id}}
                                    <option value="{{$list->id}}" {{ $mapel->periode_id == $list->id ? "selected" : "" }}> {{$list->periode}} {{$list->ket_semester}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class=" px-2 py-1 bg-blue-600 text-white rounded-md mt-1">Simpan</button>
                            <a href="/mapel" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                Batal
                            </a>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>