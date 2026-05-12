<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Kelas')

        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-slate-800">
                    Dashboard Kegiatan Kelas
                </h2>
                <p class="text-sm text-slate-500">
                    Laporan plotting guru dan distribusi kelas
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            body {
                background: white !important;
                font-size: 11px;
            }

            .no-print {
                display: none !important;
            }

            #print-area {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 4px;
            }
        }
    </style>

    <script>
        function printContent() {
            window.print();
        }
    </script>

    <div class="p-4 no-print">
        <div class="bg-white shadow rounded-2xl p-4 flex gap-3">
            <a href="/Daftar-Jadwal"
                class="px-4 py-2 rounded-lg bg-slate-700 hover:bg-slate-800 text-white font-medium transition">
                Jadwal
            </a>

            <a href="{{ route('laporan.ploting.pdf') }}" target="_blank"
                class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition">
                Download PDF
            </a>

            <button onclick="printContent()"
                class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium transition">
                Print
            </button>
        </div>
    </div>

    <div id="print-area" class="p-4">
        <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-2xl p-6">

            @if($Periode)

            @php
            $kelasList = $laporan->pluck('nama_kelas')->unique()->sort()->values();

            // FIX DI SINI
            $data = $laporan->groupBy('nama_guru')->map(function ($items) {
            return $items->groupBy('mapel');
            });
            @endphp

            <div id="print-area" class="p-4">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-emerald-800">
                        MADRASAH DINIYAH WUSTHO WAHIDIYAH
                    </h1>
                    <h2 class="text-lg font-semibold text-slate-700">
                        LAPORAN PLOTING GURU
                    </h2>
                    <p class="text-sm uppercase text-slate-600 mt-1">
                        Tahun Pelajaran {{ $Periode->periode }} {{ $Periode->ket_semester }}
                    </p>
                </div>

                <hr class="border-2 border-emerald-700 mb-4">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border border-slate-300">
                        <thead class="bg-slate-100">
                            <tr>
                                <th rowspan="2" class="border px-2 py-2">No</th>
                                <th rowspan="2" class="border px-2 py-2">Nama Guru</th>
                                <th rowspan="2" class="border px-2 py-2">Mapel</th>

                                <th colspan="{{ $kelasList->count() }}"
                                    class="border px-2 py-2">
                                    Kelas
                                </th>

                                <th rowspan="2" class="border px-2 py-2">
                                    Jumlah <br> Kelas
                                </th>

                                <th rowspan="2" class="border px-2 py-2">
                                    Jumlah <br> Jam
                                </th>
                            </tr>

                            <tr>
                                @foreach ($kelasList as $kelas)
                                <th class="border px-2 py-2">{{ $kelas }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $nama_guru => $mapels)

                            @php
                            $rowspan = $mapels->count();
                            $firstGuru = true;
                            @endphp

                            @foreach ($mapels as $nama_mapel => $items)

                            @php
                            $kelasAktif = $items->pluck('nama_kelas')->toArray();
                            $jumlahKelas = count(array_unique($kelasAktif));
                            $jumlahJam = $jumlahKelas * 2;
                            @endphp

                            <tr>

                                @if($firstGuru)
                                <td rowspan="{{ $rowspan }}"
                                    class="border text-center">
                                    {{ $loop->parent->iteration }}
                                </td>

                                <td rowspan="{{ $rowspan }}"
                                    class="border px-2">
                                    {{ $nama_guru }}
                                </td>

                                @php $firstGuru = false; @endphp
                                @endif

                                <td class="border px-2 bg-slate-50">
                                    {{ ucwords(strtolower($nama_mapel)) }}
                                </td>

                                @foreach ($kelasList as $kelas)
                                @php
                                $ada = in_array($kelas, $kelasAktif);
                                @endphp

                                <td class="border text-center {{ $ada ? 'bg-emerald-100 font-bold' : '' }}">
                                    {{ $ada ? 2 : '' }}
                                </td>
                                @endforeach

                                <td class="border text-center font-bold">
                                    {{ $jumlahKelas }}
                                </td>

                                <td class="border text-center font-bold">
                                    {{ $jumlahJam }}
                                </td>
                            </tr>

                            @endforeach
                            @endforeach
                        </tbody>

                        <tfoot class="bg-slate-100 font-bold">
                            <tr>
                                <td colspan="3" class="border text-center">
                                    TOTAL JAM
                                </td>

                                @foreach ($kelasList as $kelas)
                                @php
                                $total = $laporan->where('nama_kelas', $kelas)->count() * 2;
                                @endphp

                                <td class="border text-center">
                                    {{ $total }}
                                </td>
                                @endforeach

                                <td class="border text-center">
                                    {{ $laporan->count() }}
                                </td>

                                <td class="border text-center">
                                    {{ $laporan->count() * 2 }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @endif
            </div>
        </div>
    </div>
</x-app-layout>