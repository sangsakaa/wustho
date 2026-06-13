<x-app-layout>
    <x-slot name="header">
        @section('title', '| REKAP HARIAN : '. $tgl->isoFormat('dddd, D MMMM YYYY'))

        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
            Rekap Absensi Kelas : {{ ($tgl->isoFormat('dddd, D MMMM YYYY')) }}
        </h2>
    </x-slot>

    {{-- LOADING OVERLAY --}}
    <div id="loading-overlay" class="hidden">
        <div class="text-center">

            <div class="flex justify-center gap-2">
                <div class="w-5 h-5 bg-white rounded-full animate-bounce"></div>
                <div class="w-5 h-5 bg-white rounded-full animate-bounce [animation-delay:0.2s]"></div>
                <div class="w-5 h-5 bg-white rounded-full animate-bounce [animation-delay:0.4s]"></div>
            </div>

            <p class="text-white mt-5 text-lg font-semibold tracking-wide">
                Sedang memproses rekap absensi...
            </p>

            <div class="w-72 bg-gray-300 rounded-full h-4 mt-5 overflow-hidden">
                <div
                    class="bg-red-600 h-4 rounded-full animate-pulse progress-bar">
                </div>
            </div>

        </div>
    </div>

    {{-- FILTER --}}
    <div class="my-3">
        <div class="bg-white dark:bg-dark-bg rounded-xl shadow border border-gray-200 dark:border-gray-700">

            <div class="px-4 py-3 grid grid-cols-1 lg:grid-cols-2 gap-3 items-center">

                <div>

                    <form
                        id="filterForm"
                        action="/absensikelas/rekap-per-hari"
                        method="get"
                        class="flex flex-col sm:flex-row gap-2 items-start sm:items-center w-full">

                        <input
                            type="date"
                            name="tgl"
                            value="{{ $tgl->toDateString() }}"
                            class="rounded-lg border-gray-300 dark:border-gray-600 py-2 dark:bg-dark-bg dark:text-white focus:ring-purple-500 focus:border-purple-500">

                        <button
                            type="submit"
                            class="bg-red-600 hover:bg-purple-600 transition duration-200 text-white px-5 py-2 rounded-lg shadow text-sm font-medium">
                            Pilih
                        </button>

                    </form>

                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-2">

                    <button
                        onclick="printContent('blanko')"
                        class="bg-red-600 hover:bg-purple-600 transition duration-200 text-white px-5 py-2 rounded-lg shadow text-sm font-medium">
                        Cetak
                    </button>

                    <a
                        href="/generate-pdf/{{$tgl->toDateString()}}"
                        target="_blank"
                        onclick="showLoading()"
                        class="bg-red-600 hover:bg-purple-600 transition duration-200 text-white px-5 py-2 rounded-lg shadow text-sm font-medium text-center">

                        Download PDF

                    </a>

                </div>

            </div>

        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }

        function showLoading() {
            document.getElementById('loading-overlay')
                .classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('filterForm');

            form.addEventListener('submit', function() {
                showLoading();
            });

        });
    </script>

    {{-- STYLE --}}
    <style>
        table {
            border-collapse: collapse;
        }

        @media print {
            body {
                background: white;
            }
        }

        #loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 99999;

            display: flex;
            align-items: center;
            justify-content: center;

            backdrop-filter: blur(3px);
        }

        .progress-bar {
            width: 100%;
            animation: progressAnimation 1.5s infinite linear;
        }

        @keyframes progressAnimation {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>

    @if($rekapAbsensi)

    <div class="py-2">

        <div
            class="bg-white dark:bg-dark-bg rounded-xl shadow border border-gray-200 dark:border-gray-700"
            id="blanko">

            <div class="p-3">

                <div class="overflow-x-auto bg-white dark:bg-dark-bg">

                    {{-- KOP --}}
                    <div class="flex items-center gap-3 text-center text-green-900 tracking-wide">

                        <div>
                            <img
                                src="{{ asset('asset/images/logo.png') }}"
                                alt="logo"
                                width="95"
                                class="mb-1">
                        </div>

                        <div class="w-full">

                            <p class="text-lg uppercase font-semibold tracking-widest">
                                departemen pendidikan diniyah wahidiyah
                            </p>

                            <p class="font-bold text-3xl uppercase">
                                MADRASAH DINIYAH {{$dataKelasMi->jenjang}} WAHIDIYAH
                            </p>

                            <p class="font-semibold uppercase tracking-widest text-sm">
                                TAHUN PELAJARAN {{$dataKelasMi->periode}} {{$dataKelasMi->ket_semester}}
                            </p>

                        </div>

                    </div>

                    <hr class="border-b-2 border-green-900 mt-2">
                    <hr class="mt-0.5 border-b border-green-900">

                    {{-- JUDUL --}}
                    <div class="text-center py-2">

                        <p class="text-2xl uppercase font-bold text-green-900 tracking-wide">
                            Laporan Harian
                        </p>

                        <p class="text-sm font-semibold text-green-900 mt-1">
                            Hari, Tanggal :
                            {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
                        </p>

                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto rounded-lg border border-green-700 mt-2">

                        <table class="table-fixed w-full text-green-900">

                            <thead class="border border-b-2 border-green-600">

                                <tr class="border border-green-600 text-xs sm:text-sm bg-green-50 dark:bg-gray-800">

                                    <th class="border border-green-600 px-1 w-8">No</th>
                                    <th class="border border-green-600 px-1 w-1/6">Asrama</th>
                                    <th class="border border-green-600 px-1 w-10">Kls</th>
                                    <th class="border border-green-600 px-1 w-11">Total</th>
                                    <th class="border border-green-600 px-1 w-11">Tidak Hadir</th>
                                    <th class="border border-green-600 px-1 w-11">Hadir</th>
                                    <th class="border border-green-600 px-1 w-1/3 sm:w-1/2">Yang Tidak Hadir</th>
                                    <th class="border border-green-600 px-1 w-10 sm:w-11">Ket</th>
                                    <th class="border border-green-600 px-1 w-1/6">Presentase Kehadiran</th>

                                </tr>

                            </thead>

                            <tbody class="text-sm">

                                @php
                                $nomor = 1;
                                @endphp

                                @foreach ($rekapAbsensi as $nama_asrama => $dataAsrama)
                                @foreach ($dataAsrama as $nama_kelas => $dataKelas)
                                @foreach ($dataKelas['absensi'] as $absensi )

                                <tr class="border border-green-600 text-xs sm:text-sm even:bg-green-50 dark:even:bg-gray-800">

                                    @if ($loop->first)
                                    <td
                                        class="border border-green-600 text-center px-1"
                                        rowspan="{{ $dataKelas['row'] }}">
                                        {{ $nomor++ }}
                                    </td>
                                    @endif

                                    @if ($loop->parent->first && $loop->first)
                                    <td
                                        class="border border-green-600 px-1 text-center text-sm"
                                        rowspan="{{ $dataAsrama->sum('row') }}">
                                        {{ $nama_asrama }}
                                    </td>
                                    @endif

                                    @if ($loop->first)

                                    <td class="border border-green-600 text-center px-1"
                                        rowspan="{{ $dataKelas['row'] }}">
                                        {{ $nama_kelas }}
                                    </td>

                                    <td class="border border-green-600 text-center px-1"
                                        rowspan="{{ $dataKelas['row'] }}">
                                        {{ $dataKelas['total'] }}
                                    </td>

                                    <td class="border border-green-600 text-center px-1"
                                        rowspan="{{ $dataKelas['row'] }}">
                                        {{ $dataKelas['tidakHadir'] }}
                                    </td>

                                    <td class="border border-green-600 text-center px-1"
                                        rowspan="{{ $dataKelas['row'] }}">
                                        {{ $dataKelas['hadir'] }}
                                    </td>

                                    @endif

                                    <td class="border border-green-600 px-2 text-xs capitalize">

                                        {{ $dataKelas['tidakHadir'] !== 0
                                            ? $loop->iteration . '. ' . strtolower($absensi->nama_siswa)
                                            : 'NIHIL'
                                        }}

                                    </td>

                                    <td class="border border-green-600 px-1 text-center capitalize">

                                        {{ $dataKelas['tidakHadir'] !== 0
                                            ? $absensi->keterangan
                                            : 'NIHIL'
                                        }}

                                    </td>

                                    @if ($loop->first)

                                    <td
                                        class="border border-green-600 text-center px-1 font-semibold"
                                        rowspan="{{ $dataKelas['row'] }}">

                                        {{ number_format($dataKelas['persentase'], 1, ',') }}%

                                    </td>

                                    @endif

                                </tr>

                                @endforeach
                                @endforeach
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @endif

</x-app-layout>