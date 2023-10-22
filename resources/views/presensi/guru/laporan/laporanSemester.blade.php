<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Guru')
        <h2 class="font-semibold sm:text-xl leading-tight text-sm">

            {{ __(' Laporan Bulanan Presensi Guru ') }} <br>

        </h2>
    </x-slot>

    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>
    <div class=" ">
        <div class="p-2 bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
            <div class=" overflow-auto bg-white dark:bg-dark-bg mt-1 ">
                <div class=" px-2 grid grid-cols-2">
                    <div>
                        <form action="/laporan-semester-guru" method="get" class="mr-auto">
                            <?php
                            // set timezone ke timezone yang diinginkan
                            date_default_timezone_set("Asia/Jakarta");

                            // buat variabel $tanggal dengan format Y-m (tahun-bulan) dari tanggal saat ini
                            $tanggal = date("Y-m");

                            // buat variabel $bulan dengan nama bulan berdasarkan format F (full month name) dari tanggal saat ini
                            $bulan = date("F", strtotime($tanggal . "-01"));

                            // periksa apakah nilai 'bulan' dikirimkan sebagai parameter dalam permintaan 'GET'
                            if (isset($_GET['bulan'])) {
                                $bulan = date("F", strtotime($_GET['bulan'] . "-01"));
                            }
                            ?>
                            <input type="month" name="bulan" class="py-1 dark:bg-dark-bg" value="<?= isset($_GET['bulan']) ? $_GET['bulan'] : $tanggal ?>">
                            <!-- tambahkan elemen <span> untuk menampilkan nama bulan -->
                            <button class="bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4">
                                Pilih Bulan
                            </button>
                        </form>

                    </div>
                    <div class="  flex gap-2  justify-end ">
                        <a href="/sesi-presensi-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Kembali
                        </a>
                        <a href="/laporan-semester-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            refresh
                        </a>
                        <div class=" mt-2">
                            <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                                <x-icons.print></x-icons.print>
                                Cetak</button>
                        </div>
                    </div>
                </div>
                <div id="div1">
                    <style>
                        .page-break {
                            page-break-after: always;
                        }
                    </style>
                    <div class=" text-center text-green-700 block    ">
                        <div class=" flex">
                            <div><img src={{ asset("asset/images/logo.png") }} alt="" width="110" class=" px-2"></div>
                            <div class=" w-full grid justify-center  ml-5 ">
                                </p>
                                <p class="   text-lg uppercase">departemen Pendidikan Diniyah Wahidiyah</p>
                                <p class="  uppercase  text-2xl font-semibold text-monospace ">madrasah diniyah wustho
                                    Wahidiyah</p>
                                <p class=" hidden capitalize  text-xs">Alamat : Jl.KH. Wachid Hasyim Kota Kediri 64114 Jawa Timur Telp. (0354) 774511, 771018 Fax. (0354) 772179</p>
                                <p class=" font-semibold uppercase"> Tahun Pelajaran {{$kelasmi->periode}} {{$kelasmi->ket_semester}} </p>
                            </div>
                        </div>
                        <hr class=" border-b-2 border-green-700  mb-0.5 mt-1">
                        <hr class=" border-b-1 border-green-700 mb-1">
                        <div class="  uppercase px-1 text-center">
                            <p class=" uppercase font-semibold ">laporan presensi Guru : Bulan {{ \Carbon\Carbon::parse(  $bulan)->isoFormat('  MMMM ') }} </p>

                            <p class=" font-semibold uppercase"> semester {{$kelasmi->ket_semester}} Tahun Pelajaran {{$kelasmi->periode}}</p>
                        </div>
                    </div>
                    <div class="px-2">
                        <table class="  w-full">
                            <thead>
                                <tr class="border border-green-800">


                                    <th rowspan="2" class="border border-green-800 px-1">Nama </th>
                                    <th rowspan="2" class="border border-green-800 px-1 w-5">Kls</th>
                                    <th rowspan="2" class="border border-green-800 px-1 w-5">Total</th>
                                    <th rowspan="2" class="border border-green-800 px-1">Sesi</th>
                                    <th colspan="5" class="border border-green-800 px-1">Keterangan</th>
                                    <th colspan="6" class="border border-green-800 px-1">Terjadwal Hari</th>
                                </tr>
                                <tr class="border border-green-800 ">
                                    <th class="border border-green-800 px-1 w-5 ">H</th>
                                    <th class="border border-green-800 px-1 w-5 ">I</th>
                                    <th class="border border-green-800 px-1 w-5 ">S</th>
                                    <th class="border border-green-800 px-1 w-5 ">A</th>
                                    <th class="border border-green-800 px-1   w-16   ">% H</th>
                                    <th class="border border-green-800 text-xs  w-10">Jumat</th>
                                    <th class="border border-green-800 text-xs  w-10">Sabtu</th>
                                    <th class="border border-green-800 text-xs  w-10">Minggu</th>
                                    <th class="border border-green-800 text-xs  w-10">Senin</th>
                                    <th class="border border-green-800 text-xs  w-10">Selasa</th>
                                    <th class="border border-green-800 text-xs  w-10">Rabu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan->groupBy('nama_guru') as $nama_guru => $laporanGuru)
                                @if ($laporanGuru->isEmpty())
                                <tr>

                                    <td class="border border-green-800 px-1" colspan="13">No schedule available.</td>
                                </tr>
                                @else
                                @foreach($laporanGuru as $index => $data)
                                <tr class="border border-green-800  {{ $index === 0 ? 'border-t-2' : '' }}">

                                    @if ($index === 0)
                                    <td class="border border-green-800 px-1 py-1" rowspan="{{ $laporanGuru->count() }}"> {{ $data->nama_guru }}</td>
                                    @endif
                                    <td class="border border-green-800 px-1 text-center">{{ $data->nama_kelas }}</td>

                                    <td class="border border-green-800 px-1 text-center">
                                        {{ $data->jumlahHari }}
                                    </td>
                                    <td class="border border-green-800 px-1 text-center">{{ $data->jumlah_sesi_kelas_guru }}</td>
                                    <td class="border border-green-800 px-1 text-center">
                                        {{ $data->jumlah_hadir }}
                                    </td>
                                    <td class="border border-green-800 px-1 text-center">
                                        {{ $data->jumlah_izin }}
                                    </td>
                                    <td class="border border-green-800 px-1 text-center">
                                        {{ $data->jumlah_sakit }}
                                    </td>
                                    <td class="border border-green-800 px-1 text-center">
                                        {{ $data->jumlah_alfa }}
                                    </td>
                                    <td class="border border-green-800 px-1 text-center">
                                        {{ $data->jumlahHari != 0 ? number_format($data->jumlah_hadir * 100 / $data->jumlahHari, 0) : 'N/A' }}%

                                    </td>
                                    <td class="border border-green-800 text-center px-1 {{ $data->hari == 'jumat' ? '' : 'bg-red-200' }}">
                                        {{ $data->hari == 'jumat' ? $data->total : '' }}
                                    </td>
                                    <td class="border border-green-800 text-center px-1 {{ $data->hari == 'sabtu' ? '' : 'bg-red-200' }}">
                                        {{ $data->hari == 'sabtu' ? $data->total : '' }}
                                    </td>
                                    <td class="border border-green-800 text-center px-1 {{ $data->hari == 'minggu' ? '' : 'bg-red-200' }}">
                                        {{ $data->hari == 'minggu' ? $data->total : '' }}
                                    </td>
                                    <td class="border border-green-800 text-center px-1 {{ $data->hari == 'senin' ? '' : 'bg-red-200' }}">
                                        {{ $data->hari == 'senin' ? $data->total : '' }}
                                    </td>
                                    <td class="border border-green-800 text-center px-1 {{ $data->hari == 'selasa' ? '' : 'bg-red-200' }}">
                                        {{ $data->hari == 'selasa' ? $data->total : '' }}
                                    </td>
                                    <td class="border border-green-800 text-center px-1 {{ $data->hari == 'rabu' ? '' : 'bg-red-200' }}">
                                        {{ $data->hari == 'rabu' ? $data->total : '' }}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="page-break"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-1">
        <div class="">
            <div class=" bg-sky-200 dark:bg-dark-bg overflow-hidden shadow-sm">
                <div class="p-6  ">
                    <p class=" font-semibold">Keterangan : </p>
                    <p class=" px-2">1. Nilai diambail dari <b class=" underline">Ulangan Harian dan Ujian Akhir
                            Semester</b></p>
                    <p class=" px-2 capitalize">2. Untuk pengisian nilai jika tidak ada harap kosongkan form penilaian
                    </p>
                    <p class=" px-2 capitalize">3. Untuk pengisinan nilai <b><u>harus</u></b> memasukan peserta kelas
                        terlebih dahulu di menu kelas</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>