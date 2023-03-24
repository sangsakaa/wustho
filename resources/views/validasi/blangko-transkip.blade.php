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
        <a href="/blangko-ijazah" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Ijazah</a>
        <a href="/pengaturan" class=" text-white rounded-md  bg-green-800 px-2 py-1 ">Kembali</a>
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
                <p class=" font-serif text-md  uppercase text-2xl ">Ujian Akhir Madrasah Diniyah </p>

                <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho
                    Wahidiyah</p>
                <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                <p class=" capitalize font-serif text-lg">kota kediri jawa timur indonesia</p>
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
                            {{$data_lulusan['nilai_tulis']->sum('nilai_akhir')/$data_lulusan['tulis']}}
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
                            {{$data_lulusan['nilai_praktek']->sum('nilai_akhir')/$data_lulusan['praktik']}}
                            @else
                            0
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="  grid grid-cols-2 text-right   ">
                <div class="  w-2/2  flex    px-32 pt-4 ">
                    <div class="  border-black      w-32  h-40   text-justify ">
                        <span class=" grid justify-between   p-12 font-semibold ">

                        </span>
                    </div>
                </div>
                <div class=" text-sm   mt-4 text-left ">
                    <p class=" ">

                    <p class=" underline"> Kedunglo, 27 Sya'ban 1444 H </p>

                    <p class="  px-20 ml-1">19 Maret 2023 M</p>
                    <p class="">Kepala Madrasah,</p>



                    <br><br><br><br><br>
                    <p class=" uppercase font-semibold"> MUH. BAHRUL ULUM,S.H</p>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        @endforeach

    </div>


</x-app-layout>