<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="sm:text-xl font-semibold leading-tight text-sm">
                {{ __('Dashboard Ploting Jadwal Guru') }}
            </h2>

        </div>
    </x-slot>
    <div>
        <form action="/Daftar-Jadwal" method="post">
            <div class=" bg-white grid sm:grid-cols-4 grid-cols-1 px-2 py-2 gap-2">
                @csrf
                <label for="hari">Pilih Hari</label>
                <select id="hari" name="hari" class=" py-1">
                    <option value="jumat">Jumat</option>
                    <option value="sabtu">Sabtu</option>
                    <option value="minggu">Minggu</option>
                    <option value="senin">Senin</option>
                    <option value="selasa">Selasa</option>
                    <option value="rabu">Rabu</option>
                </select>
                <label for="hari">Pilih Periode </label>
                <select id="hari" name="periode_id" class=" py-1">
                    @foreach($daftarPeriode as $periode)
                    <option value="{{$periode->id}}">{{$periode->periode}} {{$periode->ket_semester}}</option>
                    @endforeach
                </select>
                <label for="hari">Pilih Kelas </label>
                <select id="hari" name="kelasmi_id" class=" py-1">
                    @foreach($daftarKelas as $kelas)
                    <option value="{{$kelas->id}}">{{$kelas->nama_kelas}} {{$kelas->periode}} {{$kelas->ket_semester}}</option>
                    @endforeach
                </select>
                <div class=" w-full   flex   grid-cols-6   gap-2">
                    <button class=" bg-red-600 px-2 py-1 text-white">Simpan</button>
                </div>
            </div>
        </form>
    </div>
    <div class=" mt-2 bg-white grid sm:grid-cols-1 grid-cols-1 px-2 py-2 gap-2">
        @if (session('error'))
        <div class=" text-red-600 font-semibold">
            {{ session('error') }}
        </div>
        @endif
        <div class="  grid-cols-2 grid  sm:grid sm:grid-cols-6 gap-2">
            <a href="/cetak-jadwal-1" class=" py-1 px-2 bg-red-600 text-white text-center "> KELAS 1</a>
            <a href="/cetak-jadwal-2" class=" py-1 px-2 bg-red-600 text-white text-center "> KELAS 2</a>
            <a href="/cetak-jadwal-3" class=" py-1 px-2 bg-red-600 text-white text-center "> KELAS 3</a>
            <a href="/laporan-poling-guru" class=" py-1 px-2 bg-red-600 text-white text-center ">LAPORAN</a>
            <a href="/laporan-poling-guru-kelas" class=" py-1 px-2 bg-red-600 text-white text-center ">Laporan Ploting</a>
            <a href="/cetak-jadwal-kolektif" class=" py-1 px-2 bg-red-600 text-white text-center ">Buat Jadwal</a>
        </div>
        <div class=" rounded-md overflow-auto">
            <table class=" w-full w-100">
                <thead class=" fixed-top">
                    <tr class=" bg-green-800 text-white">
                        <th class=" border text-center text-xs sm:text-sm py-1">No</th>
                        <th class=" border text-center text-xs sm:text-sm">Hari</th>
                        <th class=" border text-center text-xs sm:text-sm">Periode</th>
                        <th class=" border text-center text-xs sm:text-sm">Kelas</th>
                        <th class=" border text-center text-xs sm:text-sm">Mapel</th>
                        <th class=" border text-center text-xs sm:text-sm">Daftar Pendidik</th>
                        <th class=" border text-center text-xs sm:text-sm">ACt</th>
                    </tr>
                </thead>
                <tbody class=" overflow-auto">
                    @foreach($daftarJadwal as $jadwal)
                    <tr class=" even:bg-gray-100">
                        <th class=" px-1  border text-xs sm:text-sm text-center py-2">{{$loop->iteration}}</th>
                        <td class=" px-1 border text-xs sm:text-sm text-center capitalize">{{$jadwal->hari}}</td>
                        <td class=" px-1 border text-xs sm:text-sm text-center"> {{$jadwal->periode}} {{$jadwal->ket_semester}}</td>
                        <td class=" px-1 border text-xs sm:text-sm text-center"><a href="/jadwal-guru/{{$jadwal->id}}"> {{$jadwal->nama_kelas}}</a> </td>
                        <td class=" px-1 border text-xs sm:text-sm text-center capitalize">{{$jadwal->mapel}}</td>
                        <td class=" px-1 border text-xs sm:text-sm text-left w-1/2">
                            @if($jadwal->nama_guru !== null)
                            @if($jadwal->jenis_kelamin == 'L')
                            Bapak
                            @else
                            Ibu
                            @endif
                            {{$jadwal->nama_guru}}
                            @else
                            <span class=" text-red-600">Belum terjadwal</span>
                            @endif
                        </td>
                        <td class=" text-center">
                            <form action="/Daftar-Jadwal/{{$jadwal->id}}" method="post">
                                @csrf
                                @method('delete')
                                <button title="hapus jadwal">
                                    <span class=" text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div>
            {{$daftarJadwal}}
        </div>
    </div>

</x-app-layout>