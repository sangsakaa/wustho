<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rekap Kelas') }}
        </h2>
    </x-slot>
    <div class="p-4 ">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4  border-b border-gray-200">
                <div class=" w-full ">
                    <table class=" w-full">
                        <thead>
                            <tr class="uppercase text-sm border">
                                <th rowspan="2" class=" border">Nama Kelas</th>
                                <th rowspan="2" class=" border">Sesi</th>
                                <th colspan="4" class=" border">keterangan</th>
                                <th colspan="2" class=" border">Total</th>
                            </tr>
                            <tr class="uppercase text-sm border">
                                <th class=" border">Hadir</th>
                                <th class=" border">Sakit</th>
                                <th class=" border">Izin</th>
                                <th class=" border">Alfa</th>
                                <th class=" border">%Alfa</th>
                                <th class=" border">%Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapKelas as $kelas)
                            <tr class=" even:bg-gray-100 hover:bg-gray-200">
                                <td class="text-center border">{{ $kelas->nama_kelas }}</td>
                                <td class="text-center border">{{ $kelas->jumlah_sesi }}</td>
                                <td class="text-center border">{{ $kelas->hadir }}</td>
                                <td class="text-center border">{{ $kelas->sakit }}</td>
                                <td class="text-center border">{{ $kelas->izin }}</td>
                                <td class="text-center border">{{ $kelas->alfa }}</td>
                                <td class="text-center border">{{ number_format($kelas->total_absensi_selain_hadir / $kelas->jumlah_sesi * 100,0,2) }}% </td>
                                <td class="text-center border">{{ number_format($kelas->hadir / $kelas->jumlah_sesi * 100,0,2) }}% </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class=" overflow-auto">

                    <table class="w-full mt-2">
                        <thead>
                            <tr class="uppercase text-sm border">
                                <th>No</th>
                                <th>KLS </th>
                                <th>No </th>
                                <th>Nama </th>
                                <th>I</th>
                                <th>A</th>
                                <th>S</th>
                                <th>Tot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $groupedData = $rekapKelasGuru->groupBy('nama_kelas');
                            @endphp

                            @foreach($groupedData as $namaKelas => $group)
                            @php
                            $rowspanCount = count($group);
                            @endphp

                            @foreach($group as $index => $data)
                            <tr class="border  border-black ">
                                @if($index === 0)
                                <td class=" px-1 border text-center" rowspan="{{ $rowspanCount }}">{{ $loop->parent->iteration }}</td>
                                <td class=" px-1 border   text-center" rowspan="{{ $rowspanCount }}">{{ $namaKelas }}</td>
                                @endif
                                <td class=" px-1 border text-center">{{ $loop->iteration }}</td>
                                <td class=" px-1 border text-left">{{ $data->nama_guru }}</td>
                                <td class=" px-1 border text-center">{{ $data['izin'] }}</td>
                                <td class=" px-1 border text-center">{{ $data['alfa'] }}</td>
                                <td class=" px-1 border text-center">{{ $data['sakit'] }}</td>
                                <td class=" px-1 border text-center">{{ $data['total_absensi_selain_hadir'] }}</td>
                                @if($index === 0)
                                <td rowspan="{{ $rowspanCount }}" class="  px-1 border text-center">
                                    {{$rekapKelasGuru->where('nama_kelas',$data->nama_kelas)->sum('total_absensi_selain_hadir')}}
                                </td>
                                @endif

                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>











                </div>

            </div>
        </div>
    </div>
</x-app-layout>