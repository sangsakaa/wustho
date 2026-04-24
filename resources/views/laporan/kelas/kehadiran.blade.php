<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        @section('title', ' | Laporan Akumulasi Semester')

        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">
                Laporan Kehadiran
            </h2>
        </div>
    </x-slot>

    {{-- FILTER & ACTION --}}
    <div class="px-4 py-3 bg-white flex flex-col md:flex-row justify-between gap-3 md:items-center">

        {{-- PRINT --}}
        <button onclick="window.print()"
            class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded shadow">
            <x-icons.print />
            Print
        </button>

        {{-- FILTER BULAN --}}
        <form action="/Laporan-Kehadiran" method="GET" class="flex gap-2">
            <input type="month" name="bulan"
                class="border rounded px-3 py-2"
                value="{{ $bulan->format('Y-m') }}">
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
                Pilih
            </button>
        </form>
    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4">

        <div class="bg-green-100 p-4 rounded shadow">
            <p class="text-sm">Total Hadir</p>
            <h2 class="text-xl font-bold">{{ $summary['total_hadir'] }}</h2>
        </div>

        <div class="bg-yellow-100 p-4 rounded shadow">
            <p class="text-sm">Sakit</p>
            <h2 class="text-xl font-bold">{{ $summary['total_sakit'] }}</h2>
        </div>

        <div class="bg-blue-100 p-4 rounded shadow">
            <p class="text-sm">Izin</p>
            <h2 class="text-xl font-bold">{{ $summary['total_izin'] }}</h2>
        </div>

        <div class="bg-red-100 p-4 rounded shadow">
            <p class="text-sm">Alfa</p>
            <h2 class="text-xl font-bold">{{ $summary['total_alfa'] }}</h2>
        </div>
    </div>

    {{-- INFO TAMBAHAN --}}
    <div class="px-4 pb-4">
        <div class="bg-gray-100 p-4 rounded shadow text-sm">

            <div class="space-y-1 text-left">
                <div class="flex gap-2">
                    <span class="w-48">Rata-rata Kehadiran</span>
                    <span>:</span>
                    <span class="font-semibold">{{ $summary['rata_kehadiran'] }}%</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-48">Kelas Terbaik</span>
                    <span>:</span>
                    <span class="font-semibold">{{ $summary['kelas_terbaik'] }}</span>
                </div>

                <div class="flex gap-2">
                    <span class="w-48">Kelas Terburuk</span>
                    <span>:</span>
                    <span class="font-semibold">{{ $summary['kelas_terburuk'] }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- PRINT AREA --}}
    <div id="print-area" class="p-6 bg-white">

        {{-- KOP --}}
        <div class="text-center text-green-700 mb-4">
            <p class="font-serif text-lg uppercase">
                Pondok Pesantren Kedunglo Al Munadhdhoroh
            </p>

            <p class="uppercase font-semibold">
                Madrasah Diniyah {{ $kelasmi->jenjang }} Wahidiyah
            </p>

            <p class="text-sm">
                Semester {{ $kelasmi->ket_semester ?? '-' }}
                Tahun {{ $kelasmi->periode ?? '-' }}
            </p>

            <hr class="border-green-700 my-2">

            <p class="font-semibold">
                Laporan Kehadiran Bulan
                {{ \Carbon\Carbon::parse($bulan)->isoFormat('MMMM') }}
            </p>
        </div>

        {{-- TABEL KELAS --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-green-800">
                <thead class="bg-green-100 text-center">
                    <tr>
                        <th class="p-2">No</th>
                        <th>Kelas</th>
                        <th>Peserta</th>
                        <th>Sesi</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alfa</th>
                        <th>% Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr class="even:bg-gray-100 text-center">
                        <td class="p-1">{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_kelas }}</td>
                        <td>{{ $item->total_peserta_kelas }}</td>
                        <td>{{ $item->total_sesikelas }}</td>
                        <td>{{ $item->total_kehadiran }}</td>
                        <td>{{ $item->total_sakit }}</td>
                        <td>{{ $item->total_izin }}</td>
                        <td>{{ $item->total_alfa }}</td>
                        <td>{{ $item->presentase_hadir ?? 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TABEL ASRAMA --}}
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-sm border border-green-800">
                <thead class="bg-green-100 text-center">
                    <tr>
                        <th class="p-2">No</th>
                        <th>Asrama</th>
                        <th>Peserta</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alfa</th>
                        <th>% Alfa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataDetail as $result)
                    <tr class="even:bg-gray-100 text-center">
                        <td class="p-1">{{ $loop->iteration }}</td>
                        <td>{{ $result->nama_asrama }}</td>
                        <td>{{ $result->total_peserta }}</td>
                        <td>{{ $result->total_kehadiran }}</td>
                        <td>{{ $result->total_sakit }}</td>
                        <td>{{ $result->total_izin }}</td>
                        <td>{{ $result->total_alfa }}</td>
                        <td>{{ $result->presentase_alfa ?? 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TTD --}}
        <div class="mt-8 text-right text-sm">
            Kedunglo,
            {{ \Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}
            <br><br>
            Kepala Madrasah
            <br><br><br>
            <b>Muh. Bahrul Ulum, S.H</b>
        </div>
    </div>

</x-app-layout>