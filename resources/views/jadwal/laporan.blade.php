<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Dashboard Kegiatan
                </h2>
                <p class="text-sm text-slate-500">
                    Rekap laporan plotting jadwal pelajaran
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #blanko,
            #blanko * {
                visibility: visible;
            }

            #blanko {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 12px;
            }

            .no-print {
                display: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 6px;
                font-size: 11px;
            }

            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>

    <script>
        function printContent() {
            window.print();
        }
    </script>

    {{-- Toolbar --}}
    <div class="px-4 py-4 no-print">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex flex-wrap gap-3">
            <a href="/Daftar-Jadwal"
                class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-700 hover:bg-slate-800 text-white font-medium transition">
                Jadwal
            </a>

            <button onclick="printContent()"
                class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                Cetak
            </button>

            <a href="{{ route('laporan.ploting.pdf') }}"
                class="inline-flex items-center px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium transition">
                Download PDF
            </a>
        </div>
    </div>

    {{-- Print Area --}}
    <div id="blanko" class="px-4 pb-8">
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-lg border border-slate-200">

            {{-- Header Report --}}
            <div class="p-6 border-b border-slate-200">
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-emerald-800">
                        MADRASAH DINIYAH WUSTHO WAHIDIYAH
                    </h1>
                    <h2 class="text-lg font-semibold text-slate-700 mt-1">
                        LAPORAN PLOTING JADWAL PELAJARAN
                    </h2>
                    <p class="text-sm uppercase tracking-wide text-slate-500 mt-1">
                        Tahun Pelajaran
                    </p>
                </div>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 no-print">
                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-sm text-slate-500">Jumlah Guru</p>
                    <p class="text-2xl font-bold text-slate-800">
                        {{ $laporan->count() }}
                    </p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-sm text-slate-500">Total Mapel</p>
                    <p class="text-2xl font-bold text-slate-800">
                        {{ $laporan->sum('jumlah_mapel') }}
                    </p>
                </div>

                <div class="bg-slate-50 border rounded-xl p-4">
                    <p class="text-sm text-slate-500">Total HR</p>
                    <p class="text-2xl font-bold text-emerald-700">
                        Rp {{ number_format($laporan->sum('jumlah_kelas') * 30000) }}
                    </p>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto px-6 pb-6">
                <table class="w-full text-sm border border-slate-300 rounded-lg overflow-hidden">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="px-3 py-3 border">No</th>
                            <th class="px-3 py-3 border text-left">Nama Guru</th>
                            <th class="px-3 py-3 border">Periode</th>
                            <th class="px-3 py-3 border">Semester</th>
                            <th class="px-3 py-3 border">Jumlah Mapel</th>
                            <th class="px-3 py-3 border">Jumlah Soal</th>
                            <th class="px-3 py-3 border">HR</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @foreach($laporan as $data)
                        @if($data->jumlah_kelas >= 1)
                        <tr class="hover:bg-slate-50">
                            <td class="border px-3 py-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-3 py-2 font-medium
                                        {{ $data->jumlah_kelas <= 1 ? 'text-red-600' : 'text-slate-700' }}">
                                {{ $data->nama_guru }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $data->periode }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $data->ket_semester }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $data->jumlah_kelas * 2 }}
                            </td>

                            <td class="border px-3 py-2 text-center">
                                {{ $data->jumlah_mapel }}
                            </td>

                            <td class="border px-3 py-2 text-center font-semibold text-emerald-700">
                                Rp {{ number_format($data->jumlah_kelas * 30000) }}
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        {{-- Footer total --}}
                        <tr class="bg-slate-100 font-bold">
                            <td colspan="6" class="border px-3 py-3 text-center">
                                Total HR
                            </td>
                            <td class="border px-3 py-3 text-center text-emerald-700">
                                Rp {{ number_format($laporan->sum('jumlah_kelas') * 30000) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>