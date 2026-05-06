<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Guru')
        <h2 class="font-semibold text-lg sm:text-xl">
            Laporan Bulanan Presensi Guru
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- FILTER --}}
        <div class="flex flex-col sm:flex-row justify-between gap-3">
            <form action="/laporan-semester-guru" method="get" class="flex gap-2">
                <input type="month"
                    name="bulan"
                    value="{{ request('bulan', now()->format('Y-m')) }}"
                    class="border rounded px-3 py-2">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Pilih Bulan
                </button>
            </form>

            <div class="flex gap-2">
                <a href="/sesi-presensi-guru"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Kembali
                </a>

                <a href="/laporan-semester-guru"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Refresh
                </a>

                <button onclick="printContent('print-area')"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                    Cetak
                </button>
            </div>
        </div>

        {{-- PRINT AREA --}}
        <div id="print-area" class="bg-white shadow rounded-lg p-4">

            {{-- HEADER --}}
            <div class="flex items-center gap-4 border-b pb-3 mb-4">
                <img src="{{ asset('asset/images/logo.png') }}" width="80">

                <div class="text-center w-full">
                    <p class="text-sm uppercase">
                        Departemen Pendidikan Diniyah Wahidiyah
                    </p>
                    <p class="text-xl font-bold uppercase">
                        Madrasah Diniyah Wustho Wahidiyah
                    </p>
                    <p class="text-xs">
                        Semester {{ $kelasmi->ket_semester }} |
                        TP {{ $kelasmi->periode }}
                    </p>
                </div>
            </div>

            <div class="text-center mb-4">
                <p class="font-semibold uppercase">
                    Laporan Presensi Guru
                </p>
                <p class="text-sm">
                    Bulan {{ \Carbon\Carbon::parse(request('bulan', now()))->isoFormat('MMMM YYYY') }}
                </p>
            </div>

            {{-- TABLE --}}
            <div class="overflow-auto">
                <table class="w-full text-xs border border-green-800">
                    <thead>
                        <tr class="bg-gray-200 text-center">
                            <th rowspan="2" class="border border-green-800 px-1">No</th>
                            <th rowspan="2" class="border border-green-800 px-1">Nama</th>
                            <th rowspan="2" class="border border-green-800 px-1">Kls</th>
                            <th rowspan="2" class="border border-green-800 px-1">Total</th>
                            <th rowspan="2" class="border border-green-800 px-1">Sesi</th>
                            <th colspan="5" class="border border-green-800 px-1">Keterangan</th>
                            <th colspan="6" class="border border-green-800 px-1">Terjadwal Hari</th>
                        </tr>

                        <tr class="bg-gray-100 text-center">
                            <th class="border border-green-800">H</th>
                            <th class="border border-green-800">I</th>
                            <th class="border border-green-800">S</th>
                            <th class="border border-green-800">A</th>
                            <th class="border border-green-800">% H</th>
                            <th class="border border-green-800">Jumat</th>
                            <th class="border border-green-800">Sabtu</th>
                            <th class="border border-green-800">Minggu</th>
                            <th class="border border-green-800">Senin</th>
                            <th class="border border-green-800">Selasa</th>
                            <th class="border border-green-800">Rabu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $no = 1; @endphp

                        @forelse($laporan->groupBy('nama_guru') as $laporanGuru)
                        @foreach($laporanGuru as $index => $data)
                        <tr class="hover:bg-gray-50 border">

                            @if($index === 0)
                            <td rowspan="{{ $laporanGuru->count() }}"
                                class="border border-green-800 text-center font-semibold">
                                {{ $no++ }}
                            </td>

                            <td rowspan="{{ $laporanGuru->count() }}"
                                class="border border-green-800 px-2 font-semibold text-left nama-guru">
                                {{ $data->nama_guru }}
                            </td>
                            @endif

                            <td class="border border-green-800 text-center">
                                {{ $data->nama_kelas }}
                            </td>

                            <td class="border border-green-800 text-center">
                                {{ $data->jumlahHari }}
                            </td>

                            <td class="border border-green-800 text-center">
                                {{ $data->jumlah_sesi_kelas_guru }}
                            </td>

                            <td class="border text-center border-green-800 text-green-600 font-bold">
                                {{ $data->jumlah_hadir }}
                            </td>

                            <td class="border text-center border-green-800 text-yellow-600">
                                {{ $data->jumlah_izin }}
                            </td>

                            <td class="border text-center border-green-800 text-orange-600">
                                {{ $data->jumlah_sakit }}
                            </td>

                            <td class="border text-center border-green-800 text-red-600">
                                {{ $data->jumlah_alfa }}
                            </td>

                            @php
                            $persen = $data->jumlahHari != 0
                            ? ($data->jumlah_hadir * 100 / $data->jumlahHari)
                            : 0;
                            @endphp
                            <td class="border text-center border-green-800 font-semibold">
                                <span class="{{ $persen >= 90 ? 'text-green-600' : ($persen >= 70 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ number_format($persen, 0) }}%
                                </span>
                            </td>

                            <td class="border text-center {{ $data->hari == 'jumat' ? '' : '' }}">
                                {{ $data->hari == 'jumat' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'sabtu' ? '' : '' }}">
                                {{ $data->hari == 'sabtu' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'minggu' ? '' : '' }}">
                                {{ $data->hari == 'minggu' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'senin' ? '' : '' }}">
                                {{ $data->hari == 'senin' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'selasa' ? '' : '' }}">
                                {{ $data->hari == 'selasa' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'rabu' ? '' : '' }}">
                                {{ $data->hari == 'rabu' ? $data->total : '' }}
                            </td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="15" class=" border text-center py-4 text-gray-500">
                                Tidak ada data laporan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function printContent(id) {
            const content = document.getElementById(id).innerHTML;
            const win = window.open('', '_blank', 'width=1200,height=800');

            win.document.write(`
                <html>
                <head>
                    <title>Cetak Laporan Guru</title>
                    <script src="https://cdn.tailwindcss.com"><\/script>

                    <style>
                        @page {
                            size: A4 landscape;
                            margin: 10mm;
                        }

                        body {
                            font-family: Arial, sans-serif;
                            font-size: 11px;
                            padding: 10px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        th, td {
                            border: 1px solid #166534 !important;
                            padding: 4px;
                            text-align: center;
                        }

                        .nama-guru {
                            text-align: left !important;
                            padding-left: 8px !important;
                        }

                        .text-left {
                            text-align: left !important;
                        }

                        .bg-red-100 {
                            background: #fee2e2 !important;
                            -webkit-print-color-adjust: exact;
                        }

                        thead {
                            display: table-header-group;
                        }

                        tr {
                            page-break-inside: avoid;
                        }
                    </style>
                </head>
                <body>
                    ${content}
                </body>
                </html>
            `);

            win.document.close();

            setTimeout(() => {
                win.focus();
                win.print();
                win.close();
            }, 700);
        }
    </script>
</x-app-layout>