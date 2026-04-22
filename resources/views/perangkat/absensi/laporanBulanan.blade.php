<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan Bulanan Perangkat ' . \Carbon\Carbon::parse($bulan)->isoFormat('MMMM Y'))
        <h2 class="font-semibold text-xl leading-tight">
            LAPORAN BULANAN
        </h2>
    </x-slot>
    <style>
        @media print {

            /* ✅ Margin halaman cetak (FIX UTAMA) */


            body {
                margin: 0;
                padding: 0;
            }

            /* Supaya warna tetap muncul */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Hanya tampilkan div1 */
            body * {
                visibility: hidden;
            }

            #div1,
            #div1 * {
                visibility: visible;
            }

            #div1 {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            /* Perbaikan tabel */
            table {
                page-break-inside: auto;
                border-collapse: collapse;
            }

            tr {
                page-break-inside: avoid;
            }

            thead {
                display: table-header-group;
            }

            @page {
                size: A4;
                margin: 1mm 1mm;
            }

            @page {
                size: A4;
                margin: 1mm 1mm;
            }

            @media print {
                img {
                    display: block !important;
                    max-width: 100% !important;
                }

            }
        }
    </style>

    {{-- HEADER ACTION --}}
    <div class="bg-white p-4 mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div class="flex gap-2">
                <a href="/sesi-perangkat" class="bg-blue-600 text-white rounded-md px-3 py-1">
                    Kembali
                </a>
                <button onclick="window.print()"
                    class="flex items-center gap-1 bg-green-700 text-white px-3 py-1 rounded-md">
                    <x-icons.print class="w-4 h-4" />
                    Cetak
                </button>
            </div>

            <div class="flex sm:justify-end">
                <form action="/laporan-Bulanan-perangkat" method="get" class="flex gap-2">
                    <input type="month" name="bulan" value="{{ $bulan->format('Y-m') }}" class="border px-2 py-1 rounded">
                    <button class="bg-red-600 text-white px-3 py-1 rounded">
                        Pilih
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- PRINT AREA --}}
    <div class="bg-white">
        <div id="div1" class="p-4">

            {{-- KOP --}}
            <div class="text-center text-green-700">
                <div class="flex items-center">
                    <img src="{{ asset('asset/images/logo.png') }}" width="90">
                    <div class="w-full text-center">
                        <p class="uppercase text-lg">Departemen Pendidikan Diniyah Wahidiyah</p>
                        <p class="uppercase text-2xl font-bold">Madrasah Diniyah Wustho Wahidiyah</p>
                        <p class="uppercase font-semibold">
                            Tahun Pelajaran {{ $periode->periode }} {{ $periode->ket_semester }}
                        </p>
                    </div>
                </div>

                <hr class="border-2 border-green-700 mt-2">
                <p class="uppercase font-semibold mt-2">
                    Laporan Presensi Perangkat Bulan {{ \Carbon\Carbon::parse($bulan)->isoFormat('MMMM') }}
                </p>
            </div>

            {{-- TABEL --}}
            <div class="overflow-auto mt-4">
                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-green-800">
                            <th class="border px-2">No</th>
                            <th class="border px-2">Nama Perangkat</th>
                            <th class="border px-2">Sesi/ <br>Jml Hari</th>
                            <th class="border px-2">Alfa</th>
                            <th class="border px-2">Hadir</th>
                            <th class="border px-2">Izin</th>
                            <th class="border px-2">Sakit</th>
                            <th class="border px-2">% Hadir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($laporanBulanan->groupBy('nama_perangkat') as $nama => $items)

                        @php
                        $total = $items->sum('total');
                        $hadir = $items->sum('jumlah_hadir');
                        $alfa = $items->sum('jumlah_alfa');
                        $izin = $items->sum('jumlah_izin');
                        $sakit = $items->sum('jumlah_sakit');

                        $persen = $total > 0 ? round(($hadir * 100) / $total) : 0;
                        @endphp

                        <tr class="text-center">
                            <td class="border px-2 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-2 text-left">{{ $nama }}</td>
                            <td class="border px-2">{{ $total }}</td>
                            <td class="border px-2">{{ $alfa }}</td>
                            <td class="border px-2">{{ $hadir }}</td>
                            <td class="border px-2">{{ $izin }}</td>
                            <td class="border px-2">{{ $sakit }}</td>
                            <td class="border px-2 font-semibold">{{ $persen }}%</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- TTD --}}
            <div class="mt-10 flex justify-end text-green-800 text-sm">
                <div class="text-left"> <br>
                    Kedunglo, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}
                    <p class="font-semibold">Al Mudir / Kepala</p>

                    <br><br><br>

                    @if($kelasmi->jenjang == "Wustho")
                    {{$kepalaSekolah->nama_perangkat}}
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT PRINT --}}


</x-app-layout>