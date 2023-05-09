<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Tambah Mata Pelajaran' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Mata Pelajaran') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">
        <div class="">
            <div class=" w-full sm:w-1/2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1 sm:grid-cols-1">
                            <form action="/mapel" method="post">
                                @csrf
                                <div class=" grid grid-cols-1 w-full ">
                                    <label for="">Nama Mapel</label>
                                    <input name="mapel" type="text" class=" w-full sm:w-full py-1 " placeholder="  Mapel : Fiqih">
                                    <label for="">Nama Kitab</label>
                                    <input name="nama_kitab" type="text" class=" w-full py-1 " placeholder="  Mapel : Mabadi' Fiqiyah Juz 1">
                                    <label for="">Kelas</label>
                                    <select name="kelas_id" id="" class=" w-full py-1 ">
                                        @foreach($datakelas as $list)
                                        <option value="{{$list->id}}">{{$list->kelas}}</option>
                                        @endforeach
                                    </select>
                                    <label for="">Periode Pembelajaran</label>
                                    <select name="periode_id" id="" class=" py-1  uppercase">
                                        @foreach($dataPeriode as $list)
                                        {{$list->id}}
                                        <option value="{{$list->id}}"> {{$list->periode}} {{$list->ket_semester}} </option>
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
    </div>
</x-app-layout>