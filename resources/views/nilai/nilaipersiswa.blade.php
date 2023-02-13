<x-app-layout>
    <x-slot name="header">
        @section('title', ' | KHT')
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Kartu Hasil Tadris') }}
        </h2>
    </x-slot>
    <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm">
        <div class="p-4  border-b border-gray-200">
            <div class=" flex grid-cols-1 sm:grid-cols-2 gap-1 w-full  py-1">
                <div>
                    <button class=" flex w-10 justify-center text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                        <x-icons.print></x-icons.print>
                    </button>
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

                <!-- In a Blade template -->

                <?php
                $object = ''; // retrieve the object from somewhere

                $pesertakelas_id = (!empty($user) && isset($user->pesertakelas_id))
                ?>
                <div class=" w-full">
                    <form action="/nilai" method="get">
                        <select name="kelasmi" id="" class=" border border-green-800 text-green-800 rounded-md py-1" required>
                            <option value="">-- Pilih Periode --</option>
                            @foreach ($kelasmiSiswa as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasmiTerpilih->id == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class=" px-2  py-1   bg-blue-500  rounded-md text-white">
                            Periode
                        </button>
                    </form>
                </div>
            </div>
            <div id="div1">
                <div class=" overflow-auto  rounded-md ">
                    <div class=" text-center  text-2xl capitalize py-2">
                        <span class=" font-semibold uppercase underline"> kartu hasil tadris</span>
                    </div>
                    <div class=" font-semibold text-xs sm:text-sm grid grid-cols-2 sm:grid-cols-4 gap-1">
                        <div>Nomor Induk Siswa </div>
                        <div> : {{$user->nis}} </div>
                        <div>Kelas / Semester </div>

                        <div> : {{$title->nama_kelas}}/{{$title->semester}}</div>

                        <div>Nama Siswa </div>
                        <div class=" w-full text-xs"> : {{$user->nama_siswa}} </div>
                        <div>Periode </div>
                        <div> : {{$title->periode}} {{$title->ket_semester}}</div>
                    </div>
                    <hr class=" py-1">
                    <table class=" text-xs sm:text-sm w-full ">
                        <thead>
                            <tr class="border bg-gray-100 dark:bg-purple-600">
                                <th class=" border px-1  py-1">No</th>
                                <th class=" border px-1">Pelajaran</th>
                                <th class=" border px-1">Kitab</th>
                                <th class=" border px-1">Nama Guru</th>
                                <th class=" border px-1">NH</th>
                                <th class=" border px-1">NU</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($dataNilai->count())
                            @foreach ($dataNilai as $nilai)
                            <tr class="border  even:bg-gray-50">
                                <td class=" border text-center px-1">{{ $loop->iteration }}</td>
                                <td class=" border text-center px-1 py-2">{{ $nilai->mapel }}</td>
                                <td class=" border text-center px-1 py-2">{{ $nilai->nama_kitab }}</td>
                                <td class=" border text-left px-1">{{ $nilai->nama_guru }}</td>
                                <td class=" border text-center px-1">
                                    @if($nilai->nilai_harian == 0 )
                                    <span class=" text-red-600 font-semibold text-xs"> Nan </span>
                                    @else
                                    {{ $nilai->nilai_harian }}
                                    @endif
                                </td>
                                <td class=" border text-center px-1"> @if($nilai->nilai_ujian == 0 )
                                    <span class=" text-red-600 font-semibold text-xs"> Nan </span>
                                    @else
                                    {{ $nilai->nilai_ujian }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class=" text-center font-semibold text-sm border py-2" colspan="4">Total Nilai</td>
                                <td class=" text-center font-semibold text-sm border">{{$dataNilai->sum->nilai_harian}}</td>
                                <td class=" text-center font-semibold text-sm border">{{$dataNilai->sum->nilai_ujian}}</td>

                            </tr>
                            <tr>
                                <td class=" text-center font-semibold text-sm border py-2" colspan="4">Nilai Rata Rata </td>
                                <td class=" text-center font-semibold text-sm border">{{ number_format($dataNilai->sum->nilai_harian / $dataNilai->count(),0,2) }}</td>
                                <td class=" text-center font-semibold text-sm border">{{ number_format($dataNilai->sum->nilai_ujian / $dataNilai->count(),0,2) }}</td>


                            </tr>
                            @else
                            <tr class="border">
                                <td colspan="11" class="text-sm border text-center py-1">
                                    <span class=" text-red-600 font-semibold text-center">Tidak ada nilai yang di masukan</span>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class=" p-4 bg-sky-200">
            <div class="px-2"><span class=" underline">Catatan :</span></div>
            <div class=" px-4">
                <p>1. Nan : Tidak memiliki nilai atau belum tuntas</p>
            </div>
        </div>
    </div>

</x-app-layout>