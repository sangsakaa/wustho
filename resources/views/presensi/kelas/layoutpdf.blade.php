<div id="body" class="mx-auto">
    @if($rekapAbsensi)
    <style>
        #body {
            margin-top: 0;
        }

        body {
            font-family: 'sans-serif';
        }

        table {
            width: 100%;
            border-collapse: collapse;

        }

        table,
        th,
        td {
            border: 1px solid black;
            font-size: small;
            padding: 2px;
            /* Added padding for table cells */
        }

        .kop_lap {
            text-transform: uppercase;
            text-align: center;
        }

        .ket_nama {
            width: 270px;
            text-transform: capitalize;
        }

        .tulis_tengah {
            text-align: center;
        }

        .custom-hr {
            border: none;
            /* Removed default border */
            height: 2px;
            background: black;
            margin: 2px 0;
            /* Set margin to 2px */
        }
    </style>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-2 bg-white border-b border-gray-200">
            <div class="py-1">
                <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm" id="blanko">
                    <div class="p-1">
                        <div class="overflow-auto bg-white dark:bg-dark-bg">
                            <div class="text-center text-green-900">
                                @if($dataKelasMi->jenjang === "Wustho")
                                <p class="font-semibold text-3xl uppercase kop_lap">
                                    <span>MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH</span> <br>
                                    <span>TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}</span>
                                    <hr class="custom-hr">
                                    Laporan Harian <br>
                                    Hari, tanggal : {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                                @elseif($dataKelasMi->jenjang === "Ulya")
                                <p class="font-semibold text-3xl uppercase">
                                    MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH
                                </p>
                                <p class="font-semibold uppercase">
                                    TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}
                                </p>
                                @elseif($dataKelasMi->jenjang === "Ula")
                                <p class="font-semibold text-3xl uppercase">
                                    MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH
                                </p>
                                <p class="font-semibold uppercase">
                                    TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}
                                </p>
                                @endif
                            </div>
                            <div class="overflow-auto">
                                <table class="table-fixed w-full text-green-900">
                                    <thead class="border border-b-2 border-green-600">
                                        <tr class="border border-green-600 text-xs sm:text-sm">
                                            <th class="no_more border border-green-600 px-1 w-8">No</th>
                                            <th class="nama_as border border-green-600 px-1 w-1/6">Asrama</th>
                                            <th class="border border-green-600 px-1 w-10">Kls</th>
                                            <th class="border border-green-600 px-1 w-11">Total</th>
                                            <th class="border border-green-600 px-1 w-11">Tidak <br> Hadir</th>
                                            <th class="border border-green-600 px-1 w-11">Hadir</th>
                                            <th class="border border-green-600 px-1 w-1/3 sm:w-1/2">tidak hadir</th>
                                            <th class="border border-green-600 px-1 w-10 sm:w-11">Ket</th>
                                            <th class="presen border border-green-600 px-1 w-1/6">%Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        @php
                                        $nomor = 1;
                                        @endphp
                                        @foreach ($rekapAbsensi as $nama_asrama => $dataAsrama)
                                        @foreach ($dataAsrama as $nama_kelas => $dataKelas)
                                        @foreach ($dataKelas['absensi'] as $absensi)

                                        <tr class="border border-green-600 text-xs sm:text-sm">
                                            @if ($loop->first)
                                            <td class="ongko tulis_tengah border border-green-600 text-center px-1" rowspan="{{ $dataKelas['row'] }}">{{ $nomor++ }}</td>
                                            @endif
                                            @if ($loop->parent->first && $loop->first)
                                            <td class="tulis_tengah border border-green-600 px-1 text-center text-sm" rowspan="{{ $dataAsrama->sum('row') }}">{{ $nama_asrama }}</td>
                                            @endif
                                            @if ($loop->first)
                                            <td class="tulis_tengah border border-green-600 text-center px-1" rowspan="{{ $dataKelas['row'] }}">{{ $nama_kelas }}</td>
                                            <td class="tulis_tengah border border-green-600 text-center px-1" rowspan="{{ $dataKelas['row'] }}">{{ $dataKelas['total'] }}</td>
                                            <td class="tulis_tengah border border-green-600 text-center px-1" rowspan="{{ $dataKelas['row'] }}">{{ $dataKelas['tidakHadir'] }}</td>
                                            <td class="tulis_tengah border border-green-600 text-center px-1" rowspan="{{ $dataKelas['row'] }}">{{ $dataKelas['hadir'] }}</td>
                                            @endif
                                            <td class="nama_sis ket_nama border border-green-600 px-1 text-xs capitalize">{{ $dataKelas['tidakHadir'] !== 0 ? $loop->iteration . '. ' . strtolower($absensi->nama_siswa) : 'NIHIL' }}</td>
                                            <td class="tulis_tengah border border-green-600 px-1 text-center capitalize">{{ $dataKelas['tidakHadir'] !== 0 ? $absensi->keterangan : 'NIHIL' }}</td>
                                            @if ($loop->first)
                                            <td class="tulis_tengah border border-green-600 text-center px-1" rowspan="{{ $dataKelas['row'] }}">{{ number_format($dataKelas['persentase'], 1, ',') }}%</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>