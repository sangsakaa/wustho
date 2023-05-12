<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data Siswa' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Detail Siswa ') }}
        </h2>
    </x-slot>
    <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
        <div class="p-4  border-b border-gray-200">
            <div class=" grid sm:grid-cols-4 grid-cols-2">

            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm mt-2 ">
        <div class="p-4  border-b border-gray-200">
            <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2">
                <div>
                    <span class=" text-lg">Detail Riwayat Kelas</span>

                    <table class=" w-full    ">
                        <thead>
                            <tr class=" border bg-gray-100 dark:bg-purple-600">
                                <th class=" border text-center py-1">No</th>
                                <th class=" border text-center"> Periode</th>
                                <th class=" border text-center"> Kelas</th>
                                <th class=" border text-center"> Status Kelas</th>
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
                                    {{$kelas->periode}} {{$kelas->ket_semester}}
                                </td>
                                <td class=" border px-2 text-center ">
                                    {{$kelas->nama_kelas}}
                                </td>
                                <td class=" border px-2 text-center ">
                                    @if($kelas->ket_semester !== "pendek")
                                    <span class=" px-2 py-1 bg-red-500 text-white rounded-md">
                                        x
                                    </span>
                                    @elseif($kelas->ket_semester == "ganji")
                                    <span class=" px-2 py-1 bg-green-500 text-white rounded-md">
                                        pindak
                                    </span>
                                    @else
                                    xx

                                    @endif

                                </td>


                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3" class=" border  text-center text-red-600">
                                    Data Kelas tidak ada
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>