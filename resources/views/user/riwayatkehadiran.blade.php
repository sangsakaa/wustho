<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Riwayat Kehadiran' )
        <h2 class="font-semibold text-xl leading-tight uppercase sm:text-xl">
            {{ __('Riwayat Kehadiran ') }}
        </h2>
    </x-slot>
    <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
        <div class="p-2  border-b border-gray-200">
            <div class=" grid sm:grid-cols-1 grid-cols-1 text-sm text-center sm:text-xl uppercase">
                <div>
                    <span class="text-lg">{{ substr($title->nama_siswa, 0, 25) }}{{ strlen($title->nama_siswa) > 20 ? '...' : '' }}</span>
                </div>
                <div>
                    {{$title->nis}}
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm mt-2 ">
        <div class="p-4  border-b border-gray-200">
            <div class=" grid grid-cols-1  text-xs sm:text-sm sm:grid-cols-1 gap-2">
                <div class=" overflow-auto">
                    <table class=" w-full sm:w-1/4">
                        <thead>
                            <tr class=" border bg-gray-100 dark:bg-purple-600">
                                <td class=" px-1 py-1 border text-center font-semibold " colspan="4">KETERANGAN</td>
                            </tr>
                            <tr>
                                <th class=" px-1 py-1 border ">HADIR</th>
                                <th class=" px-1 py-1 border ">IZIN</th>
                                <th class=" px-1 py-1 border ">SAKIT</th>
                                <th class=" px-1 py-1 border ">ALFA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class=" border text-center">{{$hadir}}</td>
                                <td class=" border text-center">{{$izin}}</td>
                                <td class=" border text-center">{{$sakit}}</td>
                                <td class=" border text-center">{{$alfa}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <span class=" text-lg">Detail Riwayat Kehadiran Kelas</span>
                    <table class=" w-full    ">
                        <thead>
                            <tr class=" border bg-gray-100 dark:bg-purple-600">
                                <th class=" border text-center py-1">No</th>

                                <th class=" border text-center"> Tgl</th>
                                <th class=" border text-center"> Periode</th>
                                <th class=" border text-center"> KLS</th>
                                <th class=" border text-center"> Ket</th>
                                <!-- <th class=" border text-center"> Alasan</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if($siswa->count() != null)
                            @foreach($siswa as $kelas)
                            <tr>
                                <td class=" border px-2 py-1 text-center ">
                                    {{$loop->iteration}}
                                </td>

                                <td class=" border px-2 text-center ">
                                    {{date('d/m/Y',strtotime($kelas->tgl))}}
                                </td>
                                <td class=" border px-2 text-center ">
                                    {{$kelas->periode}} {{$kelas->ket_semester}}
                                </td>
                                <td class=" border px-2 text-center ">
                                    {{$kelas->nama_kelas}}
                                </td>
                                <td class=" border px-2 text-center capitalize ">
                                    {{$kelas->keterangan}}

                                </td>
                                <!-- <td class=" border px-2 text-center capitalize ">
                                    {{$kelas->alasan}}
                                </td> -->

                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class=" border  text-center text-red-600">
                                    Presensis Kehadiran Tidak ada
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class=" py-1 text-xs">

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>