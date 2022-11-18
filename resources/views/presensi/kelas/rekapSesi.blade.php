<x-app-layout>
    <x-slot name="header">
        @section('title', '| Rekap Sesi')
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Presensi Kelas')}}
        </h2>
    </x-slot>
    <div class="my-1">
        <div class="">
            <div class=" bg-white dark:bg-dark-bg overflow-hidden shadow-sm ">
                <div class="mx-2 px-2 border-gray-200 grid grid-cols-1 w-full sm:grid-cols-1  gap-2">
                    <form action="/sesikelas/rekap" method="get" class="w-full">
                        <input type="month" name="bulan" class=" py-1 dark:bg-dark-bg" value="{{ $bulan->format('Y-m') }}">
                        <button class=" bg-red-600 py-1 dark:bg-purple-600 mt-1 my-1 w-full sm:w-40 rounded-sm hover:bg-purple-600 text-white px-4 ">
                            Pilih Bulan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="py-1">
        <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm " id="blanko">
            <div class=" p-1 ">
                <div class=" overflow-auto bg-white dark:bg-dark-bg">
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="border bg-green-500 dark:bg-purple-600 text-xs sm:text-sm">
                                <th class="border px-1 w-14" rowspan="2">Kelas</th>
                                <th class="border px-1 text-black uppercase " colspan="{{ $periodeBulan->count() }}">
                                    {{$bulan->isoFormat('MMMM YYYY')}}
                                </th>
                            </tr>
                            <tr class="border border-black bg-green-500 dark:bg-purple-600 text-xs sm:text-sm">
                                @foreach ($periodeBulan as $hari)
                                <th class="border {{ $hari->isThursday() ? " bg-green-500 text-black"
                                    : "" }}">{{ $hari->day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class=" text-sm">
                            @foreach ($dataRekapSesi as $rekapSesi)
                            <tr class=" border text-xs sm:text-sm even:bg-green-100">
                                <th class="border text-center ">{{ $rekapSesi['kelasmi']->nama_kelas }}</th>
                                @foreach ($rekapSesi['sesiPerBulan'] as $sesi)
                                <td class="border {{ $sesi['hari']->isThursday() ? " bg-green-500" : "" }}">
                                    <div class="grid justify-items-center">
                                        @if (!$sesi['data'])
                                        @elseif ($sesi['data']->absensi->count())
                                        <a href="/absensikelas/{{ $sesi['data']->id }}">
                                            <x-icons.check class="w-4 h-4 text-green-600" aria-hidden="true" />
                                        </a>
                                        @else
                                        <a href="/absensikelas/{{ $sesi['data']->id }}">
                                            <x-icons.x-mark class="w-4 h-4 text-red-600" aria-hidden="true" />
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>