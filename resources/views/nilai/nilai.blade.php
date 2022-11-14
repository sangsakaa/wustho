<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Dashboard Input Nilai Kelas') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="py-2">
            <div class="">
                <div class="bg-white dark:bg-purple-600 overflow-hidden shadow-sm ">
                    <div class="">
                        <div class=" py-1">
                            <span class=" sm:text-2xl text-sm   px-2 text-blue-400">Input Nilai</span>
                        </div>
                        <hr>

                        <div class=" grid sm:grid-cols-4 grid-cols-2  sm:px-4 px-2 py-2">
                            <div class=" sm:text-sm text-xs">Kelas / Semester</div>
                            <div class=" sm:text-sm text-xs"> : {{$titlenilai->nama_kelas}} / {{$titlenilai->semester}}</div>
                            <div class=" sm:text-sm text-xs">Mata Pelajaran</div>
                            <div class=" sm:text-sm text-xs"> : {{$titlenilai->mapel}}/{{$titlenilai->nama_kitab}}</div>
                            <div class=" sm:text-sm text-xs">Guru</div>
                            <div class=" sm:text-sm text-xs"> : {{$titlenilai->nama_guru}}</div>
                            <div class=" sm:text-sm text-xs">Periode</div>
                            <div class=" sm:text-sm text-xs"> : {{$titlenilai->periode}} {{$titlenilai->ket_semester}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="  bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                    <div class="p-2">
                        <form action="/nilai" method="post">
                            @csrf
                            <div class=" flex  justify-items-end  ">
                                <div class=" grid grid-cols-2 gap-2  ">
                                    <button class=" bg-red-600 py-1 sm:w-full rounded-md text-white px-4">simpan nilai</button>
                                    <a href="/nilaimapel" class=" sm:w-full bg-red-600 py-1 rounded-md text-white px-4">Kembali</a>
                                </div>
                            </div>
                            <div class=" overflow-auto">
                                <table class=" mt-2 w-full">
                                    <thead>
                                        <tr class="border capitalize">
                                            <th class="sm:text-sm text-xs border px-1">NO</th>
                                            <th class="sm:text-sm text-xs border px-1 w-1/7 ">NIS</th>
                                            <th class="sm:text-sm text-xs border px-1 ">NAMA</th>
                                            <th class="sm:text-sm text-xs border px-1">KLS</th>
                                            <th class="sm:text-sm text-xs border px-1">NK</th>
                                            <th class="sm:text-sm text-xs border px-1 ">NH</th>
                                            <th class="sm:text-sm text-xs border px-1">NU</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataSiswa as $item)
                                        <tr class=" border hover:bg-gray-100 dark:hover:bg-purple-600">
                                            <td class=" px-2 border text-center w-10">
                                                {{$loop->iteration}}
                                                <input type="hidden" name="pesertakelas[]" value="{{$item->id}}">
                                                <input type="hidden" name="nilai_id[{{$item->id}}]" value="{{$item->nilai_id}}">
                                                <input type="hidden" name="semester_id" value="{{$item->id}}">
                                            </td>
                                            <td class="sm:text-sm text-xs px-2 border text-center ">
                                                {{$item->nis}}
                                            </td>
                                            <td class="sm:text-sm  sm:h-full text-xs px-2 border capitalize ">
                                                {{strtolower($item->nama_siswa)}}
                                            </td>
                                            <td class="sm:text-xs text-xs px-2 border text-center ">
                                                {{$item->kelas}}
                                            </td>
                                            <td class="sm:text-sm text-xs px-2 border text-center ">
                                                {{$item->nama_kelas}}
                                            </td>
                                            <td class="sm:text-sm text-xs  border text-center w-50">
                                                <input value="{{$item->nilai_harian}}" class="sm:text-sm text-xs py-1 w-full text-center" type="number" name="nilai_harian[{{$item->id}}]" default="0" placeholder="min: 50 max:100">
                                            </td>
                                            <td class="sm:text-sm text-xs  border text-center w-50">
                                                <input value="{{$item->nilai_ujian}}" class="sm:text-sm text-xs py-1 w-full text-center" type="number" name="nilai_ujian[{{$item->id}}]" placeholder="min: 50 max:100">
                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="nilaimapel_id" value="{{$nilaimapel->id}}">
                        </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>