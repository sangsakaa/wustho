<x-app-layout>

    <x-slot name="header">
        @section('title', '| Blanko Presensi')

        <h2 class="text-2xl font-semibold">
            Blanko Presensi Kelas
        </h2>
    </x-slot>

    <style>
        .page-break {
            page-break-before: always;
            break-before: page;
        }

        @media print {

            @page {
                size: F4 portrait;
                margin: 8mm;
            }

            html,
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                background: #fff;
            }

            /* sembunyikan toolbar */
            .no-print {
                display: none !important;
            }

            /* tampilkan hanya area blanko */
            body * {
                visibility: hidden;
            }

            #blanko,
            #blanko * {
                visibility: visible;
            }

            #blanko {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            .print-grid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr);
                gap: 8mm;
            }

            .print-item {
                width: 100%;
                break-inside: avoid;
                page-break-inside: avoid;
                margin-bottom: 5mm;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            tr,
            td,
            th {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            img {
                max-width: 100%;
            }

        }
    </style>

    <script>
        function printContent() {
            window.print();
        }
    </script>

    {{-- Toolbar --}}
    <div class="my-4 no-print">
        <div class="bg-white rounded-xl shadow border p-4">
            <button
                onclick="printContent()"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                Cetak
            </button>
        </div>
    </div>
    <div id="blanko">
        {{-- ========================= --}}
        {{-- BLANKO PRESENSI --}}
        {{-- ========================= --}}

        <div class="grid grid-cols-2 gap-2 print-grid">
            @foreach($kelasmi as $item)
            <div class="border rounded-lg p-3 print-item">
                {{-- KOP --}}
                <div class="flex gap-3 items-center">
                    <img
                        src="{{ asset('asset/images/logo.png') }}"
                        class="w-16">
                    <div class="flex-1 text-center">
                        <h4 class="font-semibold uppercase">
                            Madrasah Diniyah Wustho Wahidiyah
                        </h4>

                        <p class="text-xs">
                            Tahun Pelajaran
                            {{ $item->periode }}
                            {{ $item->ket_semester }}
                        </p>
                    </div>
                </div>
                <hr class="border-green-700 my-2">
                <div class="grid grid-cols-4 gap-2 text-sm mb-3">
                    <div class="font-semibold">
                        Kelas
                    </div>
                    <div>
                        : {{ $item->nama_kelas }}
                    </div>
                    <div class="font-semibold">
                        Tanggal
                    </div>

                    <div>
                        : __________ {{ $bulan }}
                    </div>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr>
                            <th rowspan="2" class="border border-green-700 w-10">
                                No
                            </th>
                            <th rowspan="2" class="border border-green-700">
                                Nama Murid
                            </th>
                            <th colspan="3" class="border border-green-700">
                                Keterangan
                            </th>
                        </tr>
                        <tr>
                            <th class="border border-green-700 w-8">
                                S
                            </th>
                            <th class="border border-green-700 w-8">
                                I
                            </th>
                            <th class="border border-green-700 w-8">
                                A
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=1;$i<=10;$i++)
                            <tr>
                            <td class="border border-green-700 text-center py-3">
                                {{ $i }}
                            </td>
                            <td class="border border-green-700"></td>
                            <td class="border border-green-700"></td>
                            <td class="border border-green-700"></td>
                            <td class="border border-green-700"></td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
        <div class="page-break"></div>
        {{-- ========================= --}}
        {{-- SURAT IZIN --}}
        {{-- ========================= --}}
        <div class="grid grid-cols-2 gap-2 print-grid">
            @foreach($kelasmi as $item)
            <div class="border border-green-700 rounded-lg p-4 text-green-900 print-item">
                <div class="flex gap-3 items-center">
                    <img
                        src="{{ asset('asset/images/logo.png') }}"
                        class="w-16">
                    <div class="flex-1 text-center">
                        <h3 class="font-bold uppercase">
                            Pondok Pesantren Kedunglo
                        </h3>
                        <p class="font-semibold uppercase">
                            Madrasah Diniyah Wustho Wahidiyah
                        </p>
                        <p class="text-xs">
                            Tahun Pelajaran
                            {{ $item->periode }}
                            {{ $item->ket_semester }}
                        </p>
                    </div>
                </div>

                <hr class="my-2 border-green-700">

                <h3 class="text-center font-bold uppercase underline mb-2">
                    Surat Izin
                </h3>
                <table class="text-sm w-full mb-2">
                    <tr>

                        <td width="90">
                            Nama
                        </td>

                        <td width="10">
                            :
                        </td>

                        <td class="border-b border-green-700"></td>
                    </tr>
                    <tr>
                        <td>
                            Kelas
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            {{ $item->nama_kelas }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Asrama
                        </td>
                        <td>
                            :
                        </td>
                        <td class="border-b border-green-700"></td>
                    </tr>
                </table>
                <p class="text-sm mb-2">
                    Diberikan izin tidak mengikuti kegiatan Madrasah karena :
                </p>
                <div class="space-y-2 text-sm">
                    <label>
                        <input type="checkbox">
                        Sakit
                    </label>
                    <label class="ml-5">
                        <input type="checkbox">
                        Izin
                    </label>
                </div>
                <div class="border border-green-700 h-20 mt-3 p-2">
                    Alasan :
                </div>
                <div class="flex justify-end mt-2">
                    <div class="text-center text-sm">
                        <p>
                            Kediri, ____ {{ $bulan }}
                        </p>
                        <p class="mt-14">
                            ___________________
                        </p>
                        <p>
                            Ketua Asrama
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</x-app-layout>