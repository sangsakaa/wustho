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

    {{-- Toolbar --}}
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
        </div>
    </div>

    {{-- Print Area --}}
    <div id="print-area" class="p-4">
        <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-2xl p-6">

            @if($Periode)
            {{-- Header laporan --}}
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

            {{-- Info ringkas --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 text-sm">
                <div class="bg-slate-50 p-3 rounded-xl border">
                    <p class="text-slate-500">Jumlah Kelas</p>
                    <p class="font-bold text-lg">{{ $Periode->jumlah_kelas }}</p>
                </div>

                <div class="bg-slate-50 p-3 rounded-xl border">
                    <p class="text-slate-500">Jumlah Mapel</p>
                    <p class="font-bold text-lg">{{ $Periode->jumlah_mapel }}</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-slate-300">
                    <thead class="bg-slate-100">
                        <tr>
                            <th rowspan="2" class="border px-2 py-2">No</th>
                            <th rowspan="2" class="border px-2 py-2">Nama Guru</th>
                            <th colspan="{{ $laporan->pluck('nama_kelas')->unique()->count() }}"
                                class="border px-2 py-2">
                                Kelas
                            </th>
                            <th rowspan="2" class="border px-2 py-2">
                                Jumlah Mapel
                            </th>
                            <th rowspan="2" class="border px-2 py-2">
                                Jumlah Kelas
                            </th>
                        </tr>
                        <tr>
                            @foreach ($laporan->pluck('nama_kelas')->unique()->sort() as $nama_kelas)
                            <th class="border px-2 py-2">
                                {{ $nama_kelas }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($laporan->pluck('nama_guru')->unique()->sort() as $nama_guru)
                        <tr class="hover:bg-slate-50">
                            <td class="border text-center px-2 py-1">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-2 py-1 font-medium">
                                {{ $nama_guru }}
                            </td>

                            @foreach ($laporan->pluck('nama_kelas')->unique()->sort() as $nama_kelas)
                            @php
                            $jumlah = $laporan
                            ->where('nama_guru', $nama_guru)
                            ->where('nama_kelas', $nama_kelas)
                            ->sum('jumlah_mapel');
                            @endphp

                            <td class="border text-center px-2 py-1 {{ $jumlah > 0 ? 'bg-emerald-100 font-semibold' : '' }}">
                                {{ $jumlah }}
                            </td>
                            @endforeach

                            <td class="border text-center font-bold">
                                {{ $laporan->where('nama_guru', $nama_guru)->sum('jumlah_mapel') }}
                            </td>

                            <td class="border text-center font-bold">
                                {{ $laporan->where('nama_guru', $nama_guru)->count() }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-10">
                <p class="text-slate-500 text-lg">
                    Tidak ada plotting guru
                </p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>