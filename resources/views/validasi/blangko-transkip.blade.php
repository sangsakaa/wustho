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
    <div id="div1" class=" px-4  ">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class=" p-2 bg-white">
            <center>

                <p class=" font-serif text-lg  mt-10 font-semibold uppercase ">daftar nilai</p>
                <p class=" font-serif text-md font-semibold uppercase ">Ujian Akhir Madrasah Diniyah Wustho Wahidiyah</p>

                <p class="  uppercase font-serif text-2xl font-semibold ">madrasah diniyah wustho
                    Wahidiyah</p>
                <p class="  font-serif text-lg uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                <p class=" capitalize font-serif text-lg">kota kediri jawa timur indonesia</p>
            </center>
            <div class=" mt-4 uppercase grid grid-cols-4">
                <div>Nama siswa</div>
                <div>: Mukidi</div>
                <div>Nomor Induk Siswa</div>
                <div>: 202820202200111</div>
            </div>
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
                    <tr class=" ">
                        <th class=" border-l border-black text-center">1</th>
                        <td class=" border-l border-black text-center"> Nahwa</td>
                        <td class=" border-l border-black text-center">80</td>
                        <td class=" border-l border-black text-center capitalize">depalan Puluh</td>
                    </tr>
                    <tr class=" ">
                        <th class=" border-l border-black text-center">1</th>
                        <td class=" border-l border-black text-center"> Nahwa</td>
                        <td class=" border-l border-black text-center">80</td>
                        <td class=" border-l border-black text-center">depalan Puluh</td>
                    </tr>
                    <tr class=" ">
                        <th class=" border-l border-black text-center">1</th>
                        <td class=" border-l border-black text-center"> Nahwa</td>
                        <td class=" border-l border-black text-center">80</td>
                        <td class=" border-l border-black text-center">depalan Puluh</td>
                    </tr>
                    <tr class=" border border-black">
                        <td colspan="3" class=" text-center border border-black font-semibold">Jumlah Rata Rata</td>
                        <td class=" text-center">120</td>
                    </tr>
                </tbody>
            </table>
            <div class="  flex grid-cols-2 text-right mt-4 text-sm">
                <div class=" w-2/3"></div>
                <div class="  text-left">
                    Kedunglo, {{ now()->isoFormat('D MMMM YYYY') }}<br>
                    Kepala Madrasah<br><br><br><br>
                    <p class=" uppercase"> Muh. Bahrul Ulum, S.H</p>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
    </div>
    </div>

</x-app-layout>