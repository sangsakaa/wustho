<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Raport' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Report') }}
        </h2>
    </x-slot>

    <div class="py-1 ">
        <div class=" mx-auto sm:px-2 lg:px-2">
            <div class=" py-2">
                <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                    </svg>
                    Cetak Raport</button>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div id="div1" class="grid  p-2 bg-white border-b border-gray-200">
                    <div class=" grid grid-cols-1 justify-items-center">
                        <script>
                            function printContent(el) {
                                var fullbody = document.body.innerHTML;
                                var printContent = document.getElementById(el).innerHTML;
                                document.body.innerHTML = printContent;
                                window.print();
                                document.body.innerHTML = fullbody;
                            }
                        </script>
                        <span class=" font-semibold "> DAFTAR NILAI HASIL TADRIS</span>
                        <span class=" font-semibold"> MADRASAH DINIYAH WUSTHO WAHIDIYAH</span>
                    </div>
                    <hr>

                    <div class=" text-1xl py-2 grid  grid-cols-2 w-full">

                        <div>
                            Nomor Induk Siswa
                        </div>
                        <div>
                            : <span class=" font-semibold">{{$siswa->nis}}</span>
                        </div>
                        <div class=" w-40">
                            Nama Lengkap
                        </div>
                        <div class=" text-sm">
                            : {{$siswa->nama_siswa}}
                        </div>
                        <div>
                            Tempa ,Tanggal Lahir
                        </div>
                        <div>
                            : {{$siswa->tempat_lahir}}, <?php
                                                        $date = date_create($siswa->tanggal_lahir);
                                                        echo date_format($date, "d-M-Y");
                                                        ?></p>
                        </div>
                        <div>
                            Marhalah
                        </div>
                        <div>

                            : {{$siswa->kelas}} / {{$siswa->madrasah_diniyah}}
                        </div>

                        <div>
                            Periode
                        </div>
                        <div>
                            : {{$siswa->periode}} {{$siswa->ket_periode}} {{$siswa->ket_semester}}
                        </div>


                    </div>
                    <hr>

                    <span class=" font-semibold">A. Natijah Dirrosiyyah</span>

                    <table class=" w-full">
                        <thead class=" bg-gray-100  border font-semibold ">
                            <tr>
                                <th class=" border px-2" rowspan="2">No </th>
                                <th class=" border px-2" rowspan="2">MATA PELAJARAN</th>
                                <th class=" border px-2" rowspan="2">USTADZ / USTADZAH</th>
                                <td colspan="2" class=" border text-center"> NILAI AKHIR </td>
                            </tr>
                            <tr>
                                <td class=" PX-2 text-center">YAUMIYYAH</td>
                                <td class=" PX-2 text-center">IMTIHAMIYYAH</td>
                            </tr>
                        </thead>
                        @foreach ($data as $item)
                        <tbody class=" text-md">
                            <tr>
                                <th class=" px-2 border">{{$loop->iteration}}</th>
                                <td class=" px-2 border">{{$item->mapel}}</td>
                                <td class=" px-2 border text-center"> {{$item->nama_guru}}</td>
                                <td class=" px-2 border text-center">{{$item->nilai_harian}}</td>
                                <td class=" px-2 border text-center">{{$item->nilai_ujian}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                        <tr>
                            <td class=" px-2 border text-right font-semibold" colspan="3">Jumlah</td>
                            <td class=" px-2 border text-center">{{$data->sum('nilai_harian')}}</td>
                            <td class=" px-2 border text-center">{{$data->sum('nilai_ujian')}}</td>

                        </tr>
                        <tr>
                            <td class=" px-2 border text-right font-semibold" colspan="3">Rata Rata</td>
                            <td class=" px-2 border text-center">{{number_format($data->sum('nilai_harian')/$data->count('nilai_hari'),2,',',2)}}</td>
                            <td class=" px-2 border text-center">{{number_format($data->sum('nilai_ujian')/$data->count('nilai_ujian'),2,',',2)}}</td>

                        </tr>
                        <tr>
                            <td class=" px-2 border text-right font-semibold" colspan="3">Darojah</td>
                            <td class=" px-2 border text-center"></td>
                            <td class=" px-2 border text-center">-</td>
                        </tr>
                        <tr>
                            <td class=" px-2 border text-right font-semibold" colspan="3">Al Bayan</td>
                            <td class=" px-2 border text-center">Naik / Tidak Naik</td>
                            <td class=" px-2 border text-center">-</td>
                        </tr>
                    </table>

                    <span class=" font-semibold">B. Natijah Dirrosiyyah</span>
                    <table class=" w-full">
                        <thead class=" bg-gray-100  border text-sm">
                            <tr class=" px-2" class=" border text-sm">
                                <th class="border px-2">No</th>
                                <th class="border px-2 w-50"> Al Amaliyyah</th>
                                <th class="border px-2 w-5 text-sm">Attaqdir Al Mukhutasab</th>
                                <th class="border px-2">Al Bayan</th>
                            </tr>
                        </thead>
                        <tbody class=" text-md">
                            <tr class=" border ">
                                <th class=" px-2 border ">1</th>
                                <td class=" px-2 border ">Jama'ah Al Maktubah</td>
                                <td class=" px-2 border ">Jayyid</td>
                                <td class=" px-2 border " rowspan="8">
                                    <p>Keterangan</p>
                                    <div class=" grid grid-cols-2">
                                        <div>1. Rodi'</div>
                                        <div> : Buruk / Jelek</div>
                                        <div>2. Makbul</div>
                                        <div> : Cukup</div>
                                        <div>3. Jayyid</div>
                                        <div> : Baik</div>
                                        <div>4. Mumtaz</div>
                                        <div> : Istimewa</div>

                                    </div>
                                </td>
                            </tr>
                            <tr class=" border">
                                <th class=" px-2 border ">2</th>
                                <td class=" px-2 border ">Al Mujahadah</td>
                                <td class=" px-2 border ">Jayyid</td>
                            </tr>
                            <tr class=" border">
                                <th class=" px-2 border ">3</th>
                                <td class=" px-2 border ">Al Muhadhloroh</td>
                                <td class=" px-2 border ">Jayyid</td>
                            </tr>
                            <tr class=" border">
                                <th class=" px-2 border ">4</th>
                                <td class=" px-2 border ">An Nadzhofah</td>
                                <td class=" px-2 border ">Jayyid</td>
                            </tr>
                            <tr class=" border">
                                <th class=" px-2 border ">5</th>
                                <td class=" px-2 border ">Al Muwadhobah</td>
                                <td class=" px-2 border ">Jayyid</td>
                            </tr>
                            <tr class=" border">
                                <th class=" px-2 border ">6</th>
                                <td class=" px-2 border ">As Suluk</td>
                                <td class=" px-2 border ">Jayyid</td>
                            </tr>
                            <tr class=" border">
                                <th class=" px-2 border ">7</th>
                                <td class=" px-2 border ">At Taslim</td>
                                <td class=" px-2 border ">Jayyid</td>
                            </tr>
                        </tbody>
                    </table>

                    <span class=" font-semibold">C. Kehadiran</span>
                    <table class=" w-1/3 ">
                        <thead class=" bg-gray-100  border">
                            <tr class=" px-2" class=" border">
                                <th class="border px-2 w-5">No</th>

                                <th class="border px-2">KETERANGAN</th>
                                <th class="border px-2 w-5">JML</th>

                            </tr>
                        </thead>
                        <tbody class=" text-sm">
                            <tr class=" border">
                                <td class=" px-2 border ">1</td>
                                <td class=" px-2 border ">IZIN</td>
                                <td class=" px-2 border text-center "> 2</td>
                            </tr>
                            <tr class=" border">
                                <td class=" px-2 border ">2</td>
                                <td class=" px-2 border ">SAKIT</td>
                                <td class=" px-2 border text-center ">3</td>

                            </tr>
                            <tr class=" border">
                                <td class=" px-2 border ">3</td>
                                <td class=" px-2 border ">ALFA</td>
                                <td class=" px-2 border text-center "> 5 </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="  flex grid-cols-2 text-right">
                        <div class=" w-2/3"></div>
                        <div class="  text-left">
                            Kedunglo, <?php
                                        $date = date_create(now());
                                        echo date_format($date, "d-M-Y");
                                        ?></p>
                            Al Mudir / Kepala <br><br><br><br>
                            Muh. Babrul Ulum, S.H
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>