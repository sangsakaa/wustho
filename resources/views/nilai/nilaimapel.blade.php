<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Nilai Mata Pelajaran' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Nilai Mata Pelajaran') }}
        </h2>
    </x-slot>
    <div class="">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg  shadow-sm ">
                <div class=" px-2  border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1  sm:gap-1">
                    <span class=" text-blue-500 mt-2">Form Tambah Nilai</span>
                    <form action="/nilaimapel" method="post" class="   w-full">
                        @csrf
                        <select name="mapel_id" id="" class=" my-1 w-full sm:w-1/5 py-1  dark:bg-dark-bg" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($dataMapel as $mapel)
                            <option value="{{$mapel->id}}">{{$mapel->kelas}} - {{$mapel->mapel}} - {{$mapel->nama_kitab}}</option>
                            @endforeach
                        </select>
                        <select name="guru_id" id="" class=" my-1 w-full sm:w-1/5 py-1 dark:bg-dark-bg" required>
                            <option value="">-- Pilih Pendidik --</option>
                            @foreach($dataGuru as $guru)
                            <option value="{{$guru->id}}">{{$guru->nama_guru}}</option>
                            @endforeach
                        </select>
                        <select name="kelasmi_id" id="" class=" my-1 w-full sm:w-1/5 py-1 dark:bg-dark-bg" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($dataKelas as $kelas)
                            <option value="{{$kelas->id}}">{{$kelas->nama_kelas}} {{$kelas->periode}} {{$kelas->ket_semester}}</option>
                            @endforeach
                        </select>
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">simpan kelas</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="py-1">
        <div class="">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="sm:p-4 p-1 ">
                    <div class=" grid grid-cols-1 sm:grid-cols-1">
                        <div class=" flex grid-cols-1 justify-end">
                            <form action="/nilaimapel" method="get" class=" flex gap-1">
                                <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 dark:bg-dark-bg " placeholder=" Cari ..">
                                <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                    Cari </button>
                            </form>
                        </div>
                    </div>
                    <div class=" overflow-auto bg-white dark:bg-dark-bg mt-1 mb-0 ">
                        <table class=" w-full">
                            <thead>
                                <tr class="border uppercase bg-gray-200 dark:bg-purple-600 text-xs sm:text-sm">
                                    <th class=" border px-1  py-1">No</th>
                                    <th class=" border px-1">Periode</th>
                                    <th class=" border px-1 w-5">Smt</th>
                                    <th class=" border px-1 w-10 sm:w-10">Nilai</th>
                                    <th class=" border px-1">Guru</th>
                                    <th class=" border px-1 w-5">KLS</th>
                                    <th class=" border px-1 capitalize">MP</th>
                                    <th class=" border px-1 capitalize">Qty</th>
                                    <th class=" border px-1">NH</th>
                                    <th class=" border px-1">NU</th>
                                    <th class=" border px-1 w-5">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->count())
                                @foreach ($data as $nilai)
                                <tr class=" border hover:bg-gray-100  dark:hover:bg-purple-600 text-xs sm:text-sm ">
                                    <th class=" border px-1">{{$loop->iteration}}</th>
                                    <th class=" border text-center px-1 sm:text-sm text-xs">{{$nilai->periode}} {{$nilai->ket_semester}} </td>
                                    <th class=" border text-center px-1">{{$nilai->semester}} </td>
                                    <th class=" border text-center px-1 py-2">
                                        <a href="/nilai/{{$nilai->id}}" class=" text-white bg-blue-600 hover:bg-purple-700  sm:px-4 px-1 py-1 rounded-md">
                                            Nilai
                                        </a>
                                    </th>
                                    <th class=" border text-left px-1">
                                        <a href="/nilai/{{$nilai->id}}">
                                            {{$nilai->nama_guru}}
                                        </a>
                                    </th>

                                    <th class=" border text-center px-1"><a href="/nilai/{{$nilai->id}}">{{$nilai->nama_kelas}}</a> </td>
                                    <th class=" border text-center px-1">{{$nilai->mapel}} </td>
                                    <th class=" border text-center px-1">{{$nilai->jumlah_peserta_kelas}} </td>
                                    <th class=" border text-center px-1">{{$nilai->jumlah_nilai_harian}} </td>
                                    <th class=" border text-center px-1">{{$nilai->jumlah_nilai_ujian}} </td>
                                    <td class=" grid justify-items-center py-1 ">
                                        <form action="/nilaimapel/{{$nilai->id}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class=" bg-red-500 text-white p-1 rounded-md" onclick=" return confirm ('apakah anda yakin menghapus data ini : {{$nilai->mapel}}')"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="  border">
                                    <td colspan="11" class=" text-md text-red-600  border text-center">
                                        Tidak ada data yang ditemukan
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class=" bg-white  px-4">
                {{$data}}
            </div>
        </div>
    </div>
    <div class="my-1">
        <div class="">
            <div class=" bg-sky-200 dark:bg-dark-bg overflow-hidden shadow-sm">
                <div class="p-6  ">
                    <p class=" font-semibold">Keterangan : </p>
                    <p class=" px-2">1. Nilai diambail dari <b class=" underline">Ulangan Harian dan Ujian Akhir Semester</b></p>
                    <p class=" px-2 capitalize">2. Untuk pengisian nilai jika tidak ada harap kosongkan form penilaian</p>
                    <p class=" px-2 capitalize">3. Untuk pengisinan nilai <b><u>harus</u></b> memasukan peserta kelas terlebih dahulu di menu kelas</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>