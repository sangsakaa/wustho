<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data Siswa' )
        <h2 class="font-semibold    leading-tight">
            <span class=" uppercase">{{ __('Dashboard Detail Siswa ') }} </span><br>
        </h2>
    </x-slot>
    <div class="p-2 uppercase">
        <div class=" dark:bg-dark-bg bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-1 ">
                <div class=" grid grid-cols-1 text-center py-1">
                    <span class="text-lg">{{ substr($title->nama_siswa, 0, 25) }}{{ strlen($title->nama_siswa) > 20 ? '...' : '' }}</span>


                    <span class=" text-xs  font-semibold">NIS : {{$title->nis}}</span>
                </div>
            </div>
        </div>
        <div class=" mt-2 dark:bg-dark-bg bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 ">
                <div class=" overflow-auto grid sm:grid-cols-4 grid-cols-2 gap-2">
                    <div class=" bg-sky-400 dark:bg-purple-600 py-6 text-center text-white rounded-md">
                        <span class=" capitalize"> MP : </span>
                        <span>{{$jml}}</span>
                    </div>
                    <div class=" bg-sky-400 dark:bg-purple-600 p-6 text-center text-white rounded-md">
                        <span>IPK : {{(number_format($b,2,','))}}</span>
                    </div>
                    <div class=" bg-sky-400 dark:bg-purple-600 p-6 text-center text-white rounded-md">
                        <span>IPK : {{(number_format($b,2,','))}}</span>
                    </div>
                    <div class=" bg-sky-400 dark:bg-purple-600 p-6 text-center text-white rounded-md">
                        <span>IPK : {{(number_format($b,2,','))}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" p-2">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4">
                <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <span class=" text-lg  sm:text-sm uppercase">Riwayat Asrama </span>
                        <table class=" w-full    ">
                            <thead>
                                <tr class=" uppercase border text-sm sm:text-sm bg-gray-100 dark:bg-purple-600">
                                    <th class=" border text-sm sm:text-sm text-center py-1">No</th>
                                    <th class=" border text-sm sm:text-sm text-center"> Periode</th>
                                    <th class=" border text-sm sm:text-sm text-center"> Asrama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Asrama as $user)
                                <tr class=" uppercase border">
                                    <td class="text-xs sm:text-sm  border text-center p-1">
                                        {{$loop->iteration}}
                                    </td>
                                    <td class="text-xs sm:text-sm  border text-center">
                                        {{$user->periode}} {{$user->ket_semester}}
                                    </td>
                                    <td class="text-xs sm:text-sm  border text-center">
                                        {{$user->nama_asrama}}
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <span class=" text-lg  sm:text-sm uppercase">Riwayat Kehadiran </span>
                        <table class=" w-full    ">
                            <thead>
                                <tr class=" uppercase border bg-gray-100 dark:bg-purple-600">
                                    <th class=" border text-sm sm:text-sm text-center py-1">No</th>
                                    <th class=" border text-sm sm:text-sm text-center py-1">Periode</th>
                                    <th class=" border text-sm sm:text-sm text-center py-1">Kelas</th>
                                    <th class="border text-center text-sm sm:text-sm" width="15%">Izin</th>
                                    <th class="border text-center text-sm sm:text-sm" width="15%">Sakit</th>
                                    <th class="border text-center text-sm sm:text-sm" width="15%">Alfa</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($presensi as $user)
                                <tr class=" uppercase border">
                                    <td class=" text-xs sm:text-sm border text-center p-1">
                                        {{$loop->iteration}}
                                    </td>
                                    <td class=" text-xs sm:text-sm border text-center">
                                        {{$user->periode}} {{$user->ket_semester}}
                                    </td>
                                    <td class=" text-xs sm:text-sm border text-center">
                                        {{$user->nama_kelas}}
                                    </td>
                                    <td class=" text-xs sm:text-sm border text-center">
                                        {{$user->izin}}
                                    </td>
                                    <td class=" text-xs sm:text-sm border text-center">
                                        {{$user->sakit}}
                                    </td>
                                    <td class=" text-xs sm:text-sm border text-center">
                                        {{$user->alfa}}
                                    </td>
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
    <div class="py-2 px-2">
        <div class=" overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 bg-sky-300 dark:bg-purple-600  text-white">
                <p class=" uppercase bold">keterangan : </p>
                <p class=" capitalize px-2">1.MP : mata pelajaran</p>
                <p class=" capitalize px-2">2.IPK: index predikat komulatif</p>
            </div>
        </div>
    </div>
</x-app-layout>