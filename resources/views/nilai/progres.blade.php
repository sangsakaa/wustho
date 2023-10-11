<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Progress' )
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Progress') }}
        </h2>
    </x-slot>
    <div class="">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg  shadow-sm ">
                <div class=" px-2  border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1  sm:gap-1">

                </div>
            </div>
        </div>
    </div>
    <div class="py-1">
        <div class="">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="sm:p-4 p-1 ">
                    <div class=" grid grid-cols-1 sm:grid-cols-2">
                        <div>
                            <a href="/nilaimapel" class=" mt-2 bg-red-600 px-2 py-1 text-white">Nilai Mapel</a>
                            <a href="/juara-pararel" class=" mt-2 bg-red-600 px-2 py-1 text-white"> Kelas 3</a>
                        </div>
                        <div class=" flex grid-cols-1 justify-end">
                            <form action="/nilaimapel" method="get" class=" flex gap-1">
                                <input type="text" name="cari" value="{{ request('cari') }}" class=" border border-green-800 text-green-800 rounded-md py-1 dark:bg-dark-bg " placeholder=" Cari ..">
                                <button type="submit" class=" px-2   bg-blue-500  rounded-md text-white">
                                    Cari </button>
                            </form>
                        </div>
                    </div>
                    <div class=" overflow-auto bg-white dark:bg-dark-bg mt-1 mb-0 ">


                        @foreach ($data->groupBy('kelas') as $kelas => $kelasData)
                        @php
                        $totalPesertaKelas = $kelasData->sum('jumlah_peserta_kelas');
                        $totalNilaiHarian = $kelasData->sum('jumlah_nilai_harian');
                        $totalNilaiUjian = $kelasData->sum('jumlah_nilai_ujian');
                        $presentaseNilaiHarian = ($totalNilaiHarian / $totalPesertaKelas) * 100;
                        $presentaseNilaiUjian = ($totalNilaiUjian / $totalPesertaKelas) * 100;
                        @endphp

                        <p>Kelas: {{ $kelas }}</p>
                        <p>Jumlah Peserta Kelas: {{ $totalPesertaKelas }}</p>

                        <div class="w-full bg-gray-200 rounded-full">
                            <div class=" h-8 py-1  text-center text-white bg-blue-500 rounded-full" style="width: {{ $presentaseNilaiHarian }}%">{{ number_format($presentaseNilaiHarian,0) }}%</div>
                        </div>
                        <p>Presentase Nilai Harian: {{ number_format($presentaseNilaiHarian,0) }}%</p>

                        <div class="w-full bg-gray-200 rounded-full">
                            <div class=" h-8 py-1  text-center  bg-green-500 rounded-full" style="width: {{ $presentaseNilaiUjian }}%">
                                <span class=" py-1">
                                    {{ number_format($presentaseNilaiUjian ,0)}}%
                                </span>
                            </div>
                        </div>
                        <p>Presentase Nilai Ujian: {{ number_format($presentaseNilaiUjian ,0) }}%</p>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>


</x-app-layout>