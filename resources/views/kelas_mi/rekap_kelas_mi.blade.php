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
                            <tr class=" uppercase text-xs">
                                <th rowspan="2" class=" border">Nama Kelas</th>
                                <th rowspan="2" class=" border">Sesi</th>
                                <th colspan="4" class=" border">keterangan</th>
                                <th colspan="2" class=" border">Total</th>
                            </tr>
                            <tr>
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

            </div>
        </div>
    </div>
</x-app-layout>