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

        <div class="bg-white dark:bg-dark-bg rounded-xl shadow border border-gray-200 dark:border-gray-700 px-3 py-2">

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
                    <div class="overflow-x-auto rounded-lg border border-green-700">

                        <table class="table-fixed w-full text-green-800">

                            <thead class="bg-green-50 dark:bg-gray-800">

                                <tr class="border border-green-600 text-xs sm:text-sm">

                                    <th class="border border-green-600 px-1 w-8" rowspan="2">
                                        NO
                                    </th>

                                    <th class="border border-green-600 px-1 w-1/5">
                                        TANGGAL KBM
                                    </th>

                                    <th class="border border-green-600 px-1 text-xs" colspan="2">
                                        NILAI TUGAS
                                    </th>

                                    <?php
                                    $hari = strtolower($mapel->hari);
                                    $tanggal_awal = Illuminate\Support\Carbon::parse($kelasmi->tanggal_mulai);

                                    switch ($hari) {
                                        case 'jumat':
                                            $tanggal_awal->modify('next friday');
                                            break;
                                        case 'sabtu':
                                            $tanggal_awal->modify('next saturday');
                                            break;
                                        case 'minggu':
                                            $tanggal_awal->modify('next sunday');
                                            break;
                                        case 'senin':
                                            $tanggal_awal->modify('next monday');
                                            break;
                                        case 'selasa':
                                            $tanggal_awal->modify('next tuesday');
                                            break;
                                        case 'rabu':
                                            $tanggal_awal->modify('next wednesday');
                                            break;
                                    }

                                    $jumlah_hari = 17;

                                    if ($tanggal_awal instanceof Illuminate\Support\Carbon) {

                                        for ($hari = 0; $hari < $jumlah_hari; $hari++) {

                                            echo '
                                                <th class="border border-green-600 px-1 text-xs bg-green-50">
                                                </th>
                                            ';

                                            $tanggal_awal->modify('+7 days');
                                        }
                                    }
                                    ?>

                                    <th></th>

                                </tr>

                                <tr class="border border-green-600 text-xs sm:text-sm bg-green-100 dark:bg-gray-700">

                                    <th class="border border-green-600 px-1">
                                        NAMA
                                    </th>

                                    <th class="border border-green-600 px-1">
                                        1
                                    </th>

                                    <th class="border border-green-600 px-1">
                                        2
                                    </th>

                                    @for ($i = 1; $i <= 18; $i++)
                                        <th class="border border-green-600 px-1 text-xs">
                                        PERT {{ $i }}
                                        </th>
                                        @endfor

                                </tr>

                            </thead>

                            <tbody class="text-sm">

                                @foreach ($dataSiswa as $siswa)

                                <tr class="border border-green-600 text-xs sm:text-sm even:bg-gray-50 dark:even:bg-gray-800">

                                    <td class="border border-green-600 text-center px-1 text-xs">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border border-green-600 px-2 py-2 text-xs capitalize">
                                        {{ strtolower($siswa->nama_siswa) }}
                                    </td>

                                    @for ($i = 0; $i < 20; $i++)
                                        <td class="border border-green-600 px-1">
                                        </td>
                                        @endfor

                                </tr>

                                @endforeach

                                @for ($i = $dataSiswa->count(); $i < 40; $i++)

                                    <tr class="border border-green-600 text-xs sm:text-sm {{ $i % 2 == 0 ? 'bg-gray-50 dark:bg-gray-800' : '' }}">

                                    <td class="border border-green-600 text-center px-1 py-2 h-2 text-xs">
                                        {{$i+1}}
                                    </td>

                                    @for ($x = 0; $x < 21; $x++)
                                        <td class="border border-green-600 px-1 py-2 text-xs capitalize">
                                        </td>
                                        @endfor

                                        </tr>

                                        @endfor

                            </tbody>

                        </table>

                    </div>

                    <div class="break-after-page"></div>

                    {{-- HALAMAN MATERI --}}
                    <div class="mt-3">

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

                    </div>

                    {{-- TABEL MATERI --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">

                        <div class="overflow-x-auto">
                            <table class="mt-1 w-full border text-sm">

                                <thead class="bg-green-100 dark:bg-gray-700">
                                    <tr class="text-green-800">
                                        <th class="border border-green-600 w-5 text-center">No</th>
                                        <th class="border border-green-600">Hari / Tangggal</th>
                                        <th class="border border-green-600 px-1">Pert Ke</th>
                                        <th class="border border-green-600">Materi</th>
                                        <th class="border border-green-600">Rincian</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @for ($i = 1; $i < 10; $i++)

                                        <tr class="text-green-800 even:bg-gray-50 dark:even:bg-gray-800">

                                        <td class="border border-green-600 py-4 text-center">
                                            {{$i}}
                                        </td>

                                        <td class="border border-green-600 w-36"></td>

                                        <td class="border border-green-600 w-5 text-center capitalize font-semibold">
                                            Pert {{$i}}
                                        </td>

                                        <td class="border border-green-600 w-1/4"></td>

                                        <td class="border border-green-600"></td>

                                        </tr>

                                        @endfor

                                </tbody>

                            </table>
                        </div>

                        <div class="overflow-x-auto">

                            <table class="mt-1 w-full border text-sm">

                                <thead class="bg-green-100 dark:bg-gray-700">
                                    <tr class="text-green-800">
                                        <th class="border border-green-600 w-5 text-center">No</th>
                                        <th class="border border-green-600">Hari / Tangggal</th>
                                        <th class="border border-green-600 px-1">Pert Ke</th>
                                        <th class="border border-green-600">Materi</th>
                                        <th class="border border-green-600">Rincian</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @for ($i = 10; $i < 19; $i++)

                                        <tr class="text-green-800 even:bg-gray-50 dark:even:bg-gray-800">

                                        <td class="border border-green-600 py-4 text-center">
                                            {{$i}}
                                        </td>

                                        <td class="border border-green-600 w-36"></td>

                                        <td class="border border-green-600 w-5 text-center capitalize font-semibold">
                                            Pert {{$i}}
                                        </td>

                                        <td class="border border-green-600 w-1/4"></td>

                                        <td class="border border-green-600"></td>

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