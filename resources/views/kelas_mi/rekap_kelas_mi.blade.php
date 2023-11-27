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
                    <table class=" w-1/2">
                        <thead>
                            <tr class=" uppercase text-xs">
                                <th class=" border">Nama Kelas</th>
                                <th class=" border">Hadir</th>
                                <th class=" border">Sakit</th>
                                <th class=" border">Izin</th>
                                <th class=" border">Alfa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekapKelas as $kelas)
                            <tr>
                                <td class=" text-center border ">{{ $kelas->nama_kelas }}</td>
                                <td class=" text-center border ">{{ $kelas->jumlah_sesi }}</td>
                                <td class=" text-center border ">{{ $kelas->sakit }}</td>
                                <td class=" text-center border ">{{ $kelas->izin }}</td>
                                <td class=" text-center border ">{{ $kelas->alfa }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>