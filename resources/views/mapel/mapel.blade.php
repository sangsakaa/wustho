<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Mata Pelajaran' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mata Pelajaran') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2 px-2 py-2">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1 sm:grid-cols-2">
                            <form action="/mapel" method="post">
                                @csrf
                                <label for="">Nama Mapel</label>
                                <input name="mapel" type="text" class=" w-full sm:w-full py-1 rounded-md" placeholder="  Mapel : Fiqih">
                                <label for="">Nama Kitab</label>
                                <input name="nama_kitab" type="text" class=" w-full py-1 rounded-md" placeholder="  Mapel : Mabadi' Fiqiyah Juz 1">
                                <label for="">Kelas</label>
                                <select name="kelas_id" id="" class=" w-full py-1 rounded-md">
                                    @foreach($datakelas as $list)
                                    <option value="{{$list->id}}">{{$list->kelas}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class=" px-2 py-1 bg-blue-600 text-white rounded-md mt-1">Simpan</button>
                                <a href="/siswa" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                    Batal
                                </a>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-4 grid grid-cols-1">
                            <span class=" text-2xl">Daftar Mata Pelajaran</span>
                            <table class=" border">
                                <thead class=" border bg-gray-200 ">
                                    <tr class="">
                                        <th class=" border px-2 py-1">#</th>
                                        <th class=" border px-2 text-center">Mata Pelajaran</th>
                                        <th class=" border px-2 text-center">Nama Kitab</th>
                                        <th class=" border px-2 text-center">Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listmapel as $list)
                                    <tr class=" hover:bg-gray-100">
                                        <th class=" border">
                                            <a href="/report/{{$list->id}}"> {{$loop->iteration}}</a>
                                        </th>
                                        <th class=" border px-2 text-left">

                                            <a href="/report/{{$list->id}}"> {{$list->mapel}}</a>
                                        </th>
                                        <th class=" border px-2 text-left">

                                            <a href="/report/{{$list->id}}"> {{$list->nama_kitab}}</a>
                                        </th>
                                        <th class=" border px-2 text-center">

                                            <a href="/report/{{$list->id}}">
                                                {{$list->kelas}}
                                            </a>
                                        </th>

                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>