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
                <div class=" text-green-800 ">
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
                    <div class=" flex grid-cols-4 font-semibold text-xs gap-5 py-1">
                        <div class=" w-20">Kelas</div>
                        <div>: {{$item->nama_kelas}}</div>
                        <div>Tanggal</div>
                        <div>: .......... {{$bulan }}</div>
                    </div>
                    <div class=" text-center">
                        <p class=" uppercase text-xs font-semibold">izin mengikuti/meninggalkan pelajaran</p>
                        <hr>
                    </div>
                    <div class=" grid grid-cols-2">
                        <div class=" py-1">Nama</div>
                        <div class=" py-1 border-b-2 ">:</div>
                        <div class=" py-1">Kelas</div>
                        <div class=" py-1 border-b-2 ">:</div>
                        <div class=" py-1">Asrama</div>
                        <div class=" py-1 border-b-2 ">:</div>
                    </div>
                    <div class=" ">
                        <p class="  capitalize text-xs">untuk mengikuti/meninggalkan pelajaran karena</p>
                        <div class="">
                            <input type="checkbox" name="" id=""> Sakit
                            <input type="checkbox" name="" id=""> Izin
                            <div class=" h-20 border border-green-800">
                                <p class="px-1">Alasan :</p>
                                <p></p>
                            </div>
                            <div class=" grid grid-cols-2">
                                <div class="  text-center">
                                    <p>Ketua Asrama,</p>
                                    <p class=" mt-16">..............</p>
                                </div>
                                <div class=" text-center">
                                    <p>Mentor,</p>
                                    <p class=" mt-16">..............</p>
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