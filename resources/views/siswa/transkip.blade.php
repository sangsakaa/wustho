<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Transkip Nilai ' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transkip Nilai') }}
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
                        <div>
                            <button class=" text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                </svg>
                                Cetak Transkip</button>
                        </div>
                        @endrole
                        <form action="/transkip/{{$siswa->id}}" method="get" class="  gap-1">
                            <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari ..">

                            <!-- <select name="cari" id="" value="{{ request('cari') }}" class=" py-1 rounded-md ">
                                @foreach($periode as $item)
                                <option value="{{$item->id}}">{{$item->periode}} {{$item->ket_semester}}</option>
                                @endforeach
                            </select> -->
                            <button type="submit" class=" px-2 py-1   bg-blue-500  rounded-md text-white">
                                Filter </button>
                        </form>
                    </div>
                    <div id="div1">
                        <p class=" capitalize text-center mt-2 mb-2 text-2xl ">kartu hasil tadris</p>
                        <div class=" grid sm:grid-cols-4 grid-cols-4">
                            <div>Nomor Induk Siswa</div>
                            <div class=" text-sm">: {{$tittle->nis}} </div>

                            <div>Periode / Semester</div>
                            <div>: -</div>
                            <div>Nama Lengkap</div>
                            <div class=" text-xs sm:text-sm">: {{$tittle->nama_siswa}} </div>
                            <div>Kelas</div>
                            <div>: </div>

                        </div>
                        <hr>
                        <table class=" w-full mt-2">
                            <thead>
                                <tr class=" border bg-gray-100">
                                    <th class=" text-xs sm:text-sm px-2 py-1 border capitalize">no</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize">Periode</th>
                                    <!-- <th class=" text-xs sm:text-sm px-2 border capitalize">Peserta Kelas</th> -->
                                    <th class=" text-xs sm:text-sm px-2 border capitalize">Kelas</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize">Mata Pelajaran</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize text-center">nilai harian</th>
                                    <th class=" text-xs sm:text-sm px-2 border capitalize text-center">nilai ujian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($transkip->count() !== null)
                                @foreach($transkip as $nilai)
                                <tr class=" hover:bg-gray-50">
                                    <th class="text-xs sm:text-sm border w-5">{{$loop->iteration}}</th>
                                    <td class="text-xs sm:text-sm px-2 border  ">{{$nilai->periode}} {{$nilai->ket_semester}}</td>
                                    <!-- <td class="text-xs sm:text-sm px-2 border ">{{$nilai->nama_siswa}}</td> -->
                                    <td class="text-xs sm:text-sm px-2 border  text-center">{{$nilai->nama_kelas}}</td>
                                    <td class="text-xs sm:text-sm px-2 border ">{{$nilai->mapel}}</td>
                                    <td class="text-xs sm:text-sm px-2 border  text-center w-10">{{$nilai->nilai_harian}}</td>
                                    <td class="text-xs sm:text-sm px-2 border  text-center w-10">{{$nilai->nilai_ujian}}</td>
                                </tr>
                                @endforeach
                                @else
                                ok
                                @endif
                                <tr>
                                    <td class=" px-2 border w-40  text-center" colspan="4">Jumlah Nilai</td>
                                    <td class=" px-2 border w-40  text-center"></td>
                                    <td class=" px-2 border w-40  text-center"></td>
                                </tr>
                                <tr>
                                    <td class=" px-2 border  text-center " colspan="4">
                                        Rata Rata
                                    </td>
                                    <td class=" px-2 border  text-center " colspan="1">

                                    </td>
                                    <td class=" px-2 border  text-center " colspan="1">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>