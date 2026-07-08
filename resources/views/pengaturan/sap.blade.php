<x-app-layout>
    <x-slot name="header">
        @if($kelasmi)
        @section('title', '| SAP KELAS : '. $kelasmi->nama_kelas)
        @endif

        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('Satuan Acara Pembelajaran') }}
        </h2>
    </x-slot>
    {{-- FILTER --}}
    <div class="my-3">
        <div class="bg-white dark:bg-dark-bg rounded-xl shadow border border-gray-200 dark:border-gray-700">
            <div class="px-4 py-3 grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">

                <div>
                    <form action="/sap" method="get" class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                        <select
                            name="kelasmi_id"
                            class="w-full sm:w-72 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-dark-bg dark:text-white focus:ring-purple-500 focus:border-purple-500 text-sm"
                            required>
                            <option value="">-- Pilih Kelas --</option>

                            @foreach ($dataKelasMi as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelasmi?->id === $kelas->id ? "selected" : "" }}>
                                {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                            </option>
                            @endforeach
                        </select>

                        <button
                            class="bg-red-600 hover:bg-purple-600 transition duration-200 text-white px-5 py-2 rounded-lg shadow text-sm font-medium">
                            Pilih Kelas
                        </button>
                    </form>
                </div>

                <div class="flex justify-start sm:justify-end">
                    <button
                        onclick="printContent('blanko')"
                        class="bg-red-600 hover:bg-purple-600 transition duration-200 text-white px-5 py-2 rounded-lg shadow text-sm font-medium">
                        Cetak
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script>
        function printContent(el) {
            var fullbody = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>
    <style>
        .page-break {
            page-break-after: always;
        }

        table {
            border-collapse: collapse;
        }

        @media print {
            body {
                background: white;
            }

            .break-after-page {
                page-break-after: always;
            }
        }
    </style>
    @if($kelasmi)
    <div class="py-2" id="blanko">
        <div class="bg-white dark:bg-dark-bg  shadow    px-3 py-2">
            @foreach ($dataMapel as $mapel)
            <div class="mb-4">

                {{-- HEADER --}}
                <div class="overflow-auto bg-white dark:bg-dark-bg">
                    <div class="flex items-center gap-3 text-center text-green-900 tracking-wide">
                        <div class="py-1">
                            <img src="{{ asset('asset/images/logo.png') }}" width="85">
                        </div>
                        <div class="w-full py-1">
                            <p class="font-bold text-lg uppercase">
                                MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                            </p>

                            <p class="text-2xl uppercase font-extrabold tracking-wide">
                                Satuan Acara Pembelajaran
                            </p>

                            <p class="font-semibold uppercase text-sm">
                                TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                            </p>
                        </div>
                    </div>
                    <hr class="border-b-2 border-green-800 my-2">
                    {{-- INFO --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-y-1 text-green-800 text-sm mb-2">

                        <div class="font-semibold">KELAS</div>
                        <div class="font-semibold">
                            : {{ $kelasmi->nama_kelas }}
                        </div>
                        <div class="font-semibold">MATA PELAJARAN</div>
                        <div class="font-semibold">
                            : {{ $mapel->mapel }}
                        </div>
                        <div class="font-semibold">GURU MAPEL</div>
                        <div class="font-semibold">
                            : {{ $mapel->nama_guru }}
                        </div>
                        <div class="font-semibold">HARI</div>
                        <div class="font-semibold capitalize">
                            : {{ strtolower($mapel->hari )}}
                        </div>
                    </div>

                    {{-- TABEL ABSEN --}}
                    <div class="overflow-x-auto rounded-lg border ">

                        <table class="w-full table-auto border-collapse text-green-800">

                            <thead>

                                {{-- Header Baris 1 --}}
                                <tr class="bg-green-50 text-xs sm:text-sm">

                                    <th rowspan="2" class="w-10 border border-green-600 px-2 py-2">
                                        NO
                                    </th>

                                    <th rowspan="2" class=" w-48 border border-green-600 px-2">
                                        NAMA
                                    </th>

                                    <th colspan="2" class="border border-green-600 px-2">
                                        NILAI TUGAS
                                    </th>

                                    <th colspan="18" class="border border-green-600 px-2">
                                        PERTEMUAN
                                    </th>

                                </tr>

                                {{-- Header Baris 2 --}}
                                <tr class="bg-green-100 text-xs sm:text-sm">

                                    <th class="w-10 border border-green-600">
                                        1
                                    </th>

                                    <th class="w-10 border border-green-600">
                                        2
                                    </th>

                                    @for($i = 1; $i <= 18; $i++)
                                        <th class="w-8 border border-green-600 text-center">
                                        {{ $i }}
                                        </th>
                                        @endfor

                                </tr>

                            </thead>

                            <tbody class="text-xs sm:text-sm">

                                {{-- Data Siswa --}}
                                @foreach($dataSiswa as $siswa)
                                <tr class="even:bg-gray-50 dark:even:bg-gray-800">

                                    {{-- No --}}
                                    <td class="border border-green-600 text-center py-1">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Nama --}}
                                    <td class="border border-green-600 px-2 py-1 font-medium whitespace-nowrap">
                                        {{ Str::title(strtolower($siswa->nama_siswa)) }}
                                    </td>

                                    {{-- Nilai Tugas --}}
                                    <td class="border border-green-600 py-1"></td>
                                    <td class="border border-green-600 py-1"></td>

                                    {{-- Pertemuan --}}
                                    @for($i = 1; $i <= 18; $i++)
                                        <td class="border border-green-600 py-1">
                                        </td>
                                        @endfor

                                </tr>
                                @endforeach

                                {{-- Baris Kosong hingga 40 siswa --}}
                                @for($i = $dataSiswa->count(); $i < 40; $i++)
                                    <tr class="{{ $i % 2 == 0 ? 'bg-gray-50 dark:bg-gray-800' : '' }}">

                                    {{-- No --}}
                                    <td class="border border-green-600 text-center py-1">
                                        {{ $i + 1 }}
                                    </td>

                                    {{-- Nama --}}
                                    <td class="border border-green-600 px-2 py-1"></td>

                                    {{-- Nilai Tugas --}}
                                    <td class="border border-green-600 py-1"></td>
                                    <td class="border border-green-600 py-1"></td>

                                    {{-- Pertemuan --}}
                                    @for($x = 1; $x <= 18; $x++)
                                        <td class="border border-green-600 py-1">
                                        </td>
                                        @endfor

                                        </tr>
                                        @endfor

                            </tbody>

                        </table>

                    </div>
                    <div class="break-after-page"></div>
                    {{-- HALAMAN MATERI --}}
                    {{-- HEADER --}}
                    <div class="mt-4">

                        <div class="flex items-center gap-4">

                            <img
                                src="{{ asset('asset/images/logo.png') }}"
                                class="w-20 h-20 object-contain">

                            <div class="flex-1 text-center text-green-900">

                                <h2 class="text-xl font-extrabold uppercase tracking-wide">
                                    Madrasah Diniyah {{ $kelasmi->jenjang }} Wahidiyah
                                </h2>

                                <h1 class="text-3xl font-black uppercase tracking-wider">
                                    Satuan Acara Pembelajaran
                                </h1>

                                <p class="text-sm font-semibold uppercase mt-1">
                                    Tahun Pelajaran {{ $kelasmi->periode }}
                                    {{ $kelasmi->ket_semester }}
                                </p>

                            </div>

                        </div>

                        <hr class="border-2 border-green-700 my-3">

                        {{-- INFORMASI --}}
                        <table class="w-full text-sm text-green-900 mb-4">
                            <tbody>

                                <tr>
                                    <td class="w-40 font-semibold">Kelas</td>
                                    <td class="w-3">:</td>
                                    <td>{{ $kelasmi->nama_kelas }}</td>

                                    <td class="w-44 font-semibold">Mata Pelajaran</td>
                                    <td class="w-3">:</td>
                                    <td>{{ $mapel->mapel }}</td>
                                </tr>

                                <tr>
                                    <td class="font-semibold">Guru Mapel</td>
                                    <td>:</td>
                                    <td>{{ $mapel->nama_guru }}</td>

                                    <td class="font-semibold">Hari</td>
                                    <td>:</td>
                                    <td class="capitalize">
                                        {{ strtolower($mapel->hari) }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                    {{-- TABEL MATERI --}}
                    <div class="grid grid-cols-2 gap-4">

                        {{-- KOLOM KIRI --}}
                        <div class="overflow-hidden rounded-lg border border-green-700">

                            <table class="w-full text-sm border-collapse">

                                <thead class="bg-green-100 text-green-900">

                                    <tr>

                                        <th class="border border-green-700 w-10 py-2">
                                            No
                                        </th>

                                        <th class="border border-green-700 w-40">
                                            Hari / Tanggal
                                        </th>

                                        <th class="border border-green-700 w-10">
                                            Pert.
                                        </th>

                                        <th class="border border-green-700">
                                            Materi
                                        </th>

                                        <th class="border border-green-700">
                                            Rincian
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @for($i=1;$i<=9;$i++)

                                        <tr class="text-green-900">

                                        <td class="border border-green-700 text-center py-4">
                                            {{ $i }}
                                        </td>

                                        <td class="border border-green-700"></td>

                                        <td class="border border-green-700 text-center font-semibold">
                                            {{ $i }}
                                        </td>

                                        <td class="border border-green-700"></td>

                                        <td class="border border-green-700"></td>

                                        </tr>

                                        @endfor

                                </tbody>

                            </table>

                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="overflow-hidden rounded-lg border border-green-700">

                            <table class="w-full text-sm border-collapse">

                                <thead class="bg-green-100 text-green-900">

                                    <tr>

                                        <th class="border border-green-700 w-10 py-2">
                                            No
                                        </th>

                                        <th class="border border-green-700 w-40">
                                            Hari / Tanggal
                                        </th>

                                        <th class="border border-green-700 w-10">
                                            Pert.
                                        </th>

                                        <th class="border border-green-700">
                                            Materi
                                        </th>

                                        <th class="border border-green-700">
                                            Rincian
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @for($i=10;$i<=18;$i++)

                                        <tr class="text-green-900">

                                        <td class="border border-green-700 text-center py-4">
                                            {{ $i }}
                                        </td>

                                        <td class="border border-green-700"></td>

                                        <td class="border border-green-700 text-center font-semibold">
                                            {{ $i }}
                                        </td>

                                        <td class="border border-green-700"></td>

                                        <td class="border border-green-700"></td>

                                        </tr>

                                        @endfor

                                </tbody>

                            </table>

                        </div>

                    </div>
                    <div class="break-after-page"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</x-app-layout>