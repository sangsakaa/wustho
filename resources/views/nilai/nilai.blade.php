<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembelajaran') }}
        </h2>
    </x-slot>

    <div class=" px-4">
        <div class="py-4">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" px-4 py-1">
                            <span class=" text-2xl  text-blue-400">Input Nilai</span>
                        </div>
                        <hr>

                        <div class=" grid grid-cols-4 px-4 py-2">
                            <div>Kelas / Semester</div>
                            <div> : {{$titlenilai->nama_kelas}} / {{$titlenilai->semester}}</div>
                            <div>Mata Pelajaran</div>
                            <div> : {{$titlenilai->mapel}} / {{$titlenilai->nama_kitab}}</div>
                            <div>Guru</div>
                            <div> : {{$titlenilai->nama_guru}}</div>
                            <div>Periode</div>
                            <div> : {{$titlenilai->periode}} {{$titlenilai->ket_semester}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form action="/nilai" method="post">
                            @csrf
                            <div class=" grid grid-cols-2  py-1">

                                <div class=" flex gap-1 justify-items-end">
                                    <button class=" bg-red-600 py-1 rounded-md text-white px-4">simpan nilai</button>
                                    <a href="/nilaimapel" class=" bg-red-600 py-1 rounded-md text-white px-4">Kembali</a>
                                </div>
                            </div>
                            <table class=" w-full">
                                <thead>
                                    <tr class="border">
                                        <th class=" border px-1">#</th>
                                        <th class=" border px-1 w-1/7 ">Nomor Induk Siswa</th>
                                        <th class=" border px-1 ">NAMA SISWA</th>
                                        <th class=" border px-1">KELAS</th>
                                        <th class=" border px-1">NAMAKELAS</th>
                                        <th class=" border px-1 ">NILAI HARIAN</th>
                                        <th class=" border px-1">NILAI UJIAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataSiswa as $item)
                                    <tr class=" border hover:bg-gray-100">
                                        <td class=" px-2 border text-center w-10">
                                            {{$loop->iteration}}
                                            <input type="hidden" name="pesertakelas[]" value="{{$item->id}}">
                                            <input type="hidden" name="nilai_id[{{$item->id}}]" value="{{$item->nilai_id}}">
                                            <input type="hidden" name="semester_id" value="{{$item->id}}">
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{$item->nis}}
                                        </td>
                                        <td class=" px-2 border ">
                                            {{$item->nama_siswa}}
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{$item->kelas}}
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{$item->nama_kelas}}
                                        </td>
                                        <td class="  border text-center w-50">
                                            <input value="{{$item->nilai_harian}}" class=" py-1 w-full text-center" type="number" name="nilai_harian[{{$item->id}}]" default="0" placeholder="min: 50 max:100">
                                        </td>
                                        <td class="  border text-center w-50">
                                            <input value="{{$item->nilai_ujian}}" class="py-1 w-full text-center" type="number" name="nilai_ujian[{{$item->id}}]" placeholder="min: 50 max:100">
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <input type="hidden" name="nilaimapel_id" value="{{$nilaimapel->id}}">
                        </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>