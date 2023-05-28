<x-app-layout>
    <x-slot name="header">
        @section('title', '| Blanko Presensi Kelas : ')
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Blanko Presensi Kelas') }}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 flex grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 " onclick="printContent('blanko')">
                        Cetak
                    </button>
                </div>
            </div>
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

    <div class="py-1" id="blanko">
        <style>
            .page-break {
                page-break-after: always;
            }
        </style>
        <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm">
            <div class=" px-2  grid grid-cols-2 gap-2">
                @foreach ($kelasmi as $item)
                <div class=" ">
                    <div class=" overflow-auto bg-white dark:bg-dark-bg block sm:hidden ">
                        <div class=" text-center text-green-900  ">
                            <p class=" font-semibold text-sm">
                                MADRASAH DINIYAH WUSTHO WAHIDIYAH
                            </p>
                            <p class=" font-semibold uppercase text-sm">
                                TAHUN PELAJARAN {{$item->periode}} {{$item->ket_semester}}
                            </p>
                        </div>
                        <hr class=" border-b-2 border-green-900">
                    </div>
                    <div class=" flex grid-cols-4 font-semibold text-sm gap-5 py-1">
                        <div class=" w-20">Kelas</div>
                        <div>: {{$item->nama_kelas}}</div>
                        <div>Tanggal</div>
                        <div>: ............ {{$bulan }}</div>
                    </div>
                    <table class=" w-full mb-5">
                        <thead class=" text-sm">
                            <tr class=" border border-green-800">
                                <th class=" border border-green-800" rowspan="2">No</th>
                                <th class=" border border-green-800" rowspan="2">Nama Murid</th>
                                <th class=" border border-green-800" colspan="3">Keterangan</th>
                                <th class=" border border-green-800" colspan="3">Keterangan</th>
                            </tr>
                            <tr class=" border border-green-800">
                                <th class=" border border-green-800 w-8">S</th>
                                <th class=" border border-green-800 w-8">I</th>
                                <th class=" border border-green-800 w-8">A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 10; $i++) <tr class=" border border-green-800">
                                <th class=" border border-green-800 py-3 w-5 px-1 "> {{ $i }}
                                </th>
                                <td class=" border border-green-800 "></td>
                                <td class=" border border-green-800 "></td>
                                <td class=" border border-green-800 "></td>
                                <td class=" border border-green-800 "></td>

                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
                @endforeach

            </div>
            <div class="page-break "></div>
            <div class=" grid grid-cols-2 gap-1">
                @foreach ($kelasmi as $item)
                <div class=" text-green-800 border-green-900  border p-1 ">
                    <div class=" flex grid-cols-2">
                        <div><img src={{ asset("asset/images/logo.png") }} alt="" width="50" class=""></div>
                        <div class=" w-full  ">
                            <center>
                                </p>
                                <p class="  font-serif text-xs uppercase">pondok pesantren kedunglo al munadhdhoroh</p>
                                <p class="  uppercase font-serif text-xs font-semibold text-monospace ">madrasah diniyah wustho
                                    Wahidiyah</p>
                                <p class=" capitalize font-serif text-xs">Alamat : Jl.KH. Wachid Hasyim Kota Kediri 64114 Jawa Timur </p>
                                <hr class=" border-b-1 border-green-700 ">
                                <p class=" text-xs"> Tahun Pelajaran {{$item->periode}} {{$item->ket_semester}}</p>
                            </center>

                        </div>
                    </div>
                    <div class=" text-center">
                        <p class="   text-sm uppercase font-semibold   underline border-b-green-800">Surat izin </p>
                    </div>
                    <div class=" px-2 grid grid-cols-">
                        <div class="   w-32 grid grid-cols-2">
                            <div>
                                Nama
                            </div>
                            <div>:</div>
                        </div>
                        <div class="  border-b-2 mt-2 "></div>
                        <div class="    w-32 grid grid-cols-2">
                            <div>
                                kelas
                            </div>
                            <div>:</div>
                        </div>
                        <div class="  border-b-2  ">
                            @foreach ($kelasmi as $item)
                            <input type="checkbox" name="" id="" class="  uppercase text-bold ">
                            <span class="">{{$item->nama_kelas}}</span>
                            @endforeach
                        </div>
                        <div class="   w-32 grid grid-cols-2">
                            <div>
                                Asrama
                            </div>
                            <div>:</div>
                        </div>
                        <div class="  border-b-2 mt-2  "></div>
                    </div>
                    <div class=" text-xs ">
                        <p class="  capitalize text-xs py-1">Diberikan izin tidak mengikuti Kegiatan Madin Wustho Wahidiyah karena : </p>
                        <div class="">
                            <input type="checkbox" name="" id=""> Sakit
                            <input type="checkbox" name="" id=""> Izin
                            <div class="   flex grid-cols-2">
                                <div class=" mt-1  w-3/4  h-12 border border-green-800">
                                    <p class="px-1">Alasan :</p>
                                    <p></p>
                                </div>
                                <div class=" px-1   text-xs  grid grid-cols-1">

                                    <p class=" text-xs sm:text-xs">Ketua Asrama,</p>
                                    <p>Kediri,__{{$bulan}}</p>
                                    <p class="   mt-5 ">..............</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="page-break "></div>
            </div>

        </div>

</x-app-layout>