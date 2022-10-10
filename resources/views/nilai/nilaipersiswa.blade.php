<x-app-layout>
    <x-slot name="header">
        @section('title', ' | KHT')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kartu Hasil Tadris') }}
        </h2>
    </x-slot>
    <div class=" px-2">
        <div class="mt-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" grid grid-cols-1 sm:grid-cols-2  py-1">
                        <div class=" flex sm:grid-cols-1 justify-start">
                            <form action="/nilai" method="get" class="flex gap-1">
                                <select name="kelasmi" id="" class=" border border-green-800 text-green-800 rounded-md py-1" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasmiSiswa as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $kelasmiTerpilih->id == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                    Pilih
                                </button>
                            </form>

                        </div>

                    </div>
                    <div class="sm:text-2xl text-center text-2xl sm:text-left  grid text-blue-400 ">
                        Daftar Nilai Mata Pelajaran
                    </div>
                    <div class=" overflow-auto bg-white rounded-md ">
                        <div class=" text-center  text-2xl capitalize py-2">
                            <span> kartu hasil tadris</span>
                        </div>
                        <div class=" text-xs sm:text-sm grid grid-cols-2 sm:grid-cols-4 gap-1">
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
                        <table class=" text-xs sm:text-sm w-full">
                            <thead>
                                <tr class="border bg-gray-200">
                                    <th class=" border px-1  py-1">#</th>
                                    <th class=" border px-1">Pelajaran</th>

                                    <th class=" border px-1">Nama Guru</th>
                                    <th class=" border px-1">NH</th>
                                    <th class=" border px-1">NU</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($dataNilai->count())
                                @foreach ($dataNilai as $nilai)
                                <tr class="border hover:bg-gray-100 ">
                                    <td class=" border text-center px-1">{{ $loop->iteration }}</td>
                                    <td class=" border text-center px-1 py-2">{{ $nilai->mapel }}</td>

                                    <td class=" border text-left px-1">{{ $nilai->nama_guru }}</td>
                                    <td class=" border text-center px-1">{{ $nilai->nilai_harian }}</td>
                                    <td class=" border text-center px-1">{{ $nilai->nilai_ujian }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="border">
                                    <td colspan="11" class="text-sm border text-center py-4">
                                        Tidak ada data
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>