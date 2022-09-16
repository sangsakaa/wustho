<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Nilai Mata Pelajaran' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nilai Mata Pelajaran') }}
        </h2>
    </x-slot>
    <div class=" px-4">
        <div class="mt-2">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-white border-b border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1 gap-2">
                        <span class=" text-blue-500">Form Tambah Nilai</span>

                        <form action="/nilaimapel" method="post" class=" py-1 px-2 w-full">
                            @csrf

                            <select name="mapel_id" id="" class=" w-full sm:w-1/5 py-1">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach($dataMapel as $mapel)
                                <option value="{{$mapel->id}}">{{$mapel->kelas}} - {{$mapel->mapel}} - {{$mapel->nama_kitab}}</option>
                                @endforeach
                            </select>
                            <select name="guru_id" id="" class=" w-full sm:w-1/5 py-1">
                                <option value="">-- Pilih Pendidik --</option>
                                @foreach($dataGuru as $guru)
                                <option value="{{$guru->id}}">{{$guru->nama_guru}}</option>
                                @endforeach
                            </select>

                            <select name="kelasmi_id" id="" class=" w-full sm:w-1/5 py-1">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($dataKelas as $kelas)
                                <option value="{{$kelas->id}}">{{$kelas->nama_kelas}} {{$kelas->periode}} {{$kelas->ket_semester}}</option>
                                @endforeach
                            </select>
                            <button class=" bg-red-600 py-1 rounded-md text-white px-4 ">simpan kelas</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="py-1">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-white border-b border-gray-200">
                        <div class=" grid grid-cols-2  py-1">
                            <div class=" grid text-blue-400 text-2xl">
                                Daftar Nilai Mata Pelajaran
                            </div>
                            <div class=" flex justify-end">
                                <form action="/nilaimapel" method="get" class=" flex gap-1">
                                    <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 " placeholder=" Cari ..">

                                    <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                        Cari </button>

                                </form>
                            </div>
                        </div>

                        <table class=" w-full">
                            <thead>
                                <tr class="border bg-gray-200">
                                    <th class=" border px-1  py-1">#</th>
                                    <th class=" border px-1">Periode</th>
                                    <th class=" border px-1">Semester</th>
                                    <th class=" border px-1">Nama Guru</th>
                                    <th class=" border px-1">Kelas</th>
                                    <th class=" border px-1">Nama Kelas</th>
                                    <th class=" border px-1 capitalize">Mata pelajaran</th>
                                    <th class=" border px-1 capitalize">peserta</th>
                                    <th class=" border px-1">HARIAN</th>
                                    <th class=" border px-1">UJIAN</th>
                                    <th class=" border px-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count())
                                @foreach ($data as $nilai)
                                <tr class=" border hover:bg-gray-100 ">
                                    <th class=" border px-1">{{$loop->iteration}}</th>
                                    <th class=" border text-center px-1">{{$nilai->periode}} {{$nilai->ket_semester}} </td>
                                    <th class=" border text-center px-1">{{$nilai->semester}} </td>

                                    <th class=" border text-left px-1"><a href="/nilai/{{$nilai->id}}">{{$nilai->nama_guru}}</a> </td>
                                    <th class=" border text-center px-1"><a href="/nilai/{{$nilai->id}}">{{$nilai->kelas}}</a> </td>
                                    <th class=" border text-center px-1"><a href="/nilai/{{$nilai->id}}">{{$nilai->nama_kelas}}</a> </td>
                                    <th class=" border text-center px-1">{{$nilai->mapel}} </td>
                                    <th class=" border text-center px-1">{{$nilai->jumlah_peserta_kelas}} </td>
                                    <th class=" border text-center px-1">{{$nilai->jumlah_nilai_harian}} </td>
                                    <th class=" border text-center px-1">{{$nilai->jumlah_nilai_ujian}} </td>
                                    <td class=" grid justify-items-center">
                                        <form action="/nilaimapel/{{$nilai->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class=" bg-red-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="  border">
                                    <td colspan="11" class=" text-sm border text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                                @endif
                                <tr class=" border">
                                    <td colspan="11">
                                        {{$data}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-blue-200 border-b border-gray-200 ">
                        <p class=" font-semibold">Keterangan : </p>
                        <p class=" px-2">1. Nilai diambail dari <b class=" underline">Ulangan Harian dan Ujian Akhir Semester</b></p>
                        <p class=" px-2 capitalize">2. Untuk pengisian nilai jika tidak ada harap kosongkan form penilaian</p>
                        <p class=" px-2 capitalize">3. Untuk pengisinan nilai <b><u>harus</u></b> memasukan peserta kelas terlebih dahulu di menu kelas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>