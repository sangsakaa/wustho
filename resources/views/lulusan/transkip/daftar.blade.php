<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Nilai Transkip' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Data  Nilai Transkip') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class=" bg-white border-b border-gray-200">
                <div class=" p-2 flex grid-cols-1 gap-1">
                    <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                        periode
                    </a>
                    <a href="/pengaturan" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                        pengaturan
                    </a>
                    <a href="/pengaturan" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                        pengaturan
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm ">
            <div class=" px-4 py-4 bg-white border-b grid grid-cols-4 border-gray-200">
                <div>
                    Mata Pelajaran
                </div>
                <div>
                    : {{$dataTranskip->mapel}}
                </div>
                <div>
                    Jenis Ujian
                </div>
                <div>
                    : {{$dataTranskip->nama_ujian}}
                </div>
            </div>
        </div>
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1">

                            <form action="/nilai_transkip/{{$transkip->id}}" method="post">
                                @csrf
                                <button class=" bg-red-600 px-1 py-1 text-white w-20"> Simpan</button>
                                <a href="/daftar-transkip" class=" py-1 px-2 bg-blue-600  text-white hover:bg-purple-500">
                                    Kembali
                                </a>
                                <input type="hidden" name="transkip_id" value="{{$transkip->id}}">
                                <table class=" w-full mt-1 border">
                                    <thead class=" border">
                                        <tr class="  uppercase text-sm bg-gray-100">
                                            <th class=" border px-2 py-1">No</th>
                                            <th class=" border px-2 py-1 text-center">Nama Peserta Lulusan</th>
                                            <th class=" border px-2 py-1 text-center">KLS</th>
                                            <th class=" border px-2 py-1 text-center">Nilai Akhir</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataLulusan as $item)
                                        <tr>
                                            <th class=" border px-2 py-1 text-center">{{$loop->iteration}}</th>
                                            <td class=" border px-2 py-1 text-left capitalize">
                                                <input type="hidden" class=" py-1 " name="daftar_lulusan_id[]" value="{{$item->id}}" multiple>
                                                <input type="hidden" name="nilai_transkip_id[{{ $item->id }}]" value="{{ $item->nilai_transkip_id }}">
                                                {{strtolower($item->nama_siswa)}}
                                            </td>
                                            <td class=" border px-2 py-1 text-left capitalize w-4">{{$item->nama_kelas}}</td>
                                            <td class=" border px-2 py-1 text-center capitalize">
                                                <input value="{{ $item->nilai_akhir}}" class=" py-1 w-full text-center capitalize" type="number" name="nilai_akhir[{{ $item->id }}]" placeholder="MIN : 65 MAX : 100">
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>