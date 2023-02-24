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
                    <div class="  ">Nama siswa</div>
                    <div> : {{$data_lulusan['lulusan']->nama_siswa}}</div>
                </div>
                <div class=" justify-end flex grid-cols-2">
                    <div class=" ">Nomor Induk Siswa</div>
                    <div class=" pl-2"> : {{$data_lulusan['lulusan']->nis}}</div>
                </div>
            </div>
            <hr class=" border-black">
            <span class=" font-semibold"> 1. Nilai Ujian Tulis</span>
            <hr class=" border-black">
            <table class=" w-full mt-0.5">
                <thead>
                    <tr class=" uppercase text-sm border border-t-2 border-black">
                        <th class=" border border-black px-1 py-1">No</th>
                        <th class=" border border-black px-1 py-1">Bidang studi</th>
                        <th class=" border border-black px-1 py-1">Angka</th>
                        <th class=" border border-black px-1 py-1">Huruf</th>
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
                            <span>Rat Rata</span>
                        </td>
                        <td class=" border text-center w-20 border-black p-1">
                            {{$data_lulusan['nilai_tulis']->sum('nilai_akhir')}} <br>
                            {{number_format($data_lulusan['nilai_tulis']->sum('nilai_akhir')/$data_lulusan['nilai_tulis']->count('nilai_akhir'),2,',','.')}}

                        </td>
                    </tr>

                </tbody>
            </table>
            <span class=" font-semibold">2. Nilai Praktek</span>
            <table class=" w-full mt-0.5">
                <thead>
                    <tr class=" uppercase text-sm border border-t-2 border-black">
                        <th class=" border border-black px-1 py-1">No</th>
                        <th class=" border border-black px-1 py-1">Bidang studi</th>
                        <th class=" border border-black px-1 py-1">Angka</th>
                        <th class=" border border-black px-1 py-1">Huruf</th>
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
                            <span>Rat Rata</span>
                        </td>
                        <td class=" border text-center w-20 border-black p-1">
                            {{$data_lulusan['nilai_praktek']->sum('nilai_akhir')}} <br>
                            {{number_format($data_lulusan['nilai_praktek']->sum('nilai_akhir')/$data_lulusan['nilai_praktek']->count('nilai_akhir'),2,',','.')}}

                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="  flex grid-cols-2 text-right  text-sm">
                <div class=" w-2/3"></div>
                <div class="  text-left  mt-10">
                    Kedunglo, {{ now()->isoFormat('D MMMM YYYY') }}<br>
                    Kepala Madrasah<br><br><br><br>
                    <p class=" uppercase"> Muh. Bahrul Ulum, S.H</p>
                </div>

            </div>
        </div>
        <div class="page-break"></div>
        @endforeach

    </div>


</x-app-layout>