<x-app-layout>
    <x-slot name="header">
        @section('title', '| Presensi Kelas : '.$dataKelas->nama_kelas )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Presensi Kelas') }}
        </h2>
    </x-slot>

    <div class=" px-4">
        <div class="py-4">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" px-4 py-1">
                            <span class=" text-2xl  text-blue-400">Presensi Kelas</span>
                        </div>
                        <hr>

                        <div class=" grid grid-cols-4 px-4 py-2">
                            <div>Kelas / Semester</div>
                            <div> : {{ $dataKelas->nama_kelas }} / {{ $dataKelas->semester }}</div>
                            <div>Periode</div>
                            <div> : {{ $dataKelas->periode }} {{ $dataKelas->ket_semester }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form action="/presensikelas" method="post">
                            <button class=" bg-red-600 py-1 rounded-md text-white px-4">simpan presensi</button>
                            <a href="/presensikelas" class=" bg-red-600 py-1 rounded-md text-white px-4">Kembali</a>
                            @if (session('delete'))
                            <div class="py-2">
                                <div class="bg-red-500 px-2 py-1 text-white">
                                    {{ session('delete') }}
                                </div>
                            </div>
                            @endif
                            @if (session('success'))
                            <div class="py-2">
                                <div class="bg-green-500 px-2 py-1 text-white">
                                    {{ session('success') }}
                                </div>
                            </div>
                            @endif
                            @if (session('update'))
                            <div class="py-2">
                                <div class="bg-blue-500 px-2 py-1 text-white">
                                    {{ session('update') }}
                                </div>
                            </div>
                            @endif
                            @csrf
                            <meta http-equiv="refresh" content="5">
                            <table class=" mt-2 w-full">
                                <thead>
                                    <tr class="border">
                                        <th class=" border px-1">#</th>
                                        <th class=" border px-1 w-1/7 ">NIS</th>
                                        <th class=" border px-1 ">NAMA SISWA</th>
                                        <th class=" border px-1">KELAS</th>
                                        <th class=" border px-1">NAMA KELAS</th>
                                        <th class=" border px-1 ">IZIN</th>
                                        <th class=" border px-1">SAKIT</th>
                                        <th class=" border px-1">ALFA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataSiswa as $item)
                                    <tr class=" border hover:bg-gray-100">
                                        <td class=" px-2 border text-center w-10">
                                            {{ $loop->iteration }}
                                            <input type="hidden" name="pesertakelas[]" value="{{ $item->id }}">
                                            <input type="hidden" name="presensikelas_id[{{ $item->id }}]" value="{{ $item->presensikelas_id }}">
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{ $item->nis }}
                                        </td>
                                        <td class=" px-2 border text-sm ">
                                            {{ strtolower($item->nama_siswa) }}
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{ $item->kelas }}
                                        </td>
                                        <td class=" px-2 border text-center ">
                                            {{ $item->nama_kelas }}
                                        </td>
                                        <td class="  border text-center w-20">
                                            <input value="{{ $item->izin }}" class=" py-1 w-full text-center" type="number" name="izin[{{ $item->id }}]" default="0">
                                        </td>
                                        <td class="  border text-center w-20">
                                            <input value="{{ $item->sakit }}" class="py-1 w-full text-center" type="number" name="sakit[{{ $item->id }}]">
                                        </td>
                                        <td class="  border text-center w-20">
                                            <input value="{{ $item->alfa }}" class="py-1 w-full text-center" type="number" name="alfa[{{ $item->id }}]">
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
</x-app-layout>