<x-app-layout>
    <x-slot name="header">
        @section('title', '| Rekap Sesi')
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Presensi Sesi PerKelas')}}
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
                <div class="  overflow-scroll bg-white dark:bg-dark-bg">
                    <table class="table-fixed w-full border border-green-800">
                        <thead>
                            <tr class="border bg-green-200  text-black dark:bg-purple-600 text-xs sm:text-sm">
                                <th class="border border-green-800 px-1 w-14" rowspan="2">Kelas</th>
                                <th class="border border-green-800 px-1  uppercase  text-black " colspan="{{ $periodeBulan->count() }}">
                                    {{$bulan->isoFormat('MMMM YYYY')}}
                                </th>
                            </tr>
                            <tr class="border border-green-800 bg-green-200  text-black dark:bg-purple-600 text-xs sm:text-sm">
                                @foreach ($periodeBulan as $hari)
                                <th class="border border-green-800 {{ $hari->isThursday() ? " border-green-800 bg-green-200 text-black "
                                    : "" }}">{{ $hari->day }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class=" text-sm border border-green-800">
                            @foreach ($dataRekapSesi as $rekapSesi)
                            <tr class=" border border-green-800 text-xs sm:text-sm even:bg-green-100 hover:bg-gray-200">
                                <th class="border border-green-800 text-center ">{{ $rekapSesi['kelasmi']->nama_kelas }}</th>
                                @foreach ($rekapSesi['sesiPerBulan'] as $sesi)
                                <td class="border border-green-800 {{ $sesi['hari']->isThursday() ? " bg-green-800 text-white" : "" }}">
                                    <div class="grid justify-items-center">
                                        @if (!$sesi['data'])
                                        @elseif ($sesi['data']->absensi->count())
                                        <a target="_blank" href="/absensikelas/{{ $sesi['data']->id }}">
                                            <x-icons.check class=" font-semibold uppercase w-4 h-4 text-green-800" aria-hidden="true" />
                                        </a>
                                        @else
                                        <a target="_blank" href="/absensikelas/{{ $sesi['data']->id }}">
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