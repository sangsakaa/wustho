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
                <div class=" grid grid-cols-1 text-center py-1">
                    <div>
                        {{$title->nama_guru}} <br>
                    </div>
                    <div class=" uppercase font-semibold">
                        Nomor Induk Guru
                    </div>
                    <div>
                        {{$title->nig}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class=" p-2">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 overflow-hidden">
                <table class=" w-full">
                    <thead>
                        <tr>
                            <th class=" border px-1 py-1">No</th>
                            <th class=" border px-1 py-1">Periode</th>
                            <th class=" border px-1 py-1">Mata Pelajaran</th>
                            <th class=" border px-1 py-1">Kitab</th>
                            <th class=" border px-1 py-1">Kelas</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataguru as $guru)
                        <tr class=" even:bg-gray-100">
                            <th class=" border px-1 py-1">{{$loop->iteration}}</th>
                            <td class=" border px-1 py-1 text-center">{{$guru->periode}} {{$guru->ket_semester}}</td>
                            <td class=" border px-1 py-1 text-center">{{$guru->mapel}}</td>
                            <td class=" border px-1 py-1 text-center">{{$guru->nama_kitab}}</td>
                            <td class=" border px-1 py-1 text-center">
                                <a href="/nilai/{{$guru->id}}">{{$guru->nama_kelas}}</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class=" border px-1 py-1 text-center" colspan="4">Total Mata Pelajaran</td>
                            <td class=" border px-1 py-1 text-center">{{$dataguru->count()}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>