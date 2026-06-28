<x-app-layout>
    <x-slot name="header">
        @section('title', '| REKAP HARIAN : '. $tgl->isoFormat('dddd, D MMMM YYYY'))

        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
            Rekap Absensi Kelas : {{ ($tgl->isoFormat('dddd, D MMMM YYYY')) }}
        </h2>
    </x-slot>

    {{-- LOADING OVERLAY --}}


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

                        <div class="overflow-auto rounded-xl border border-slate-200 shadow">

                            <table class="w-full text-sm border-collapse">

                                <thead class="sticky top-0 bg-slate-100 z-10">

                                    <tr>

                                        <th class="border px-2 py-2">No</th>
                                        <th class="border px-2 py-2">Asrama</th>
                                        <th class="border px-2 py-2">Kelas</th>
                                        <th class="border px-2 py-2">Total</th>
                                        <th class="border px-2 py-2">TH</th>
                                        <th class="border px-2 py-2">H</th>
                                        <th class="border px-2 py-2">Siswa Tidak Hadir</th>
                                        <th class="border px-2 py-2">Ket</th>
                                        <th class="border px-2 py-2">%</th>

                                    </tr>

                                </thead>

                                <tbody class="text-sm" style="font-size: small;">

                                    @php $nomor = 1; @endphp

                                    @foreach($rekapAbsensi as $namaAsrama => $dataAsrama)

                                    @php
                                    $firstAsrama = true;
                                    @endphp

                                    @foreach($dataAsrama as $namaKelas => $dataKelas)

                                    @foreach($dataKelas['absensi'] as $index => $absensi)

                                    <tr class="border border-green-600 even:bg-green-50 dark:even:bg-gray-800 hover:bg-green-100 dark:hover:bg-gray-700">

                                        {{-- NOMOR --}}
                                        @if($index === 0)

                                        <td
                                            rowspan="{{ $dataKelas['row'] }}"
                                            class="border border-green-600 text-center px-1">

                                            {{ $nomor++ }}

                                        </td>

                                        @endif

                                        {{-- ASRAMA --}}
                                        @if($firstAsrama && $index === 0)

                                        <td
                                            rowspan="{{ $rowspanAsrama[$namaAsrama] }}"
                                            class="border border-green-600 px-2 font-semibold bg-green-50 dark:bg-gray-800">

                                            {{ $namaAsrama }}

                                        </td>

                                        @php
                                        $firstAsrama = false;
                                        @endphp

                                        @endif

                                        {{-- KELAS --}}
                                        @if($index === 0)

                                        <td
                                            rowspan="{{ $dataKelas['row'] }}"
                                            class="border border-green-600 text-center">

                                            {{ $namaKelas }}

                                        </td>

                                        <td
                                            rowspan="{{ $dataKelas['row'] }}"
                                            class="border border-green-600 text-center">

                                            {{ $dataKelas['total'] }}

                                        </td>

                                        <td
                                            rowspan="{{ $dataKelas['row'] }}"
                                            class="border border-green-600 text-center text-red-600 font-bold">

                                            {{ $dataKelas['tidakHadir'] }}

                                        </td>

                                        <td
                                            rowspan="{{ $dataKelas['row'] }}"
                                            class="border border-green-600 text-center text-green-600 font-bold">

                                            {{ $dataKelas['hadir'] }}

                                        </td>

                                        @endif

                                        {{-- SISWA --}}
                                        <td class="border border-green-600 px-2">

                                            @if($dataKelas['tidakHadir'] > 0)

                                            {{ $loop->iteration }}. {{ ucwords(strtolower($absensi->nama_siswa)) }}

                                            @else

                                            <span class="text-gray-400 italic">
                                                Nihil
                                            </span>

                                            @endif

                                        </td>

                                        {{-- KETERANGAN --}}
                                        <td class="border border-green-600 text-center capitalize">

                                            @if($dataKelas['tidakHadir'] > 0)

                                            {{ $absensi->keterangan }}

                                            @else

                                            -

                                            @endif

                                        </td>

                                        {{-- PERSENTASE --}}
                                        @if($index === 0)

                                        <td
                                            rowspan="{{ $dataKelas['row'] }}"
                                            class="border border-green-600 text-center font-bold">

                                            {{ number_format($dataKelas['persentase'], 1, ',', '.') }}%

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

    </div>

    @endif

</x-app-layout>