<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Bulanan ')
        <h2 class="font-semibold text-xl leading-tight">

        </h2>
    </x-slot>
    <div class=" bg-white p-2 sm:p-2  ">
        <div class=" flex gap-1">
            <a href="/sesi-perangkat" class=" bg-blue-600 text-white rounded-md px-2 py-1">kembali Sesi</a>
            <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                <x-icons.print></x-icons.print>
                Cetak</button>
        </div>

    </div>
    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>
    <div class=" bg-white   ">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div id="div1" class=" px-4 ">
            <div class=" flex">
                <div>
                    <img src={{ asset("asset/images/logo.png") }} alt="" width="110" class=" px-2">
                </div>
                <div class=" w-full text-center text-green-800">
                    <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                    <p class="  uppercase font-serif text-2xl font-semibold text-monospace ">madrasah diniyah wustho
                        Wahidiyah</p>
                    <p class=" capitalize font-serif text-xs">Alamat : Jl.KH. Wachid Hasyim Kota Kediri 64114 Jawa Timur Telp. (0354) 774511, 771018 Fax. (0354) 772179</p>

                    <hr class=" border-b-2 border-green-700 ">
                    <hr class=" border-b-1 mt-0.5 border-green-700 ">
                </div>
            </div>
            <div class=" text-center py-1">
                <span class=" uppercase font-semibold text-green-800 py-1">laporan Kehadiran bulan : {{ \Carbon\Carbon::parse( now())->isoFormat('  MMMM Y ') }}</span>
            </div>
            <table class="w-full ">
                <thead>
                    <tr>
                        <th rowspan="2" class=" border border-green-800 text-green-800 px-1">Bulan</th>
                        <th rowspan="2" class=" border border-green-800 text-green-800 px-1">No</th>
                        <th rowspan=" 2" class=" border border-green-800 text-green-800 px-1">Nama Perangkat</th>
                        <!-- <th rowspan=" 2" class=" border border-green-800 text-green-800 px-1">Wajib</th> -->
                        <th colspan="5" class=" border border-green-800 text-green-800 px-1">Keterangan</th>

                    </tr>
                    <tr>
                        <th class=" border border-green-800 text-green-800 px-1">Sesi</th>
                        <th class=" border border-green-800 text-green-800 px-1">Alfa</th>
                        <th class=" border border-green-800 text-green-800 px-1">Hadir</th>
                        <th class=" border border-green-800 text-green-800 px-1">Izin</th>
                        <th class=" border border-green-800 text-green-800 px-1">Sakit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanBulanan->groupBy(function($laporan) {
                    return \Carbon\Carbon::parse($laporan->tanggal)->format('F');
                    }) as $bulan => $laporanBulananGrup)
                    <tr>
                        <td class="border border-green-800 text-green-800 text-center px-1" rowspan="6" style="font-weight: bold;">

                            {{ \Carbon\Carbon::parse(  $bulan)->isoFormat('  MMMM ') }}
                        </td>
                    </tr>
                    @foreach($laporanBulananGrup->groupBy('nama_perangkat') as $namaPerangkat => $laporanPerangkat)
                    <tr>
                        <td class="border border-green-800 text-green-800 px-1 text-center">{{ $loop->iteration }}</td>
                        <td class="border border-green-800 text-green-800 px-1 text-left">{{ $namaPerangkat }}</td>

                        <td class="border border-green-800 text-green-800 px-1 text-center">{{ $laporanPerangkat->sum('total') }}</td>
                        <td class="border border-green-800 text-green-800 px-1 text-center">{{ $laporanPerangkat->sum('jumlah_alfa') }}</td>
                        <td class="border border-green-800 text-green-800 px-1 text-center">{{ $laporanPerangkat->sum('jumlah_hadir') }}</td>
                        <td class="border border-green-800 text-green-800 px-1 text-center">{{ $laporanPerangkat->sum('jumlah_izin') }}</td>
                        <td class="border border-green-800 text-green-800 px-1 text-center">{{ $laporanPerangkat->sum('jumlah_sakit') }}</td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="  flex grid-cols-2 text-right ">
                <div class=" w-2/3"></div>
                <div class=" text-green-800  text-left text-sm">
                    Kedunglo, <?php
                                $date = date_create(now());
                                echo \Carbon\Carbon::parse($date)->isoFormat(' DD MMMM Y');
                                ?></p>
                    <p class=" font-semibold">Al Mudir / Kepala</p> <br><br><br>
                    <p class=" font-semibold">Muh. Bahrul Ulum, S.H</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>