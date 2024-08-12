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

            font-size: small;
        }



        table,
        th,
        td {
            border: 1px solid #008000;
            /* Hijau dengan kode warna */
            color: #008000;
            border-color: #008000;
            /* Teks hijau dengan kode warna */

        }

        .kop_lap {
            text-transform: uppercase;
            justify-content: center;
            color: #008000;

        }

        .ket_nama {
            width: 290px;
            text-transform: capitalize;
            padding-left: 2px;

        }

        .tulis_tengah {
            text-align: center;
            text-transform: capitalize;
            padding-left: 2;
            padding-right: 2;
        }

        .custom-hr {
            /* border: 1px solid; */
            border-color: #008000;
            height: 2px;

            margin: 0;
            color: #008000;
        }

        td,
        th {
            /* border: 1px solid black; */
            padding: 0;
        }
    </style>
    <div>
        @if($dataKelasMi->jenjang === "Wustho")
        <style>
            .parent {
                display: flex;
                align-items: center;
                /* Center items vertically */
            }

            .logo {
                display: flex;
                align-items: center;
                /* Center items vertically within the logo div and ensure items stay in one line */
            }

            .logo-img {
                /* max-width: 80px; */
                height: 80px;
                margin-right: 5px;
                margin-top: 5px;
                margin-bottom: 5px;
                /* Adjust spacing between the image and text */
            }

            .logo-text {
                display: flex;
                flex-direction: column;
                /* Stack text elements vertically within the logo-text div */
            }

            #container {
                display: flex;
                align-items: center;
            }

            #logo {
                /* margin-right: 20px; */
                text-align: center;
                /* Adjust this value to control the space between logo and title */
            }

            #tittle {
                display: flex;
                flex-direction: column;
            }

            #tittle span {
                text-align: left;
            }

            .kop {
                width: 100%;
                margin-top: 10px;
            }

            td {
                /* border: 1px solid #ddd; */
                text-align: center;
                /* Center text in table cell */
                vertical-align: middle;
                /* Center vertically */
            }

            .center-img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            .nama_cap {
                font-size: 20px;
                font-weight: bold;
                text-transform: capitalize;
            }

            table {
                width: 100%;
            }

            .nama_sis {
                text-align: left;
            }

            h1 {
                text-transform: capitalize;
                text-align: center;
            }
        </style>
        <div>
            <table class=" kop">
                <tr class="h1 ">
                    <td class="logo">
                        <img src="img/logo.png" alt="Public Image" class="logo-img">
                    </td>
                    <td>
                        <div class="logo-text">
                            <span class="kop_lap">MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH</span><br>
                            <span class="kop_lap">TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}</span>
                            <hr class="custom-hr">

                            <span>
                                Laporan Harian <br>
                                Hari, tanggal : {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
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
    <div>

        <table class="table-fixed  w-full text-green-900">
            <thead class="border border-b-2 border-green-600">
                <tr class="judul border border-green-600 text-xs sm:text-sm">
                    <th class="no_more border border-green-600 w-8">No</th>
                    <th class="nama_as border border-green-600 w-1/6">Asrama</th>
                    <th class="border border-green-600 w-10">Kls</th>
                    <th class="border border-green-600 w-11">Total</th>
                    <th class="border border-green-600 w-11">Tidak <br> Hadir</th>
                    <th class="border border-green-600 w-11">Hadir</th>
                    <th class="border border-green-600 w-1/3 sm:w-1/2">Tidak Hadir</th>
                    <th class="border border-green-600 w-10 sm:w-11">Ket</th>
                    <th class="presen border border-green-600 w-1/6">%Hadir</th>
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
</div>
@endif
</div>