<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Transkip Nilai ' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transkip - {{ $siswa->nama_siswa }}
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
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 bg-white border-b border-gray-200">
                    <div class="px-1 py-2 bg-white border-b border-gray-200 grid grid-cols-2 sm:grid-cols-2 gap-2">
                        @role('admin')
                        <div class=" flex gap-1">
                            <button class=" flex text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                                <x-icons.print></x-icons.print>
                                Transkip
                            </button>
                        </div>
                        <div class=" flex grid-cols-1 justify-end gap-2">

                            <form action="/transkip/{{$siswa->id}}" method="get" class=" flex gap-1">
                                <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari ..">

                                <button type="submit" class=" px-2 py-1   bg-blue-500  rounded-md text-white">
                                    Pilih Periode </button>
                            </form>
                            <a href="/transkip/{{$siswa->id}}" class=" bg-purple-500 py-1 px-2 text-white rounded-md ">refresh</a>
                        </div>
                        @endrole
                    </div>
                    <div id="div1">
                        <!-- <img src={{ asset("asset/images/04.jpg") }} alt="" width="100%"> -->
                        <p class=" capitalize text-center mt-2 mb-2 text-2xl underline  ">kartu hasil tadris
                        </p>

                        <div class=" grid sm:grid-cols-4 grid-cols-4 text-sm">
                        </div>
                        <hr>
                        {{$nilai}}
                        <table class=" w-full mt-2">
                            <thead>
                                <tr class=" border bg-gray-100 ">
                                    <th class=" text-xs sm:text-sm px-2 py-2 border capitalize">no</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize w-1/4">Periode</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize w-1/4">nama guru</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize">Kelas</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize w-1/4">Mata Pelajaran</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize text-center w-1">n h</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize text-center">n u</th>
                                </tr>
                            </thead>
                            @foreach( $nilai as $item)
                            <tr>
                                <th class=" border px-2 py-2 w-2 ">{{$loop->iteration}}</th>
                                <td class=" border px-2 text-center  ">{{$item->periode}} {{$item->ket_semester}}</td>
                                <td class=" border px-2 ">{{$item->nama_guru}}</td>
                                <td class=" border px-2  text-center w-1  ">{{$item->nama_kelas}}</td>
                                <td class=" border px-2 ">{{$item->mapel}}</td>
                                <td class=" border px-2 text-center w-4  ">{{$item->nilai_ujian}}</td>
                                <td class=" border px-2 text-center w-4  ">{{$item->nilai_harian}}</td>
                            </tr>
                            @endforeach
                            <tbody>

                            </tbody>
                        </table>
                        <div class=" flex grid-cols-2">
                            <div class=" text-sm ">Jumlah Mata Pelajaran yang diambil pada semeter ini <b><u></u></b> </div>
                            <div class=" px-2 text-sm"> :</div>
                        </div>
                        <p class=" text-sm">Ket : NH: Nilai Harian NU : Nilai ujian </p>
                        <div class="  flex grid-cols-2 text-right">
                            <div class=" w-2/3"></div>
                            <div class="  text-left text-sm">
                                Kedunglo, <?php
                                            $date = date_create(now());
                                            echo date_format($date, "d-M-Y");
                                            ?></p>
                                Al Mudir / Kepala <br><br><br><br>
                                Muh. Bahrul Ulum, S.H
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>