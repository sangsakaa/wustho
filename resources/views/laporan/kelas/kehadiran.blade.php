<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Akumulasi Semester' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Laporan Kehadiran') }}
            </h2>
        </div>
    </x-slot>
    <div class=" px-4 py-1  w-full bg-white ">
        <div class=" flex  grid-cols-2  gap-1 ">
            <div class=" mt-1">
                <button class="  w-10 justify-center text-white   bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                    <x-icons.print></x-icons.print>
                </button>
            </div>
            <div class=" grid sm:justify-end justify-start">
                <form action="/Laporan-Kehadiran" method="get" class="w-full">
                    <input type="month" name="bulan" class=" py-1 dark:bg-dark-bg" value="{{ $bulan->format('Y-m') }}">
                    <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                        Pilih Bulan
                    </button>
                </form>
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
    </div>

    <div id="div1">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class=" p-4 bg-white px-2 ">
            <div class="   ">
                <div class=" text-center text-green-700 block sm:hidden    ">
                    <div class=" flex">
                        <div><img src={{ asset("asset/images/logo.png") }} alt="" width="110" class=" px-2"></div>
                        <div class="  ml-5 ">
                            <center>
                                </p>
                                <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                                <p class="  uppercase font-serif text-lg font-semibold text-monospace ">madrasah diniyah {{$kelasmi->jenjang}}
                                    Wahidiyah</p>
                                <p class=" capitalize font-serif text-xs">Alamat : Jl.KH. Wachid Hasyim Kota Kediri 64114 Jawa Timur</p>

                            </center>
                        </div>
                    </div>
                    <hr class=" border-b-2 border-green-700 mb-1">
                    <hr class=" border-b-1 border-green-700 mb-1">
                    <p class=" uppercase font-semibold ">laporan presensi murid : Bulan {{ \Carbon\Carbon::parse(  $bulan)->isoFormat('  MMMM ') }} </p>
                    <p class=" uppercase font-semibold  text-green-700 border-green-800 text-md">Semester {{$periode = $kelasmi->ket_semester ?? ' ';}} Tahun Pelajaran {{$periode = $kelasmi->periode ?? ' ';}} </p>
                </div>
            </div>

            <table class=" w-full mt-1 ">
                <thead>
                    <tr class=" text-green-800">
                        <th rowspan="2" class=" border border-green-800 px-1">No</th>
                        <th rowspan="2" class=" border border-green-800 px-1">Nama Kelas</th>
                        <th rowspan="2" class=" border border-green-800 px-1">Total Peserta Kelas</th>
                        <th rowspan="2" class=" border border-green-800 px-1">Total Sesi</th>
                        <th colspan="4" class=" border border-green-800 px-1">Keterangan</th>

                        <th rowspan="2" class=" border border-green-800 px-1">Presentasi Kehadiran</th>
                    </tr>
                    <tr class=" text-green-800">
                        <th class=" border border-green-800 px-1">Total Hadir</th>
                        <th class=" border border-green-800 px-1">Total Sakit</th>
                        <th class=" border border-green-800 px-1">Total Izin</th>
                        <th class=" border border-green-800 px-1">Total Alfa</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                    $currentKelas = null;
                    @endphp
                    @foreach($data as $item)
                    <tr class=" text-green-800">
                        @if($currentKelas !== $item->nama_kelas)
                        @php
                        $currentKelas = $item->nama_kelas;
                        $rowCount = $data->where('nama_kelas', $item->nama_kelas)->count();
                        @endphp
                        <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{ $loop->iteration}}
                        </td>
                        <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{ $item->nama_kelas }}
                        </td>
                        <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{$item->total_peserta_kelas}}
                        </td>
                        <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                            {{$item->total_sesikelas}}
                        </td>
                        @endif
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_kehadiran}}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_sakit}}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_izin }}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_alfa}}</td>
                        <td class="border border-green-800 text-center px-1 py-1">{{ number_format($item->total_kehadiran *100/$item->total_peserta_kelas / $item->total_sesikelas   ,0,2)}} % </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div class=" mt-1  flex grid-cols-2 text-right block sm:hidden">
                <div class=" w-2/3"></div>
                <div class="  text-left text-sm">
                    @if($kelasmi->jenjang == "Ula")
                    {{-- Kode untuk jenjang Ula --}}
                    @elseif($kelasmi->jenjang == "Wustho")
                    Kedunglo, <?php
                                $date = date_create(now());
                                echo \Carbon\Carbon::parse($date)->isoFormat(' DD MMMM Y');
                                ?></p>
                    Al Mudir / Kepala <br><br><br><br>
                    Muh. Bahrul Ulum, S.H
                    @else
                    {{-- Kode untuk kasus lainnya --}}
                    @endif
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="dropdown " data-bs-theme="dark">
            <div class=" bg-white px-2 py-2">
                <center>
                    <div class=" uppercase text-green-700  block sm:hidden">

                        <p class=" text-3xl bold">Detail Laporan Ketidakhadiran</p>
                        <p class=" uppercase font-semibold ">Bulan : {{ \Carbon\Carbon::parse(  $bulan)->isoFormat('  MMMM ') }} </p>
                        <p class=" uppercase font-semibold  text-green-700 border-green-800 text-md">Semester {{$periode = $kelasmi->ket_semester ?? ' ';}} Tahun Pelajaran {{$periode = $kelasmi->periode ?? ' ';}} </p>
                        <hr class=" border border-b-2 border-green-800">
                </center>
                <div class=" ">
                    <table class=" w-full">
                        <thead>
                            <tr>
                                <th class=" border">Nama Asrama</th>

                                <th class=" border">Total Alfa</th>
                                <th class=" border">Total Sakit</th>
                                <th class=" border">Total Izin</th>
                                <th class=" border">Total Peserta Kelas</th>
                                <th class=" border">Total Kehadiran</th>
                                <th class=" border">Total Sesikelas</th>
                                <th class=" border">Presentase Alfa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataDetail as $result)
                            <tr>
                                <td class=" border text-center px-1">{{ $result->nama_asrama }}</td>

                                <td class=" border text-center px-1">{{ $result->total_alfa }}</td>
                                <td class=" border text-center px-1">{{ $result->total_sakit }}</td>
                                <td class=" border text-center px-1">{{ $result->total_izin }}</td>
                                <td class=" border text-center px-1">{{ $result->total_peserta_kelas }}</td>
                                <td class=" border text-center px-1">{{ $result->total_kehadiran }}</td>
                                <td class=" border text-center px-1">{{ $result->total_sesikelas }}</td>
                                <td class=" border text-center px-1">{{ number_format($result->presentase_alfa,0) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="  flex grid-cols-2 text-right mt-1 block sm:hidden">
                    <div class=" w-2/3"></div>
                    <div class="  text-left text-sm">
                        @if($kelasmi->jenjang == "Ula")
                        {{-- Kode untuk jenjang Ula --}}
                        @elseif($kelasmi->jenjang == "Wustho")
                        Kedunglo, <?php
                                    $date = date_create(now());
                                    echo \Carbon\Carbon::parse($date)->isoFormat(' DD MMMM Y');
                                    ?></p>
                        Al Mudir / Kepala <br><br><br><br>
                        Muh. Bahrul Ulum, S.H
                        @else
                        {{-- Kode untuk kasus lainnya --}}
                        @endif

                    </div>
                </div>
            </div>
            <div class="page-break"></div>
        </div>
</x-app-layout>