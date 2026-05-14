<div class="space-y-6">

    {{-- ===================== REKAP KELAS ===================== --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="px-4 py-3 border-b bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                Rekap Absensi Kelas
            </h2>

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th rowspan="2" class="px-3 py-2 border">Nama Kelas</th>
                        <th rowspan="2" class="px-3 py-2 border">Sesi</th>
                        <th colspan="4" class="px-3 py-2 border text-center">Keterangan</th>
                        <th colspan="2" class="px-3 py-2 border text-center">Persentase</th>
                    </tr>
                    <tr>
                        <th class="px-3 py-2 border">Hadir</th>
                        <th class="px-3 py-2 border">Sakit</th>
                        <th class="px-3 py-2 border">Izin</th>
                        <th class="px-3 py-2 border">Alfa</th>
                        <th class="px-3 py-2 border">% Alfa</th>
                        <th class="px-3 py-2 border">% Hadir</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach($rekapKelas as $kelas)
                    @php
                    $sesi = max($kelas->jumlah_sesi, 1);
                    $alfa = ($kelas->total_absensi_selain_hadir / $sesi) * 100;
                    $hadir = ($kelas->hadir / $sesi) * 100;
                    @endphp

                    <tr class="hover:bg-gray-50 even:bg-gray-50">
                        <td class="px-3 py-2 text-center border">{{ $kelas->nama_kelas }}</td>
                        <td class="px-3 py-2 text-center border">{{ $kelas->jumlah_sesi }}</td>
                        <td class="px-3 py-2 text-center border">{{ $kelas->hadir }}</td>
                        <td class="px-3 py-2 text-center border">{{ $kelas->sakit }}</td>
                        <td class="px-3 py-2 text-center border">{{ $kelas->izin }}</td>
                        <td class="px-3 py-2 text-center border">{{ $kelas->alfa }}</td>
                        <td class="px-3 py-2 text-center border">
                            {{ number_format($alfa, 2) }}%
                        </td>
                        <td class="px-3 py-2 text-center border">
                            {{ number_format($hadir, 2) }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- ===================== REKAP GURU ===================== --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="px-4 py-3 border-b bg-gray-50">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide">
                Rekap Absensi Guru per Kelas
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase">
                    <tr>
                        <th class="px-3 py-2 border">No</th>
                        <th class="px-3 py-2 border">Kelas</th>
                        <th class="px-3 py-2 border">No</th>
                        <th class="px-3 py-2 border text-left">Nama Guru</th>
                        <th class="px-3 py-2 border">Izin</th>
                        <th class="px-3 py-2 border">Alfa</th>
                        <th class="px-3 py-2 border">Sakit</th>
                        <th class="px-3 py-2 border">Total</th>
                        <th class="px-3 py-2 border">Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $groupedData = $rekapKelasGuru->groupBy('nama_kelas');
                    @endphp

                    @foreach($groupedData as $namaKelas => $group)
                    @php $rowspanCount = count($group); @endphp

                    @foreach($group as $index => $data)
                    <tr class="hover:bg-gray-50 even:bg-gray-50">

                        @if($index === 0)
                        <td rowspan="{{ $rowspanCount }}" class="px-2 py-2 border text-center font-semibold">
                            {{ $loop->parent->iteration }}
                        </td>
                        <td rowspan="{{ $rowspanCount }}" class="px-2 py-2 border text-center font-semibold">
                            {{ $namaKelas }}
                        </td>
                        @endif

                        <td class="px-2 py-2 border text-center">{{ $loop->iteration }}</td>
                        <td class="px-2 py-2 border text-left">{{ $data->nama_guru }}</td>
                        <td class="px-2 py-2 border text-center">{{ $data->izin }}</td>
                        <td class="px-2 py-2 border text-center">{{ $data->alfa }}</td>
                        <td class="px-2 py-2 border text-center">{{ $data->sakit }}</td>
                        <td class="px-2 py-2 border text-center font-medium">
                            {{ $data->total_absensi_selain_hadir }}
                        </td>

                        @if($index === 0)
                        <td rowspan="{{ $rowspanCount }}" class="px-2 py-2 border text-center font-bold bg-gray-50">
                            {{ $group->sum('total_absensi_selain_hadir') }}
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