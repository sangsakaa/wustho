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
                <p class="  font-serif text-lg   mt-24 font-semibold uppercase  ">daftar nilai</p>
                <p class=" font-serif text-md font-semibold uppercase ">Ujian Akhir Madrasah Diniyah Wustho Wahidiyah</p>

                <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho
                    Wahidiyah</p>
                <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                <p class=" capitalize font-serif text-lg">kota kediri jawa timur indonesia</p>
            </center>
            <div class=" mt-4 uppercase grid grid-cols-4 font-semibold">
                <div>Nama siswa</div>
                <div> : {{$data_lulusan['lulusan']->nama_siswa}}</div>
                <div>Nomor Induk Siswa</div>
                <div> : {{$data_lulusan['lulusan']->nis}}</div>
            </div>
            <hr class=" border-black">
            <span> 1. Nilai Ujian Tulis</span>
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
                    <tr>
                        <td class=" border-l border-black p-1 text-center w-1.5">
                            {{$loop->iteration}}
                        </td>
                        <td class=" border-l border-black p-1 w-1/4">
                            {{$nilai_tulis->mapel}}
                        </td>
                        <td class=" border-l text-center w-20 border-black p-1">
                            {{$nilai_tulis->nilai_akhir}}
                        </td>
                        <td class=" border-l border-black p-1 capitalize">
                            {{Terbilang::make($nilai_tulis->nilai_akhir); }}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <span>2. Nilai Praktek</span>
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
                    @foreach($data_lulusan['nilai_praktek'] as $nilai_tulis)
                    <tr>
                        <td class=" border-l border-black p-1 w-1.5">
                            {{$loop->iteration}}
                        </td>
                        <td class=" border-l border-black w-1/4 p-1">
                            {{$nilai_tulis->mapel}}
                        </td>
                        <td class=" border-l text-center w-20 border-black p-1">
                            {{$nilai_tulis->nilai_akhir}}
                        </td>
                        <td class=" border-l border-black p-1 capitalize">
                            {{Terbilang::make($nilai_tulis->nilai_akhir); }}
                        </td>
                    </tr>
                    @endforeach

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