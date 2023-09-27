<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Nilai Per Guru' )
        <h2 class="font-semibold    leading-tight">
            <span class=" uppercase">{{ __('Dashboard Detail Nilai Per Guru ') }} </span><br>
        </h2>
    </x-slot>
    <div class="p-2">
        <div class=" dark:bg-dark-bg bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-1 ">
                <div class=" grid grid-cols-1 text-center py-1  ">
                    <div>
                        {{$title->nama_guru}} <br>
                    </div>
                    <div class=" uppercase font-semibold text-xs">
                        Nomor Induk Guru
                    </div>
                    <div class=" font-semibold">
                        {{$title->nig}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class=" p-2">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4  overflow-auto">
                <table class=" w-full">
                    <thead>
                        <tr class=" border">
                            <th class=" border px-1 py-1">No</th>
                            <th class="  px-1 py-1 hidden sm:block">Periode</th>
                            <th class=" border px-1 py-1">Mata Pelajaran</th>

                            <th class=" border px-1 py-1">Kelas</th>
                            <th class=" border px-1 py-1">Kelas</th>
                            <th class=" border px-1 py-1">NH</th>
                            <th class=" border px-1 py-1">HU</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataguru as $guru)
                        <tr class=" even:bg-gray-100 border ">
                            <th class=" border px-1 py-1">{{$loop->iteration}}</th>
                            <td class="  px-1 py-1 text-center  hidden sm:block">{{$guru->periode}} {{$guru->ket_semester}}</td>
                            <td class=" border px-1 py-1 text-center">
                                <a href="/nilai/{{$guru->id}}">{{$guru->mapel}}</a>
                            </td>
                            <td class=" border px-1 py-1 text-center">
                                <a href="/nilai/{{$guru->id}}">{{$guru->nama_kelas}}</a>
                            </td>
                            <th class=" border text-center px-1">{{$guru->jumlah_peserta_kelas}} </td>
                            <th class=" border text-center px-1">{{$guru->jumlah_nilai_harian}} </td>
                            <th class=" border text-center px-1">{{$guru->jumlah_nilai_ujian}} </td>


                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>