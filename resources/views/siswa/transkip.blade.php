<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Transkip Nilai ' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transkip Nilai') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class="px-1 py-2 bg-white border-b border-gray-200 flex gap-1">
                        @role('admin')
                        <a href="/addsiswa">
                            <button class=" bg-blue-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </a>
                        @endrole
                        <form action="/transkip" method="get" class=" flex gap-1">
                            <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari ..">

                            <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                Cari </button>

                        </form>

                    </div>

                    <table class=" w-full">
                        <thead>
                            <tr class=" border bg-gray-100">
                                <th class=" px-2 py-1 border capitalize">no</th>
                                <th class=" px-2 border capitalize">Peserta Kelas</th>
                                <th class=" px-2 border capitalize">Kelas</th>
                                <th class=" px-2 border capitalize">Mata Pelajaran</th>
                                <th class=" px-2 border capitalize text-center">nilai harian</th>
                                <th class=" px-2 border capitalize text-center">nilai ujian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $nilai)
                            <tr class=" hover:bg-gray-50">
                                <th class=" border w-5">{{$loop->iteration}}</th>
                                <td class=" px-2 border">{{$nilai->nama_siswa}}</td>
                                <td class=" px-2 border w-5 text-center">{{$nilai->nama_kelas}}</td>
                                <td class=" px-2 border">{{$nilai->mapel}}</td>
                                <td class=" px-2 border w-40 text-center">{{$nilai->nilai_harian}}</td>
                                <td class=" px-2 border w-40 text-center">{{$nilai->nilai_ujian}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class=" px-2 border  text-center" colspan="4">Jumlah Nilai</td>
                                <td class=" px-2 border  text-center">{{$harian}}</td>
                                <td class=" px-2 border  text-center">{{$ujian}}</td>

                            </tr>
                            <tr>
                                <td class=" px-2 border  text-center " colspan="4">
                                    Rata Rata
                                </td>
                                <td class=" px-2 border  text-center " colspan="1">
                                    {{number_format($rata2harian,2,',')}}
                                </td>
                                <td class=" px-2 border  text-center " colspan="1">
                                    {{number_format($rata2ujian,2,',')}}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>