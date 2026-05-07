<x-app-layout>
    <x-slot name="header">
        @if ($kelasmi)
        @section('title', ' - Kelas: ' . $kelasmi->nama_kelas)

        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Report Peringkat Kelas {{ $kelasmi->nama_kelas }}
            </h2>
            <p class="text-sm text-slate-500">
                Periode {{ $kelasmi->periode }} - {{ $kelasmi->ket_semester }}
            </p>
        </div>
        @endif
    </x-slot>

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
                background: white;
                padding: 0;
                margin: 0;
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
                padding: 4px !important;
                font-size: 11px !important;
                line-height: 1.2 !important;
            }

            @page {
                size: A4 portrait;
                margin: 8mm;
            }
        }
    </style>

    <script>
        function printRaport() {
            window.print();
        }
    </script>

    <div class="p-4 space-y-4">

        {{-- TOOLBAR --}}
        <div class="bg-white rounded-xl shadow border p-4 no-print">
            <div class="flex flex-col sm:flex-row justify-between gap-3">

                <div class="flex gap-2">
                    <button onclick="printRaport()"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm">
                        Cetak Raport
                    </button>

                    <a href="/semester"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm">
                        Batal
                    </a>
                </div>

                <form action="/peringkat" method="post" class="flex gap-2">
                    @csrf
                    <select name="kelasmi_id"
                        class="border rounded-lg px-3 py-2 text-sm">
                        <option value="">-- Pilih Kelas --</option>

                        @foreach ($datakelasmi as $item)
                        <option value="{{ $item->id }}"
                            {{ $kelasmi?->id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kelas }} -
                            {{ $item->periode }}
                            {{ $item->ket_semester }}
                        </option>
                        @endforeach
                    </select>

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                        Tampilkan
                    </button>
                </form>
            </div>
        </div>

        {{-- PRINT AREA --}}
        <div id="print-area"
            class="bg-white rounded-xl shadow border p-4">

            @if ($kelasmi)

            {{-- HEADER --}}
            <div class="text-center border-b pb-2 mb-3">
                <h1 class="text-base font-bold text-slate-800">
                    PERINGKAT HASIL TADRIS
                </h1>

                <h2 class="text-sm font-semibold text-slate-700">
                    MADRASAH DINIYAH WUSTHO WAHIDIYAH
                </h2>

                <div class="mt-2 text-xs text-slate-600">
                    <p>
                        Kelas:
                        <span class="font-semibold">{{ $kelasmi->nama_kelas }}</span>
                        |
                        Periode:
                        <span class="font-semibold">{{ $kelasmi->periode }}</span>
                        |
                        Semester:
                        <span class="font-semibold">
                            {{ Str::upper($kelasmi->ket_semester) }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- TABLE --}}
            <table class="w-full border text-xs">
                <thead class="bg-slate-800 text-white">
                    <tr>
                        <th rowspan="2" class="border">No</th>
                        <th rowspan="2" class="border">NIS</th>
                        <th rowspan="2" class="border">Nama</th>
                        <th colspan="2" class="border">Total Nilai</th>
                        <th rowspan="2" class="border">Rank</th>
                        <th rowspan="2" class="border">Status</th>
                    </tr>
                    <tr>
                        <th class="border">NH</th>
                        <th class="border">NU</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($ringkasanraportkelas as $pesertakelas_id => $ringkasan)
                    @php
                    if (!$siswa->has($pesertakelas_id)) continue;

                    $datasiswa = $siswa[$pesertakelas_id];
                    $total = $ringkasan['jmlujian'] + $ringkasan['jmlharian'];
                    @endphp

                    <tr>
                        <td class="border text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border text-center">
                            {{ $datasiswa->nis }}
                        </td>

                        <td class="border px-2 capitalize">
                            {{ strtolower($datasiswa->nama_siswa) }}
                        </td>

                        <td class="border text-center">
                            <span class="{{ $ringkasan['jmlharian'] <= 400 ? 'text-red-600 font-bold' : '' }}">
                                {{ $ringkasan['jmlharian'] }}
                            </span>
                        </td>

                        <td class="border text-center">
                            <span class="{{ $ringkasan['jmlujian'] <= 400 ? 'text-red-600 font-bold' : '' }}">
                                {{ $ringkasan['jmlujian'] }}
                            </span>
                        </td>

                        <td class="border text-center font-semibold">
                            {{ $ringkasan['peringkat'] }}
                        </td>

                        <td class="border text-center">
                            @if($total <= 600)
                                <span class="text-red-600 font-semibold">
                                Tidak Lulus
                                </span>
                                @else
                                <span class="text-green-700 font-semibold">
                                    Lulus
                                </span>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @endif
        </div>
    </div>
</x-app-layout>