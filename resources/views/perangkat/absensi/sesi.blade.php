<x-app-layout>
    <x-slot name="header">
        @section('title', ' |Sesi Perangkat '.$hariIni )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Sesi Perangkat : '.$hariIni) }}
        </h2>
    </x-slot>
    <div class=" bg-white p-2 sm:p-2  ">
        <div class=" flex gap-2">
            <form action="/sesi-perangkat" method="post">
                @csrf
                <button class=" bg-blue-600 text-white rounded-md px-2 py-1">buat Sesi</button>
            </form>
            <a href="/laporan-harian-perangkat" class=" bg-blue-600 text-white rounded-md px-2 py-1">Laporan Harian</a>
        </div>
    </div>
    <div class=" mt-2 bg-white p-2 sm:p-2  ">
        <div>
        </div>
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
                <tr class=" border border-green-800 px-1 text-center">
                    <td class=" border border-green-800 px-1 text-center">{{$loop->iteration}}</td>
                    <td class=" border border-green-800 px-1 text-center"><a href="/daftar-sesi-perangkat/{{$org->id}}">
                            {{ \Carbon\Carbon::parse($org->tanggal)->isoFormat(' dddd ,DD MMMM Y') }}

                        </a>
                    </td>
                    <td class=" border border-green-800 px-1 text-center">
                        {{$org->periode}}
                        {{$org->ket_semester}}
                    </td>
                    <td class=" border border-green-800 px-1 text-center">

                        @if($org->SesiP !== null)
                        sudah di absen
                        @else
                        <span class=" text-red-600">Belum di absensi</span>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>