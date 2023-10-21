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

                        <div class=" grid grid-cols-4">
                            @if($mapelGuru->count() != null)
                            @foreach($mapelGuru as $list)
                            <div>
                                <p class=" font-semibold"> {{$loop->iteration}} . {{$list->nama_kelas}} {{$list->mapel}} {{$list->periode}} {{$list->ket_semester}}</p>
                                <div class=" grid grid-cols-2">
                                    <div class=" px-5">
                                        Nilai Harian
                                    </div>
                                    <div>
                                        <div class=" ">
                                            <span class=" flex ml-5">
                                                : {{number_format($list->jumlah_nilai_harian/$list->jumlah_peserta_kelas * 100,0)}}% @if ($list->jumlah_nilai_harian == $list->jumlah_peserta_kelas )
                                                <span class=" font-semibold text-green-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                </span>
                                                @else
                                                <span class=" text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>

                                                    @endif
                                                    </p>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class=" grid grid-cols-2">
                                    <div class=" px-5">
                                        Nilai Ujian
                                    </div>
                                    <div>
                                        <div class=" ">
                                            <span class=" ml-5 flex">
                                                : {{number_format($list->jumlah_nilai_ujian/$list->jumlah_peserta_kelas * 100,0)}}%
                                                @if ($list->jumlah_nilai_ujian == $list->jumlah_peserta_kelas )
                                                <span class=" font-semibold text-green-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                                    </svg>
                                                </span>
                                                @else
                                                <span class=" text-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>

                                                </span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
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