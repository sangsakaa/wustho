<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Blangko Transkip' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Blangko Transkip') }}
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
    <div class="max-w-7xl mx-auto p-4 space-y-4">

        {{-- Action Button --}}
        <div class="flex flex-wrap gap-3">
            <button
                onclick="printContent('div1')"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow text-sm font-medium transition">
                🖨 Cetak Transkrip
            </button>

            <a href="/blangko-ijazah/{{ $dataLulusan->id }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm font-medium transition">
                📄 Ijazah
            </a>

            <a href="/lulusan"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow text-sm font-medium transition">
                ← Kembali
            </a>
        </div>

        {{-- Info Card --}}
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-700">
                    Informasi Transkrip Nilai
                </h3>
                <p class="text-sm text-gray-500">
                    Detail data lulusan dan jumlah transkrip
                </p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-500">Kelas</span>
                    <span class="font-semibold text-gray-800">
                        {{ $dataLulusan->nama_kelas }}
                    </span>
                </div>

                <div class="flex justify-between border-b pb-3">
                    <span class="text-gray-500">Jumlah Transkrip Nilai</span>
                    <span class="font-semibold text-green-600 text-lg">
                        <div>

                        </div>
                    </span>
                </div>

            </div>
        </div>

    </div>
    <div id="div1" class="  bg-white   ">
        <style>
            .nomor-ijazah {
                font-family: Arial, sans-serif;
            }
        </style>
        @foreach($data as $data_lulusan)
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class="px-16 p-2 bg-white dark:bg-dark-bg font-serif  ">
            <center>
                <p class="  font-serif text-2xl   mt-24  uppercase  ">daftar nilai</p>
                <p class="  uppercase font-serif  font-semibold ">Ujian Akhir Madrasah Diniyah takmiliyah
                    @if ($dataKelas->first()->jenjang == 'Wustho')
                    Wustha
                    @elseif ($dataKelas->first()->jenjang == 'Ula')
                    Ula
                    @endif
                    Wahidiyah
                </p>
                <!-- <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p> -->
                <p class=" font-semibold  font-serif text-lg uppercase"> kedunglo al munadhdhoroh kediri</p>
                <p class=" font-semibold font-serif ">TAHUN PELAJARAN <span class="nomor-ijazah ">{{$dataPeriode->first()->periode}}</span></p>
            </center>
            <div class=" mt-4 uppercase grid grid-cols-1 font-semibold text-sm sm:text-sm">
                <div class=" grid grid-cols-2 ">
                    <div class="  ">Nama Murid</div>
                    <div class=" uppercase "> : {{$data_lulusan['lulusan']->nama_siswa}}</div>
                </div>
                <div class=" grid grid-cols-2 ">
                    <div class=" ">Nomor Induk Murid</div>
                    <div class="nomor-ijazah"> : {{$data_lulusan['lulusan']->nis}}</div>
                </div>
            </div>
            <hr class=" border-black">
            <div style="margin-top:30px;">
                <span style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold; color:#000;">1. Nilai Ujian Tulis</span>
            </div>
            <hr class=" border-black">
            <table class=" w-full mt-0.5">
                <thead>
                    <tr class=" uppercase text-sm border border-t-2 border-black">
                        <th class=" border border-black px-1 py-1 ">No</th>
                        <th class=" border border-black px-1 py-1">Mata Pelajaran</th>
                        <th class=" border border-black px-1 py-1 ">Angka</th>
                        <th class=" border border-black px-1 py-1 w-1/2">Huruf</th>
                    </tr>
                </thead>
                <tbody class=" border border-black">
                    @foreach($data_lulusan['nilai_tulis'] as $nilai_tulis)
                    <tr class="">
                        <td class=" border-l border-black p-1 text-center w-1" style="font-family:'Times New Roman', serif; font-size:16px; color:#000;">
                            {{$loop->iteration}}
                        </td>
                        <td class=" border-l border-black p-1 w-1/2 " style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold;color:#000;">
                            {{$nilai_tulis->mapel}}
                        </td>
                        <td class=" border-l text-center w-20 border-black p-1" style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold;color:#000;">
                            {{$nilai_tulis->nilai_akhir}}
                        </td>
                        <td class=" border-l  border-black p-1 capitalize text-center" style="font-family:'Times New Roman', serif; font-size:16px; color:#000;">
                            {{Terbilang::make($nilai_tulis->nilai_akhir); }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class=" border text-center w-20 border-black p-1">
                            <span>Jumlah</span><br>
                            <span>Rata Rata</span>
                        </td>
                        <td class=" border text-center w-20 border-black p-1" style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold;color:#000;">
                            {{$data_lulusan['nilai_tulis']->sum('nilai_akhir')}} <br>
                            @if($data_lulusan['tulis'] != 0)
                            {{ number_format($data_lulusan['nilai_tulis']->sum('nilai_akhir')/$data_lulusan['tulis']),',',2}}
                            @else
                            0
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
            <div style="margin-top:30px;">
                <span style="
        font-family:'Times New Roman', serif;
        font-size:16px;
        font-weight:bold;
        color:#000;
        
    ">
                    2. Nilai Ujian Praktik
                </span>
            </div>
            <table class=" w-full ">
                <thead>
                    <tr class=" uppercase text-sm border border-t-2 border-black">
                        <th class=" border border-black px-1 py-1 w-2">No</th>
                        <th class=" border border-black px-1 py-1">Mata Pelajaran</th>
                        <th class=" border border-black px-1 py-1 ">Angka</th>
                        <th class=" border border-black px-1 py-1 w-1/2">Huruf</th>
                    </tr>
                </thead>
                <tbody class=" border border-black">
                    @foreach($data_lulusan['nilai_praktek'] as $nilai_praktek)
                    <tr>
                        <td class=" border-l border-black text-center p-1 w-1.5">
                            {{$loop->iteration}}
                        </td>
                        <td class=" border-l border-black w-1/2 p-1" style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold;color:#000;">
                            {{$nilai_praktek->mapel}}
                        </td>
                        <td class=" border-l text-center w-20 border-black p-1" style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold;color:#000;">
                            {{$nilai_praktek->nilai_akhir}}
                        </td>
                        <td class=" border-l border-black p-1 capitalize text-center">
                            {{Terbilang::make($nilai_praktek->nilai_akhir); }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class=" border text-center w-20 border-black p-1">
                            <span>Jumlah</span><br>
                            <span>Rata Rata</span>
                        </td>
                        <td class=" border text-center w-20 border-black p-1" style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold;color:#000;">
                            {{$data_lulusan['nilai_praktek']->sum('nilai_akhir')}} <br>
                            @if($data_lulusan['praktik'] != 0)
                            {{ number_format($data_lulusan['nilai_praktek']->sum('nilai_akhir')/$data_lulusan['praktik']),2}}
                            @else
                            0
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="  grid grid-cols-2    " style="font-family:'Times New Roman', serif; font-size:16px; font-weight:bold;color:#000;">
                <div class="   px-10 py-12">

                </div>
                <div class="   grid   text-left py-8  ">
                    <div class="flex flex-col">
                        <table class="  w-fit">
                            <tbody>
                                <tr>
                                    <td class=" underline">Kedunglo, </td>
                                    <td class=" text-right underline nomor-ijazah">
                                        {{$dataLulusan->tanggal_lulus_hijriyah}} H
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right nomor-ijazah">
                                        {{ \Carbon\Carbon::parse($dataLulusan->tanggal_kelulusan)->isoFormat('DD MMMM Y') }} M
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <p class="underline">
                            </p>
                        </div>
                        <div class="flex items-center">
                            <p class="  px-20">
                            </p>
                        </div>
                    </div>
                    <div>
                        <p class=" mb-0">Kepala Madin, </p>
                        <br><br><br><br> <br>
                        <p class="  font-semibold">
                            @if ($dataKelas->first()->jenjang == 'Wustho')
                            {{$kepalaSekolah->nama_perangkat}}
                            @elseif ($dataKelas->first()->jenjang == 'Ula')
                            {{$kepalaSekolah->nama_perangkat}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        @endforeach
    </div>
</x-app-layout>