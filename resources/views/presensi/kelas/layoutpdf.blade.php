<div id="body">
    @if($rekapAbsensi)
    <style>
        body,
        #body {
            margin: 0;
            padding: 0;
            font-family: 'sans-serif';
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid green;
            color: green;
            font-size: xx-small;
        }

        .kop_lap {
            text-transform: uppercase;
            justify-content: center;

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
            height: 2px;
            background: black;
            margin: 0;
        }

        td,
        th {
            border: 1px solid black;
            padding: 0;
        }
    </style>
    <div>
        @if($dataKelasMi->jenjang === "Wustho")
        <div class="font-semibold text-3xl uppercase  parent">
            <span class=" kop_lap">MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH</span> <br>
            <span class=" kop_lap">TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}</span>
            <hr class="custom-hr">
            Laporan Harian <br>
            Hari, tanggal : {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
        </div>
        @elseif($dataKelasMi->jenjang === "Ulya")
        <p class="font-semibold text-3xl uppercase">
            MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH
        </p>
        <p class="font-semibold uppercase">
            TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}
        </p>
        @elseif($dataKelasMi->jenjang === "Ula")
        <p class="font-semibold text-3xl uppercase kop_lap">
            <span>MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH</span> <br>
            <span>TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}</span>
            <hr class="custom-hr">
            Laporan Harian <br>
            Hari, tanggal : {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
        </p>
        @endif
    </div>
    <table class="table-fixed  w-full text-green-900">
        <thead class="border border-b-2 border-green-600">
            <tr class="border border-green-600 text-xs sm:text-sm">
                <th class="no_more border border-green-600 w-8">No</th>
                <th class="nama_as border border-green-600 w-1/6">Asrama</th>
                <th class="border border-green-600 w-10">Kls</th>
                <th class="border border-green-600 w-11">Total</th>
                <th class="border border-green-600 w-11">Tidak <br> Hadir</th>
                <th class="border border-green-600 w-11">Hadir</th>
                <th class="border border-green-600 w-1/3 sm:w-1/2">tidak hadir</th>
                <th class="border border-green-600 w-10 sm:w-11">Ket</th>
                <th class="presen border border-green-600 w-1/6">%Kehadiran</th>
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
                <td class="ongko tulis_tengah border border-green-600 text-center" rowspan="{{ $dataKelas['row'] }}">{{ $nomor++ }}</td>
                @endif
                @if ($loop->parent->first && $loop->first)
                <td class="tulis_tengah border border-green-600 text-center text-sm" rowspan="{{ $dataAsrama->sum('row') }}">{{ $nama_asrama }}</td>
                @endif
                @if ($loop->first)
                <td class="tulis_tengah border border-green-600 text-center" rowspan="{{ $dataKelas['row'] }}">{{ $nama_kelas }}</td>
                <td class="tulis_tengah border border-green-600 text-center" rowspan="{{ $dataKelas['row'] }}">{{ $dataKelas['total'] }}</td>
                <td class="tulis_tengah border border-green-600 text-center" rowspan="{{ $dataKelas['row'] }}">{{ $dataKelas['tidakHadir'] }}</td>
                <td class="tulis_tengah border border-green-600 text-center" rowspan="{{ $dataKelas['row'] }}">{{ $dataKelas['hadir'] }}</td>
                @endif
                <td class="nama_sis ket_nama border border-green-600 text-xs capitalize">{{ $dataKelas['tidakHadir'] !== 0 ? $loop->iteration . '. ' . strtolower($absensi->nama_siswa) : 'NIHIL' }}</td>
                <td class="tulis_tengah border border-green-600 text-center capitalize">{{ $dataKelas['tidakHadir'] !== 0 ? $absensi->keterangan : 'NIHIL' }}</td>
                @if ($loop->first)
                <td class="tulis_tengah border border-green-600 text-center" rowspan="{{ $dataKelas['row'] }}">{{ number_format($dataKelas['persentase'], 1, ',') }}%</td>
                @endif
            </tr>
            @endforeach
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endif
</div>