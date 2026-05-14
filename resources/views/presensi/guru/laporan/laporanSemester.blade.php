<x-app-layout>

    <div class="p-4 space-y-4">

        {{-- FILTER --}}
        <form class="flex gap-2 flex-wrap no-print">

            <select name="mode" class="border rounded px-3 py-2">
                <option value="harian" {{ request('mode')=='harian'?'selected':'' }}>Harian</option>
                <option value="bulanan" {{ request('mode','bulanan')=='bulanan'?'selected':'' }}>Bulanan</option>
                <option value="semester" {{ request('mode')=='semester'?'selected':'' }}>Semester</option>
            </select>

            @if(request('mode')=='harian')
            <input type="date" name="tanggal"
                value="{{ request('tanggal', now()->format('Y-m-d')) }}"
                class="border rounded px-3 py-2">
            @else
            <input type="month" name="tanggal"
                value="{{ request('tanggal', now()->format('Y-m')) }}"
                class="border rounded px-3 py-2">
            @endif

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Filter
            </button>
        </form>

        {{-- BUTTON --}}
        <div class="flex justify-between items-center bg-gray-50 p-3 rounded border no-print">

            <div class="text-sm text-gray-600">
                Rekap Laporan Presensi Guru
            </div>

            <div class="flex gap-2">
                <button onclick="window.print()"
                    class="bg-purple-600 text-white px-4 py-2 rounded text-xs">
                    Cetak
                </button>

                <button onclick="window.location.reload()"
                    class="bg-green-600 text-white px-4 py-2 rounded text-xs">
                    Refresh
                </button>

                <a href="{{ url()->current() }}"
                    class="bg-gray-600 text-white px-4 py-2 rounded text-xs">
                    Reset
                </a>
            </div>
        </div>

        {{-- PRINT AREA --}}
        <div id="print-area" class="bg-white p-4 shadow rounded">

            {{-- KOP --}}
            <div class="flex items-center justify-center gap-4 border-b pb-3 mb-4">

                @php
                $logo = base64_encode(file_get_contents(public_path('asset/images/logo.png')));
                @endphp

                <img src="data:image/png;base64,{{ $logo }}" class="w-20 h-20">

                <div class="text-center leading-tight">
                    <div class="font-bold uppercase text-sm">
                        Departemen Pendidikan Diniyah Wahidiyah
                    </div>
                    <div class="font-bold uppercase text-lg">
                        Madrasah Diniyah Wustho Wahidiyah
                    </div>
                    <div class="text-xs text-gray-600">
                        {{ $periode->semester->ket_semester ?? '-' }}
                        | TP {{ $periode->periode ?? '-' }}
                    </div>
                </div>
            </div>

            {{-- JUDUL --}}
            <div class="text-center mb-4">
                <div class="font-bold uppercase text-base">
                    Laporan Presensi Guru
                </div>
                <div class="text-sm text-gray-700">
                    @if($mode=='harian')
                    Harian - {{ $tanggal->format('d F Y') }}
                    @elseif($mode=='semester')
                    Semester - {{ $periode->semester->ket_semester ?? '-' }}
                    @else
                    Bulanan - {{ $tanggal->translatedFormat('F Y') }}
                    @endif
                </div>
            </div>

            {{-- TABLE --}}
            <table class="w-full text-xs border border-green-700">
                <thead>
                    <tr class="bg-green-700 text-white">
                        <th rowspan="2" class="border p-1">No</th>
                        <th rowspan="2" class="border p-1">Guru</th>
                        <th rowspan="2" class="border p-1">Kelas</th>
                        <th rowspan="2" class="border p-1">Total Jadwal</th>
                        <th rowspan="2" class="border p-1">Sesi Hadir</th>
                        <th colspan="4" class="border p-1 bg-green-800">Keterangan Absensi</th>
                        <th rowspan="2" class="border p-1">% Hadir</th>
                        <th colspan="7" class="border p-1 bg-green-800">Distribusi Hari</th>
                    </tr>
                    <tr class="bg-green-600 text-white">
                        <th class="border p-1">Hadir</th>
                        <th class="border p-1">Izin</th>
                        <th class="border p-1">Sakit</th>
                        <th class="border p-1">Alfa</th>

                        <th class="border p-1">Jum</th>
                        <th class="border p-1">Sab</th>
                        <th class="border p-1">Min</th>
                        <th class="border p-1">Sen</th>
                        <th class="border p-1">Sel</th>
                        <th class="border p-1">Rab</th>
                        <th class="border p-1">Kam</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $grouped = $laporan->groupBy(fn($i) => $i->nama_guru ?: '__NULL__');
                    @endphp

                    @forelse($grouped as $guru => $items)
                    @php
                    $first = $items->first();
                    $hadir = $items->sum('hadir');
                    $izin = $items->sum('izin');
                    $sakit = $items->sum('sakit');
                    $alfa = $items->sum('alfa');
                    $sesi = $items->sum('sesi');
                    $total = $first->total ?? 0;
                    $persen = $total > 0 ? ($hadir * 100 / $total) : 0;
                    @endphp

                    <tr class="border-b">
                        <td class="text-center p-1">{{ $loop->iteration }}</td>
                        <td class="p-1 font-semibold">
                            {{ $guru == '__NULL__' ? '-' : $guru }}
                        </td>
                        <td class="text-center p-1">{{ $first->kelas ?? '-' }}</td>
                        <td class="text-center p-1">{{ $total }}</td>
                        <td class="text-center p-1">{{ $sesi }}</td>

                        <td class="text-center text-green-600 font-bold">{{ $hadir }}</td>
                        <td class="text-center text-yellow-600">{{ $izin }}</td>
                        <td class="text-center text-orange-600">{{ $sakit }}</td>
                        <td class="text-center text-red-600">{{ $alfa }}</td>

                        <td class="text-center font-bold">
                            {{ number_format($persen,0) }}%
                        </td>

                        <td class="text-center">{{ $first->jumat ?? 0 }}</td>
                        <td class="text-center">{{ $first->sabtu ?? 0 }}</td>
                        <td class="text-center">{{ $first->minggu ?? 0 }}</td>
                        <td class="text-center">{{ $first->senin ?? 0 }}</td>
                        <td class="text-center">{{ $first->selasa ?? 0 }}</td>
                        <td class="text-center">{{ $first->rabu ?? 0 }}</td>
                        <td class="text-center">{{ $first->kamis ?? 0 }}</td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="17" class="text-center py-4 text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    {{-- PRINT STYLE --}}
    <style>
        @media print {

            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: F4 landscape;
                margin: 10mm;
            }

            /* 🔥 WAJIB SUPAYA WARNA & STRIPED MUNCUL */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* 🔥 TABLE FIX */
            table {
                border-collapse: collapse !important;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #000 !important;
                padding: 4px;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }

            /* 🔥 HEADER WARNA */
            .bg-green-700 {
                background: #15803d !important;
                color: white !important;
            }

            .bg-green-600 {
                background: #16a34a !important;
                color: white !important;
            }

            .bg-green-800 {
                background: #166534 !important;
                color: white !important;
            }

            /* 🔥 STRIPED ROW (INI YANG KAMU MAU) */
            tbody tr:nth-child(odd) {
                background: #f3f4f6 !important;
            }

            tbody tr:nth-child(even) {
                background: #ffffff !important;
            }

            /* WARNA STATUS */
            .text-green-600 {
                color: #16a34a !important;
                font-weight: bold;
            }

            .text-yellow-600 {
                color: #ca8a04 !important;
            }

            .text-orange-600 {
                color: #ea580c !important;
            }

            .text-red-600 {
                color: #dc2626 !important;
            }

            .font-bold {
                font-weight: bold;
            }
        }
    </style>

</x-app-layout>