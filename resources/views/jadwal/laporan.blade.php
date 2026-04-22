<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Laporan')

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard kegiatan') }}
        </h2>
    </x-slot>

    <!-- STYLE -->
    <style>
        /* ================= SCREEN ================= */
        table {
            border-collapse: collapse;
        }

        /* ================= PRINT ================= */
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
                padding: 10px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 5px;
                font-size: 12px;
            }

            th {
                background: #f3f3f3;
            }

            button,
            a {
                display: none !important;
            }

            @page {
                size: A4 portrait;
                margin: 12mm;
            }
        }
    </style>

    <!-- ACTION -->
    <div class="px-4 py-2">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-2 flex gap-2 border-b">

                <a href="/Daftar-Jadwal"
                    class="py-1 px-3 bg-red-600 hover:bg-red-700 text-white rounded">
                    Jadwal
                </a>

                <button onclick="printContent()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded">
                    Cetak
                </button>

            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function printContent() {
            window.print();
        }
    </script>

    <!-- AREA CETAK -->
    <div id="blanko" class="p-4">
        <div class="mx-auto">

            <div class="bg-white text-sm">

                <!-- HEADER -->
                <div class="text-center mb-2">
                    <p class="font-bold text-sm sm:text-lg text-green-800">
                        MADRASAH DINIYAH WUSTHO WAHIDIYAH
                    </p>
                    <p class="font-semibold text-xs sm:text-md text-green-800">
                        LAPORAN PLOTING JADWAL PELAJARAN
                    </p>
                    <p class="font-semibold text-xs sm:text-md uppercase text-green-800">
                        TAHUN PELAJARAN
                    </p>
                </div>

                <hr class="border-b-2 border-green-700 mb-2">

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="w-full border border-green-800 text-xs sm:text-sm">

                        <thead>
                            <tr class="border border-green-800 bg-gray-100">
                                <th>No</th>
                                <th class="w-1/4 text-left">Nama Guru</th>
                                <th>Periode</th>
                                <th>Semester</th>
                                <th>Jumlah Mapel</th>
                                <th>Jumlah Soal</th>
                                <th>HR</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($laporan as $data)
                            @if($data->jumlah_kelas >= 1)
                            <tr class="text-center border border-green-800">

                                <td>{{ $loop->iteration }}</td>

                                <td class="text-left px-2 
                                            {{ $data->jumlah_kelas <= 1 ? 'text-red-600 font-semibold' : '' }}">
                                    {{ $data->nama_guru }}
                                </td>

                                <td>{{ $data->periode }}</td>
                                <td>{{ $data->ket_semester }}</td>

                                <td class="{{ $data->jumlah_kelas <= 1 ? 'text-red-600' : '' }}">
                                    {{ $data->jumlah_kelas * 2 }}
                                </td>

                                <td>{{ $data->jumlah_mapel }}</td>

                                <td>
                                    {{ 'Rp.' . number_format($data->jumlah_kelas * 30000) }}
                                </td>

                            </tr>
                            @endif
                            @endforeach

                            <!-- TOTAL -->
                            <tr class="font-bold">
                                <td colspan="6" class="text-center border border-green-800">
                                    Total HR
                                </td>
                                <td class="text-center border border-green-800">
                                    {{ 'Rp.' . number_format($laporan->sum('jumlah_kelas') * 30000) }}
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>