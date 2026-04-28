<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Guru')
        <h2 class="font-semibold text-lg sm:text-xl">
            Laporan Bulanan Presensi Guru
        </h2>
    </x-slot>

    {{-- PRINT --}}
    <script>
        function printContent(id) {
            const content = document.getElementById(id).innerHTML;

            const win = window.open('', '', 'width=1200,height=800');

            win.document.write(`
    <html>
    <head>
        <title>Cetak Laporan</title>
        <style>
            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 11px;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
            }

            /* HEADER */
            .header {
                display: flex;
                align-items: center;
                border-bottom: 2px solid black;
                margin-bottom: 10px;
                padding-bottom: 5px;
            }

            .header img {
                width: 70px;
            }

            .header-text {
                width: 100%;
                text-align: center;
            }

            h1,h2,h3,p {
                margin: 2px 0;
            }

            /* TABLE */
            table {
                border-collapse: collapse;
                width: 100%;
                table-layout: fixed;
            }

            th, td {
                border: 1px solid #000;
                padding: 3px;
                text-align: center;
                word-wrap: break-word;
            }

            th {
                background: #ddd !important;
                -webkit-print-color-adjust: exact;
            }

            /* WARNA */
            .text-green-600 { color: green !important; }
            .text-yellow-600 { color: orange !important; }
            .text-red-600 { color: red !important; }

            .bg-red-100 {
                background: #f8d7da !important;
                -webkit-print-color-adjust: exact;
            }

            /* PAGE BREAK */
            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

        </style>
    </head>
    <body>
        <div class="container">
            ${content}
        </div>
    </body>
    </html>
    `);

            win.document.close();
            win.focus();
            win.print();
        }
    </script>

    <div class="p-4 space-y-4">

        {{-- FILTER --}}
        <div class="flex flex-col sm:flex-row justify-between gap-3">
            <form action="/laporan-semester-guru" method="get" class="flex gap-2">
                <input type="month" name="bulan"
                    class="border rounded px-2 py-1 dark:bg-dark-bg"
                    value="{{ request('bulan', now()->format('Y-m')) }}">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded">
                    Pilih Bulan
                </button>
            </form>

            <div class="flex gap-2">
                <a href="/sesi-presensi-guru"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-1 rounded">
                    Kembali
                </a>
                <a href="/laporan-semester-guru"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded">
                    Refresh
                </a>
                <button onclick="printContent('print-area')"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-1 rounded">
                    Cetak
                </button>
            </div>
        </div>

        {{-- AREA CETAK --}}
        <div id="print-area" class="bg-white dark:bg-dark-bg shadow rounded p-4">

            {{-- HEADER --}}
            <div class="flex items-center gap-4 border-b pb-3 mb-3">
                <img src="{{ asset('asset/images/logo.png') }}" width="80">

                <div class="text-center w-full">
                    <p class="text-sm uppercase">Departemen Pendidikan Diniyah Wahidiyah</p>
                    <p class="text-xl font-bold uppercase">Madrasah Diniyah Wustho Wahidiyah</p>
                    <p class="text-xs">
                        Semester {{ $kelasmi->ket_semester }} |
                        TP {{ $kelasmi->periode }}
                    </p>
                </div>
            </div>

            <div class="text-center mb-3">
                <p class="font-semibold uppercase">
                    Laporan Presensi Guru
                </p>
                <p class="text-sm">
                    Bulan {{ \Carbon\Carbon::parse(request('bulan', now()))->isoFormat('MMMM YYYY') }}
                </p>
            </div>

            {{-- TABLE (TIDAK DIUBAH STRUKTUR) --}}
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
                            <th class="border border-green-800 px-1">H</th>
                            <th class="border border-green-800 px-1">I</th>
                            <th class="border border-green-800 px-1">S</th>
                            <th class="border border-green-800 px-1">A</th>
                            <th class="border border-green-800 px-1">% H</th>
                            <th class="border border-green-800 px-1">Jumat</th>
                            <th class="border border-green-800 px-1">Sabtu</th>
                            <th class="border border-green-800 px-1">Minggu</th>
                            <th class="border border-green-800 px-1">Senin</th>
                            <th class="border border-green-800 px-1">Selasa</th>
                            <th class="border border-green-800 px-1">Rabu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $no = 1; @endphp

                        @forelse($laporan->groupBy('nama_guru') as $nama_guru => $laporanGuru)
                        @foreach($laporanGuru as $index => $data)
                        <tr class="hover:bg-gray-50 py-2">

                            {{-- NOMOR --}}
                            @if ($index === 0)
                            <td class="border border-green-800 text-center font-semibold py-2"
                                rowspan="{{ $laporanGuru->count() }}">
                                {{ $no++ }}
                            </td>
                            @endif

                            {{-- NAMA --}}
                            @if ($index === 0)
                            <td class="border border-green-800 px-1 font-semibold"
                                rowspan="{{ $laporanGuru->count() }}">
                                {{ $data->nama_guru }}
                            </td>
                            @endif

                            <td class="border border-green-800 text-center py-1">
                                {{ $data->nama_kelas }}
                            </td>

                            <td class="border border-green-800 text-center">
                                {{ $data->jumlahHari }}
                            </td>

                            <td class="border border-green-800 text-center">
                                {{ $data->jumlah_sesi_kelas_guru }}
                            </td>

                            {{-- KETERANGAN --}}
                            <td class="border border-green-800 text-center text-green-600 font-bold">
                                {{ $data->jumlah_hadir }}
                            </td>
                            <td class="border border-green-800 text-center text-yellow-600">
                                {{ $data->jumlah_izin }}
                            </td>
                            <td class="border border-green-800 text-center text-orange-600">
                                {{ $data->jumlah_sakit }}
                            </td>
                            <td class="border border-green-800 text-center text-red-600">
                                {{ $data->jumlah_alfa }}
                            </td>

                            {{-- PERSENTASE --}}
                            <td class="border border-green-800 text-center font-semibold">
                                @php
                                $persen = $data->jumlahHari != 0
                                ? ($data->jumlah_hadir * 100 / $data->jumlahHari)
                                : 0;
                                @endphp

                                <span class="{{ $persen >= 90 ? 'text-green-600' : ($persen >= 70 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ number_format($persen,0) }}%
                                </span>
                            </td>

                            {{-- HARI --}}
                            <td class="border text-center {{ $data->hari == 'jumat' ? '' : 'bg-red-100' }}">
                                {{ $data->hari == 'jumat' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'sabtu' ? '' : 'bg-red-100' }}">
                                {{ $data->hari == 'sabtu' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'minggu' ? '' : 'bg-red-100' }}">
                                {{ $data->hari == 'minggu' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'senin' ? '' : 'bg-red-100' }}">
                                {{ $data->hari == 'senin' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'selasa' ? '' : 'bg-red-100' }}">
                                {{ $data->hari == 'selasa' ? $data->total : '' }}
                            </td>
                            <td class="border text-center {{ $data->hari == 'rabu' ? '' : 'bg-red-100' }}">
                                {{ $data->hari == 'rabu' ? $data->total : '' }}
                            </td>

                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="15" class="text-center py-3 text-gray-500">
                                Tidak ada data laporan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- NOTE --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <h3 class="font-semibold mb-2">Catatan:</h3>
            <ul class="list-disc ml-5 text-sm space-y-1">
                <li>Data ditampilkan berdasarkan bulan yang dipilih.</li>
                <li>H = Hadir, I = Izin, S = Sakit, A = Alfa.</li>
                <li>Persentase dihitung dari total hari mengajar.</li>
                <li>Kolom merah menunjukkan hari tidak terjadwal.</li>
            </ul>
        </div>

    </div>
</x-app-layout>