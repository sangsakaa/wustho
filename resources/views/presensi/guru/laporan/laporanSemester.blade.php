<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Guru')
        <h2 class="font-semibold sm:text-xl leading-tight text-sm">

            {{ __(' Laporan Semester Presensi Guru ') }} <br>

        </h2>
    </x-slot>
    <div class="pb-1 pt-2">

        <div class="">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
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
                        <div class=" py-1 flex gap-2  justify-end ">
                            <a href="/sesi-presensi-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                Kembali
                            </a>
                            <a href="/laporan-semester-guru" class=" bg-red-600 py-1 dark:bg-purple-600 mt-2 my-1 rounded-sm hover:bg-purple-600 text-white px-4 ">
                                refresh
                            </a>


                        </div>
                    </div>
                    <div>

                        <table class=" w-full">
                            <thead>
                                <tr class=" border border-green-800">
                                    <th class=" border border-green-800 w-16">Bulan</th>
                                    <th class=" border border-green-800 w-16">No</th>
                                    <th class=" border border-green-800">Nama Guru</th>
                                    <th class=" border border-green-800">Hadir</th>
                                    <th class=" border border-green-800">Izin</th>
                                    <th class=" border border-green-800">Sakit</th>
                                    <th class=" border border-green-800">Alfa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan_per_bulan as $bulan => $guru)
                                @foreach ($guru as $nama_guru => $data)
                                <tr>
                                    @if ($loop->first)
                                    <td rowspan="{{ count($guru) + 1 }}" class=" border border-green-800 -rotate-90 text-2xl font-semibold">{{ $bulan }}</td>
                                    @endif
                                    <td class=" border border-green-800 text-center px-2">{{ $loop->iteration }}</td>
                                    <td class=" border border-green-800 text-left px-2">{{ $nama_guru }}</td>
                                    <td class=" border border-green-800 text-center px-2">{{ $data['hadir'] }}</td>
                                    <td class=" border border-green-800 text-center px-2">{{ $data['izin'] }}</td>
                                    <td class=" border border-green-800 text-center px-2">{{ $data['sakit'] }}</td>
                                    <td class=" border border-green-800 text-center px-2">{{ $data['alfa'] }}</td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
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