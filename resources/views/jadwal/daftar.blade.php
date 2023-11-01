<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="sm:text-xl font-semibold leading-tight text-sm">
                {{ __('Ploting Jadwal Guru') }}
            </h2>
        </div>
    </x-slot>
    <div class=" hidden">
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
    <div class=" px-4 py-2  ">
        <div class="  mt-2 bg-white grid sm:grid-cols-1 grid-cols-1 px-4 py-4 gap-2">
            @if (session('error'))
            <div class=" text-red-600 font-semibold">
                {{ session('error') }}
            </div>
            @endif
            <div class="  overflow-auto">
                <livewire:list-jadwal-guru></livewire:list-jadwal-guru>
            </div>
        </div>
    </div>
    <div class="  px-4 ">
        <div class=" bg-blue-200 p-4">
            <p class=" font-semibold">Keterangan : </p>
            <p class=" px-4">- Fitur ini di gunakan untuk menyimpan jadwal madrasah yang di buka, guru pengajar, serta kelas pengajar setiap periode
            </p>
            <p class=" px-4">- Sebelum memasukkan dosen mengajar , pastikan dosen tersebut sudah tercatat penugasannya pada tahun ajaran yang berlaku</p>

        </div>
    </div>

</x-app-layout>