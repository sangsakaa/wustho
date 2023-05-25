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
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <div id="div1">
        <div class=" bg-white px-2 ">
            <div class="  ">
                <div class=" text-center text-green-700 block sm:hidden   ">
                    <div class=" flex">
                        <div><img src={{ asset("asset/images/logo.png") }} alt="" width="110" class=" px-2"></div>
                        <div class="  ml-5 ">
                            <center>

                                </p>
                                <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                                <p class="  uppercase font-serif text-2xl font-semibold text-monospace ">madrasah diniyah wustho
                                    Wahidiyah</p>
                                <p class=" capitalize font-serif text-xs">Alamat : Jl.KH. Wachid Hasyim Kota Kediri 64114 Jawa Timur Telp. (0354) 774511, 771018 Fax. (0354) 772179</p>

                                <hr class=" border-b-1 border-green-700 ">
                                FAFIRRUU - ILALLOH
                            </center>
                        </div>
                    </div>
                    <hr class=" border-b-2 border-green-700 mb-1">
                    <hr class=" border-b-1 border-green-700 mb-1">
                    <p class=" uppercase underline text-green-800 border-green-800 text-md">Tahun Pelajaran {{$periode = $kelasmi->periode ?? ' ';}} {{$periode = $kelasmi->ket_semester ?? ' ';}}</p>
                </div>
            </div>

            <table class=" w-full mt-1 ">
                <thead>
                    <tr class=" text-green-800">
                        <th rowspan="2" class=" border border-green-800 px-1">No</th>
                        <th rowspan="2" class=" border border-green-800 px-1">Nama Kelas</th>
                        <th rowspan="2" class=" border border-green-800 px-1">Total Peserta Kelas</th>
                        <th colspan="4" class=" border border-green-800 px-1">Total Hadir</th>

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
            <div class="page-break"></div>
        </div>
        <div class="dropdown" data-bs-theme="dark">
            <div class=" bg-white px-2 py-2">
                <center>
                    <div class=" uppercase text-green-800  block sm:hidden">

                        <p class=" text-3xl">Detail Laporan Ketidakhadiran</p>
                        <p class=" text-md">Tahun Pelajaran {{$periode = $kelasmi->periode ?? ' ';}} {{$periode = $kelasmi->ket_semester ?? ' ';}}</p>

                        <hr class=" border border-b-2 border-green-800">
                </center>
                <table class=" w-full mt-2">
                    <thead>
                        <tr>
                            <th class=" border border-green-800  text-center px-1">Nama Kelas</th>
                            <th class=" border border-green-800  text-center px-1">Nama Siswa</th>
                            <th class=" border border-green-800  text-center px-1">Total Alfa</th>
                            <th class=" border border-green-800  text-center px-1">Total Sakit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $currentKelas = null;
                        @endphp
                        @foreach($dataDetail as $item)
                        <tr>
                            @if($currentKelas !== $item->nama_kelas)
                            @php
                            $currentKelas = $item->nama_kelas;
                            $rowCount = $dataDetail->where('nama_kelas', $item->nama_kelas)->count();
                            @endphp
                            <td class="border border-green-800 text-center px-1 py-1" rowspan="{{ $rowCount }}">
                                {{ $item->nama_kelas }}
                            </td>
                            @endif
                            <td class="border border-green-800 px-1 py-1 capitalize">{{$loop->iteration}}. {{ strtolower($item->nama_siswa) }}</td>
                            <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_alfa }}</td>
                            <td class="border border-green-800 text-center px-1 py-1">{{ $item->total_sakit }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="  flex grid-cols-2 text-right">
                    <div class=" w-2/3"></div>
                    <div class="  text-left text-sm">
                        Kedunglo, <?php
                                    $date = date_create(now());
                                    echo \Carbon\Carbon::parse($date)->isoFormat(' DD MMMM Y');
                                    ?></p>
                        Al Mudir / Kepala <br><br><br><br>
                        Muh. Bahrul Ulum, S.H
                    </div>
                </div>
            </div>
            <div class="page-break"></div>
        </div>
</x-app-layout>