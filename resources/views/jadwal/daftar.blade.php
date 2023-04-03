<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
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
                    <a href="/cetak-jadwal-1" class=" bg-red-600 px-2 py-1 text-white"> 1</a>
                    <a href="/cetak-jadwal-2" class=" bg-red-600 px-2 py-1 text-white"> 2</a>
                    <a href="/cetak-jadwal-3" class=" bg-red-600 px-2 py-1 text-white"> 3</a>
                    <a href="/cetak-jadwal-kolektif" class=" bg-red-600 px-2 py-1 text-white">Kolektif</a>
                    <a href="/laporan-poling-guru" class=" bg-red-600 px-2 py-1 text-white">Laporan</a>
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

        <table class=" w-full">
            <thead>
                <tr class=" bg-green-800 text-white">
                    <th class=" border text-center py-1">No</th>
                    <th class=" border text-center">Hari</th>
                    <th class=" border text-center">Periode</th>
                    <th class=" border text-center">Kelas</th>
                    <th class=" border text-center">Daftar Pendidik</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarJadwal as $jadwal)
                <tr class=" even:bg-gray-100">
                    <th class=" border text-center py-1">{{$loop->iteration}}</th>
                    <td class=" border text-center capitalize">{{$jadwal->hari}}</td>
                    <td class=" border text-center"> {{$jadwal->periode}} {{$jadwal->ket_semester}}</td>
                    <td class=" border text-center"><a href="/jadwal-guru/{{$jadwal->id}}" target="_blank"> {{$jadwal->nama_kelas}}</a> </td>
                    <td class=" border text-center w-1/2">
                        @if($jadwal->nama_guru !== null)
                        {{$jadwal->nama_guru}}
                        @else
                        <span class=" text-red-600">Belum terjadwal</span>
                        @endif

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
        <div>
            {{$daftarJadwal}}
        </div>
    </div>

</x-app-layout>