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
    <div class=" p-2">
        <button class=" text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">Cetak Transkip</button>
        <a href="/blangko-ijazah/{{$dataLulusan->id}}" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Ijazah</a>
        <a href="/pengaturan" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Kembali</a>

    </div>
    <div class=" bg-white m-2 p-2">

        <div class=" grid grid-cols-4">
            <div>Kelas</div>
            <div> : {{$dataLulusan->nama_kelas}}</div>
            <div>Jumlah Transkip Nilai</div>
            <div> : {{$data_lulusan->count()}}</div>
        </div>
    </div>
    <div id="div1" class="  bg-white   ">
        @foreach($data as $data_lulusan)
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class="px-16 p-2 bg-white dark:bg-dark-bg  ">
            <center>
                <p class="  font-serif text-2xl   mt-24  uppercase  ">daftar nilai</p>
                <p class="  uppercase font-serif  font-semibold ">Ujian Akhir Madrasah Diniyah takmiliyah wustha Wahidiyah
                </p>
                <!-- <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p> -->
                <p class=" font-semibold  font-serif text-lg uppercase"> kedunglo al munadhdhoroh kediri</p>
                <p class=" font-semibold font-serif ">TAHUN PELAJARAN <span class=" ">2023/2024</span></p>
            </center>
            <div class=" mt-4 uppercase grid grid-cols-2 font-semibold text-sm sm:text-sm">
                <div class="justify-start flex grid-cols-2 ">
                    <div class="  ">Nama Murid</div>
                    <div> : {{$data_lulusan['lulusan']->nama_siswa}}</div>
                </div>
                <div class=" justify-end flex grid-cols-2">
                    <div class=" ">Nomor Induk Murid</div>
                    <div class=" pl-2"> : {{$data_lulusan['lulusan']->nis}}</div>
                </div>
            </div>
            <hr class=" border-black">
            <div class=" mt-4">
                <span class=" font-semibold"> 1. Nilai Ujian Tulis</span>
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
                        <td class=" border-l border-black p-1 text-center w-1">
                            {{$loop->iteration}}
                        </td>
                        <td class=" border-l border-black p-1 w-1/2 ">
                            {{$nilai_tulis->mapel}}
                        </td>
                        <td class=" border-l text-center w-20 border-black p-1">
                            {{$nilai_tulis->nilai_akhir}}
                        </td>
                        <td class=" border-l  border-black p-1 capitalize text-center">
                            {{Terbilang::make($nilai_tulis->nilai_akhir); }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class=" border text-center w-20 border-black p-1">
                            <span>Jumlah</span><br>
                            <span>Rata Rata</span>
                        </td>
                        <td class=" border text-center w-20 border-black p-1">
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
            <div class=" mt-8">
                <span class=" font-semibold mt-4">2. Nilai Ujian Praktek</span>
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
                        <td class=" border-l border-black w-1/2 p-1">
                            {{$nilai_praktek->mapel}}
                        </td>
                        <td class=" border-l text-center w-20 border-black p-1">
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
                        <td class=" border text-center w-20 border-black p-1">
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

            <div class="  grid grid-cols-2    ">
                <div class="   px-10 py-12">

                </div>
                <div class="   grid   text-left py-8  ">
                    <div class="flex flex-col">
                        <table class="  w-fit">
                            <tbody>
                                <tr>
                                    <td class=" underline">Kedunglo, </td>
                                    <td class=" text-right underline">
                                        {{$dataLulusan->tanggal_lulus_hijriyah}} H
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right">
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
                        <p class=" uppercase font-semibold"> MUH.Bahrul Ulum,S.H</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        @endforeach
    </div>
</x-app-layout>