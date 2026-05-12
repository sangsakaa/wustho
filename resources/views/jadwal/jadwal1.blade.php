<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kelas 1 Daftar Jadwal')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="text-xl font-bold text-gray-800">
                📅 Dashboard Kegiatan
            </h2>

            <div class="flex gap-2">
                <a href="/Daftar-Jadwal"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm">
                    Daftar Jadwal
                </a>

                <button onclick="printContent('printArea')"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm">
                    🖨 Cetak
                </button>
            </div>
        </div>
    </x-slot>

    <div class="px-4 py-6">

        {{-- ================= PRINT AREA ================= --}}
        <div id="printArea" class="max-w-6xl mx-auto bg-white p-6 rounded-xl">

            @if($datakelasmi)

            {{-- ================= HEADER ================= --}}
            <div class="text-center mb-4">
                <h1 class="text-xl font-bold uppercase text-green-800">
                    MADRASAH DINIYAH {{ $kelasmi->jenjang }} WAHIDIYAH
                </h1>

                <h2 class="text-2xl font-bold text-green-700 mt-1">
                    JADWAL PELAJARAN
                </h2>

                <p class="text-sm text-green-700 mt-1">
                    TAHUN PELAJARAN {{ $datakelasmi->periode }} {{ $datakelasmi->ket_semester }}
                </p>

                <div class="border-b-2 border-green-700 mt-3"></div>
            </div>

            {{-- ================= GROUP DATA ================= --}}
            @php
            $jadwalByKelas = [];

            foreach ($jadwalByDayMap as $hari => $jadwals) {
            foreach ($jadwals as $jadwal) {

            $kelas = $jadwal->nama_kelas;

            $jadwalByKelas[$kelas][$hari][] = [
            'mapel' => $jadwal->mapel,
            'kitab' => $jadwal->nama_kitab,
            'guru' => $jadwal->nama_guru,
            ];
            }
            }

            $customOrder = ['senin','selasa','rabu','jumat','sabtu'];
            @endphp

            {{-- ================= TABLE ================= --}}
            <div class="overflow-x-auto">

                <table class="w-full border border-green-700 text-sm">

                    <thead>
                        <tr>
                            <th class="border border-green-700 px-2 py-1 w-24 uppercase">
                                Kelas
                            </th>

                            @foreach ($customOrder as $hari)
                            <th class="border border-green-700 px-2 py-1 uppercase">
                                {{ $hari }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($jadwalByKelas as $kelas => $hariData)
                        <tr class="text-center">

                            {{-- KELAS --}}
                            <td class="border border-green-700 font-semibold px-2 py-1 text-lg">
                                {{ $kelas }}
                            </td>

                            {{-- HARI --}}
                            @foreach ($customOrder as $hari)
                            <td class="border border-green-700 px-2 py-1 align-top">

                                @if(!empty($hariData[$hari]))

                                @foreach ($hariData[$hari] as $item)

                                <div class="mb-2 leading-tight">

                                    {{-- MAPEL --}}
                                    <div class="font-semibold uppercase text-green-800">
                                        {{ $item['mapel'] }}
                                    </div>

                                    {{-- KITAB --}}
                                    @if(!empty($item['kitab']))
                                    <div class="text-xs text-blue-700">
                                        📖 {{ $item['kitab'] }}
                                    </div>
                                    @endif

                                    {{-- GURU --}}
                                    <div class="text-xs text-gray-600">
                                        {{ ucwords($item['guru']) }}
                                    </div>

                                </div>

                                @endforeach

                                @else
                                <span class="text-gray-300">-</span>
                                @endif

                            </td>
                            @endforeach

                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

            @else

            <div class="bg-yellow-100 text-yellow-700 p-4 rounded-xl text-sm">
                ⚠ Belum ada ploting guru dan mapel
            </div>

            @endif

        </div>
    </div>

    {{-- ================= PRINT SCRIPT ================= --}}
    <script>
        function printContent(id) {
            const printArea = document.getElementById(id).innerHTML;
            const original = document.body.innerHTML;

            document.body.innerHTML = printArea;
            window.print();
            document.body.innerHTML = original;
            location.reload();
        }
    </script>

</x-app-layout>