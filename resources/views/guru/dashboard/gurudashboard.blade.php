<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data ' )
        <h2 class="font-semibold    leading-tight">
            <span class=" uppercase">{{ __('Dashboard Guru ') }} </span><br>
        </h2>
    </x-slot>
    <div class="p-2">
        <div class=" dark:bg-dark-bg bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 grid grid-cols-4 ">
                <div>NIG</div>
                <div>
                    : {{$title->nig}}
                </div>
                <div>Jenjang</div>
                <div>
                    : {{$title->jenjang}}
                </div>
                <div>Nama</div>
                <div>
                    : {{$title->nama_guru}}
                </div>

            </div>
        </div>
        <div class=" mt-2 dark:bg-dark-bg bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 ">
                <div class="  ">
                    <div>
                        <p class=" font-semibold">Mata Pelajaran & Progress :</p>

                        @if($mapelGuru->count() != null)
                        @foreach($mapelGuru as $list)
                        <div class=" grid grid-cols-2">
                            <div>
                                <p> {{$loop->iteration}} . {{$list->nama_kelas}} {{$list->mapel}} {{$list->periode}} {{$list->ket_semester}}</p>
                                <p class=" ml-4">

                                    Nilai Harian : {{number_format($list->jumlah_nilai_harian/$list->jumlah_peserta_kelas * 100,0)}}% @if ($list->jumlah_nilai_harian == $list->jumlah_peserta_kelas )
                                    <span>tuntas</span>
                                    @else
                                    Belum tuntas
                                    @endif
                                </p>
                                <p class=" ml-4">
                                    Nilai Ujian : {{number_format($list->jumlah_nilai_ujian/$list->jumlah_peserta_kelas * 100,0)}}%
                                    @if ($list->jumlah_nilai_ujian == $list->jumlah_peserta_kelas )
                                    <span>tuntas</span>
                                    @else
                                    Belum tuntas
                                    @endif
                                </p>
                            </div>
                            @endforeach
                            @else
                            <div>
                                <span class=" text-red-600">Tidak ada Proses Penilain dan Pembelajaran</span>
                            </div>
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" p-2">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4">

            </div>
        </div>
    </div>
    <div class="py-2 px-2">
        <div class=" overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 bg-sky-300 dark:bg-purple-600  text-white">
                <p class=" uppercase bold">keterangan : </p>
                <p class=" capitalize px-2">1.MP : mata pelajaran</p>
                <p class=" capitalize px-2">2.IPK: index predikat komulatif</p>
            </div>
        </div>
    </div>
</x-app-layout>