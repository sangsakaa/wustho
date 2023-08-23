<x-app-layout>
    <x-slot name="header">
        @section('title', ' |Sesi Perangkat '.\Carbon\Carbon::parse($hariIni)->isoFormat(' dddd ,DD MMMM Y') )
        <h2 class="font-semibold sm:text-xl  text-sm leading-tight">
            {{ __('Sesi Perangkat : '.\Carbon\Carbon::parse($hariIni)->isoFormat(' dddd ,DD MMMM Y')) }}
        </h2>
    </x-slot>
    <div class=" bg-white p-2 sm:p-2  ">
        <div class=" flex  grid-cols-1 gap-2 px-2  mt-2">
            <div>
                <form action="/sesi-perangkat" method="get" class=" flex gap-1">
                    <input type="date" name="tanggal" value="{{ $tanggal->toDateString() }}" class=" border border-green-800 text-green-800 rounded-md py-1 dark:bg-dark-bg " placeholder=" Cari ..">
                    <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                        Tanggal </button>
                </form>
            </div>
            <div>
                <form action="/sesi-perangkat" method="post">
                    <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}" class=" border border-green-800 text-green-800 rounded-md py-1 dark:bg-dark-bg " placeholder=" Cari ..">
                    @csrf
                    <button class=" bg-blue-600 text-white rounded-md px-2 py-1">buat Sesi</button>
                </form>
            </div>
            <a href="/laporan-harian-perangkat" class=" hidden sm:block bg-blue-600 text-white rounded-md px-2 py-1">Laporan Harian</a>
            <a href="/laporan-Bulanan-perangkat" class="hidden sm:block bg-blue-600 text-white rounded-md px-2 py-1">Laporan Bulanan</a>
        </div>
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">

            <div class=" mt-2 bg-white p-2 sm:p-2  ">
                <div>
                    @if (session('delete'))
                    <div class="py-2">
                        <div class="bg-red-500 px-2 py-1 text-white">
                            {{ session('delete') }}
                        </div>
                    </div>
                    @endif
                    @if (session('success'))
                    <div class="py-2">
                        <div class="bg-green-500 px-2 py-1 text-white">
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif
                    @if (session('update'))
                    <div class="py-2">
                        <div class="bg-blue-500 px-2 py-1 text-white">
                            {{ session('update') }}
                        </div>
                    </div>
                    @endif
                </div>
                <div class=" overflow-auto">
                    <table class=" w-full">
                        <thead>
                            <tr class=" border border-green-800 px-1 bg-gray-100 ">
                                <th class=" border border-green-800 px-1 ">No</th>
                                <th class=" border border-green-800 px-1 ">Tanggal</th>
                                <th class=" border border-green-800 px-1 ">Periode</th>
                                <th class=" border border-green-800 px-1 ">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataSesiPerangkat as $org)
                            <tr class=" border border-green-800 text-xs sm:text-sm px-1 text-center">
                                <td class=" border border-green-800 px-1 text-center">{{$loop->iteration}}</td>
                                <td class=" border border-green-800 px-1 text-center"><a href="/daftar-sesi-perangkat/{{$org->id}}">
                                        {{ \Carbon\Carbon::parse($org->tanggal)->isoFormat(' dddd ,DD MMMM Y') }}

                                    </a>
                                </td>
                                <td class=" border border-green-800 px-1 text-center sm:text-sm  text-xs">
                                    {{$org->periode}}
                                    {{$org->ket_semester}}
                                </td>
                                <td class=" border  px-1 sm:text-center justify-items-center grid ">
                                    @if($org->SesiP !== null)
                                    <span class=" hidden sm:block">sudah di absen</span>
                                    <span class="  block  sm:hidden text-center"> <x-icons.check class="w-5 h-5 text-green-600" aria-hidden="true" /></span>

                                    @else
                                    <span class=" hidden sm:block">Belum di absensi</span>
                                    <span class="  block  sm:hidden text-center"><x-icons.x-mark class="w-5 h-5 text-red-600" aria-hidden="true" /></span>

                                    @endif

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
</x-app-layout>