<x-app-layout>
    <x-slot name="header">
        @section('title', $siswa->nama_siswa )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Raport : {{$siswa->nama_siswa}}
        </h2>
    </x-slot>

    <div class="py-1 ">
        <div class=" mx-auto sm:px-2 lg:px-2">
            <div class=" py-2 flex gap-2">
                <div>
                    <button class="flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                        </svg>
                        Cetak Raport</button>
                </div>
                <div class=" py-1">
                    <a href="/pengaturan" class=" py-1 px-2 bg-red-600 rounded-md text-white">Batal</a>
                </div>

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
                        <span class=" uppercase"> Tahun Pelajaran {{$siswa->periode}} {{$siswa->ket_periode}} {{$siswa->ket_semester}}</span>
                    </div>
                    <hr class=" border-black">

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
                            Tempat ,Tanggal Lahir
                        </div>
                        <div>
                            : {{$siswa->tempat_lahir}}, {{ Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('D MMMM YYYY') }}
                        </div>
                        <div>
                            Marhalah
                        </div>
                        <div>

                            : {{$siswa->kelas}} / {{$siswa->nama_kelas}} / {{$siswa->madrasah_diniyah}}
                        </div>

                        <div>
                            Imtihan / Periode
                        </div>
                        <div>
                            : {{$siswa->periode}} {{$siswa->ket_periode}} {{$siswa->ket_semester}}
                        </div>


                    </div>
                    <hr>

                    <span class=" font-semibold">A. Natijah Dirrosiyyah</span>

                    <table class=" w-full">
                        <thead class=" bg-green-800  border font-semibold ">
                            <tr class=" text-white">
                                <th class=" border border-green-800 px-2" rowspan="2">NO </th>
                                <th class=" border border-green-800 px-2" rowspan="2">MATA PELAJARAN</th>
                                <th class=" border border-green-800 px-2" rowspan="2">USTADZ / USTADZAH</th>
                                <td colspan="2" class=" border border-green-800 text-center"> NILAI </td>
                            </tr>
                            <tr class=" text-white">
                                <td class=" PX-2 text-center">YAUMIYAH</td>
                                <td class=" PX-2 text-center">IMTIHANIYAH</td>
                            </tr>
                        </thead>
                        @foreach ($data as $item)
                        <tbody class=" text-md">
                            <tr>
                                <th class=" px-2 border border-green-800">{{$loop->iteration}}</th>
                                <td class=" px-2 border border-green-800">{{$item->mapel}}</td>
                                <td class=" px-2 border border-green-800 text-center"> {{$item->nama_guru}}</td>
                                <td class=" px-2 border border-green-800 text-center">{{$item->nilai_harian}}</td>
                                <td class=" px-2 border border-green-800 text-center">{{$item->nilai_ujian}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                        <tr>
                            <td class=" px-2 border border-green-800 text-right font-semibold" colspan="3">Jumlah</td>
                            <td class=" px-2 border border-green-800 text-center">{{$ringkasan['jmlharian']}}</td>
                            <td class=" px-2 border border-green-800 text-center">{{$ringkasan['jmlujian']}}</td>
                        </tr>
                        <tr>
                            <td class=" px-2 border border-green-800 text-right font-semibold" colspan="3">Rata Rata</td>
                            <td class=" px-2 border border-green-800 text-center">
                                {{number_format($ringkasan['rata2harian'], 2, ",", "")}}
                            </td>
                            <td class=" px-2 border border-green-800 text-center">
                                {{number_format($ringkasan['rata2ujian'], 2, ",", "")}}
                            </td>
                        </tr>
                        <tr>
                            <td class=" px-2 border border-green-800 text-right font-semibold" colspan="3">Darojah</td>
                            <td class=" px-2 border border-green-800 text-center">{{$peringkat}}</td>
                            <td class=" px-2 border border-green-800 text-center">{{$peringkat}} dari {{$jumlahsiswa}}</td>
                        </tr>
                        <tr>
                            <td class=" px-2 border border-green-800 text-right font-semibold" colspan="3">Al Bayan</td>
                            <td class=" px-2 border border-green-800 text-center">Naik / Tidak Naik</td>
                            <td class=" px-2 border border-green-800 text-center">-</td>
                        </tr>
                    </table>
                    <span class=" font-semibold">B. Natijah Amaliyah Yaumiyyah</span>
                    <table class=" w-full">
                        <thead class=" bg-green-800  border text-sm text-white uppercase ">
                            <tr class=" px-2" class=" border text-sm   ">
                                <th class="border px-2 py-2">no</th>
                                <th class="border px-2 w-50"> Al Amaliyyah</th>
                                <th class="border px-2 w-50 text-sm">Attaqdir Al Muktasab</th>
                                <th class="border px-2">Al Bayan</th>
                            </tr>
                        </thead>
                        <tbody class=" text-md">
                            <tr class=" border border-green-800 ">
                                <th class=" px-2 border border-green-800 ">1</th>
                                <td class=" px-2 border border-green-800 ">Jama'ah Al Maktubah</td>
                                <td class=" px-2 border border-green-800 text-center ">Jayyid</td>
                                <td class=" px-2 border border-green-800 " rowspan="8">
                                    <p>Al Bayan</p>
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
                            <tr class=" border border-green-800">
                                <th class=" px-2 border border-green-800 ">2</th>
                                <td class=" px-2 border border-green-800 ">Al Mujahadah</td>
                                <td class=" px-2 border border-green-800 text-center ">Jayyid</td>
                            </tr>
                            <tr class=" border border-green-800">
                                <th class=" px-2 border border-green-800 ">3</th>
                                <td class=" px-2 border border-green-800 ">Al Muhadhdhoroh</td>
                                <td class=" px-2 border border-green-800 text-center ">Jayyid</td>
                            </tr>
                            <tr class=" border border-green-800">
                                <th class=" px-2 border border-green-800 ">4</th>
                                <td class=" px-2 border border-green-800 ">An Nadzhofah</td>
                                <td class=" px-2 border border-green-800 text-center ">Jayyid</td>
                            </tr>
                            <tr class=" border border-green-800">
                                <th class=" px-2 border border-green-800 ">5</th>
                                <td class=" px-2 border border-green-800 ">Al Muwadhobah</td>
                                <td class=" px-2 border border-green-800 text-center ">Jayyid</td>
                            </tr>
                            <tr class=" border border-green-800">
                                <th class=" px-2 border border-green-800 ">6</th>
                                <td class=" px-2 border border-green-800 ">As Suluk</td>
                                <td class=" px-2 border border-green-800 text-center ">Jayyid</td>
                            </tr>
                            <tr class=" border border-green-800">
                                <th class=" px-2 border border-green-800 ">7</th>
                                <td class=" px-2 border border-green-800 ">At Tasliim</td>
                                <td class=" px-2 border border-green-800 text-center ">Jayyid</td>
                            </tr>
                        </tbody>
                    </table>

                    <span class=" font-semibold">C. Kehadiran</span>
                    <table class=" w-1/3 ">
                        <thead class=" text-white bg-green-800  border">
                            <tr class=" px-2" class=" border">
                                <th class="border border-green-800 px-2 w-5 py-2">NO</th>
                                <th class="border border-green-800 px-2">KETERANGAN</th>
                                <th class="border border-green-800 px-2 w-5">JML</th>

                            </tr>
                        </thead>
                        <tbody class=" text-sm">
                            <tr class=" border border-green-800">
                                <td class=" px-2 border border-green-800 ">1</td>
                                <td class=" px-2 border border-green-800 ">IZIN</td>
                                <td class=" px-2 border border-green-800 text-center ">{{ $siswa->izin === 0 || !$siswa->izin ? '-' : $siswa->izin }}</td>
                            </tr>
                            <tr class=" border border-green-800">
                                <td class=" px-2 border border-green-800 ">2</td>
                                <td class=" px-2 border border-green-800 ">SAKIT</td>
                                <td class=" px-2 border border-green-800 text-center ">{{ $siswa->sakit === 0 || !$siswa->sakit ? '-' : $siswa->sakit }}</td>

                            </tr>
                            <tr class=" border border-green-800">
                                <td class=" px-2 border border-green-800 ">3</td>
                                <td class=" px-2 border border-green-800 ">ALFA</td>
                                <td class=" px-2 border border-green-800 text-center ">{{ $siswa->alfa === 0 || !$siswa->alfa ? '-' : $siswa->alfa }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="  flex grid-cols-2 text-right">
                        <div class=" w-2/3"></div>
                        <div class="  text-left">
                            Kedunglo, {{ now()->isoFormat('D MMMM YYYY') }}<br>
                            Al Mudir / Kepala <br><br><br><br>
                            Muh. Bahrul Ulum, S.H
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>