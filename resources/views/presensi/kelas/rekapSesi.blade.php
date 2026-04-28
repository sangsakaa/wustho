<x-app-layout>
    <x-slot name="header">
        @section('title', '| Rekap Sesi')
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">

            <!-- Judul -->
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Presensi Sesi Per Kelas')}}
            </h2>

            <!-- Grup kanan -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">

                <!-- Form -->
                <form action="/sesikelas/rekap" method="get"
                    class="flex gap-2 items-center w-full sm:w-auto">

                    <input type="month" name="bulan"
                        class="border rounded px-2 py-1 dark:bg-dark-bg w-full sm:w-auto"
                        value="{{ $bulan->format('Y-m') }}">

                    <button
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded w-full sm:w-auto">
                        Pilih
                    </button>
                </form>

                <!-- Tombol Kembali -->
                <a href="/sesikelas"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-center w-full sm:w-auto">
                    Kembali
                </a>

            </div>
        </div>
    </x-slot>

    <!-- DASHBOARD -->
    <div class="p-2 grid grid-cols-1 sm:grid-cols-3 gap-2">
        <div class="bg-white dark:bg-dark-bg shadow rounded p-3">
            <p class="text-xs text-gray-500">Total Kelas</p>
            <h3 class="text-xl font-bold">
                {{ count($dataRekapSesi) }}
            </h3>
        </div>

        <div class="bg-white dark:bg-dark-bg shadow rounded p-3">
            <p class="text-xs text-gray-500">Total Hari</p>
            <h3 class="text-xl font-bold">
                {{ $periodeBulan->count() }}
            </h3>
        </div>

        <div class="bg-white dark:bg-dark-bg shadow rounded p-3">
            <p class="text-xs text-gray-500">Bulan</p>
            <h3 class="text-xl font-bold">
                {{ $bulan->isoFormat('MMMM YYYY') }}
            </h3>
        </div>
    </div>

    <!-- TABLE -->
    <div class="p-2">
        <div class="bg-white dark:bg-dark-bg shadow rounded overflow-hidden">

            <div class="overflow-auto">
                <table class="min-w-full border border-green-800 text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-green-200 dark:bg-purple-600 text-black">
                            <th class="border px-2 py-2 w-20" rowspan="2">Kelas</th>
                            <th class="border px-2 py-2 text-center"
                                colspan="{{ $periodeBulan->count() }}">
                                {{ $bulan->isoFormat('MMMM YYYY') }}
                            </th>
                        </tr>
                        <tr class="bg-green-200 dark:bg-purple-600 text-black">
                            @foreach ($periodeBulan as $hari)
                            <th class="border px-1 py-1 text-center
                                    {{ $hari->isThursday() ? 'bg-green-300 font-bold' : '' }}">
                                {{ $hari->day }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($dataRekapSesi as $rekapSesi)
                        <tr class="even:bg-green-100 hover:bg-gray-100">
                            <th class="border text-center px-2 py-1">
                                {{ $rekapSesi['kelasmi']->nama_kelas }}
                            </th>

                            @foreach ($rekapSesi['sesiPerBulan'] as $sesi)
                            <td class="border text-center
                                        {{ $sesi['hari']->isThursday() ? 'bg-green-800 text-white' : '' }}">
                                @if ($sesi['data'])
                                <a target="_blank" href="/absensikelas/{{ $sesi['data']->id }}">
                                    @if ($sesi['data']->absensi->count())
                                    <x-icons.check class="w-4 h-4 text-green-700 mx-auto" />
                                    @else
                                    <x-icons.x-mark class="w-4 h-4 text-red-600 mx-auto" />
                                    @endif
                                </a>
                                @endif
                            </td>
                            @endforeach

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>