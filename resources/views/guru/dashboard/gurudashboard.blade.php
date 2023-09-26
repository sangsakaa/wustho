<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data ' )
        <h2 class="font-semibold    leading-tight">
            <span class=" uppercase">{{ __('Dashboard Guru ') }} </span><br>
        </h2>
    </x-slot>
    <div class="p-2">
        <div class=" dark:bg-dark-bg bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 grid grid-cols-2 ">

                <div>Nama</div>
                <div>
                    : {{$title->nig}}
                </div>
                <div>Nama</div>
                <div>
                    : {{$title->nama_guru}}
                </div>
                <div>Jenjang</div>
                <div>
                    : {{$title->jenjang}}
                </div>

            </div>
        </div>
        <div class=" mt-2 dark:bg-dark-bg bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-4 ">
                <div class=" ">
                    <p class=" font-semibold">Mata Pelajaran :</p>
                    <p>
                        @foreach($mapelGuru as $list)
                        {{$loop->iteration}} . {{$list->mapel}}
                        @endforeach
                    </p>
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