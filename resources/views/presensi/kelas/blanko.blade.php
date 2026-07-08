<x-app-layout>
    <x-slot name="header">
        @if($kelasmi)
        @section('title', '| Presensi Kelas : '. $kelasmi->nama_kelas)
        @endif

        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
            {{ __('Blanko Presensi Kelas') }}
        </h2>
    </x-slot>

    {{-- FILTER --}}
    <div class="my-3">
        <div class="bg-white dark:bg-dark-bg rounded-xl shadow border border-gray-200 dark:border-gray-700">

            <div class="px-4 py-3 flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">

                <form action="/absensikelas/blanko" method="get"
                    class="flex flex-col sm:flex-row gap-2 w-full">

                    <input
                        type="month"
                        name="bulan"
                        value="{{ $bulan->format('Y-m') }}"
                        class="rounded-lg border-gray-300 dark:border-gray-600 py-2 dark:bg-dark-bg dark:text-white focus:ring-purple-500 focus:border-purple-500">

                    <select
                        name="kelasmi_id"
                        class="w-full sm:w-72 rounded-lg border-gray-300 dark:border-gray-600 py-2 dark:bg-dark-bg dark:text-white focus:ring-purple-500 focus:border-purple-500"
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
                        Pilih Blanko
                    </button>

                </form>

                <button
                    onclick="printContent('blanko')"
                    class="bg-red-600 hover:bg-purple-600 transition duration-200 text-white px-5 py-2 rounded-lg shadow text-sm font-medium w-full sm:w-40">
                    Cetak
                </button>
                <a
                    href="{{ route('absensikelas.blanko.pdf', [
        'kelasmi_id' => request('kelasmi_id'),
        'bulan' => request('bulan')
    ]) }}"
                    target="_blank"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow text-sm">
                    PDF
                </a>

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
        table {
            border-collapse: collapse;
        }

        @media print {
            body {
                background: white;
            }
        }
    </style>

    @if($kelasmi)

    <div class="py-2 px-2">
        <div class="bg-white dark:bg-dark-bg " id="blanko">
            <div class="py-3 px-3">
                <div class="overflow-x-auto ">
                    {{-- HEADER --}}
                    <div class="flex items-center gap-3 text-center text-green-900 tracking-wide">
                        <div>
                            <img
                                src="{{ asset('asset/images/logo.png') }}"
                                alt="logo"
                                width="95"
                                class="mb-1">
                        </div>
                        <div class="w-full">
                            @if($kelasmi->jenjang === "Wustho")
                            <div class="grid justify-items-center">
                                <p class="text-lg uppercase font-semibold tracking-widest">
                                    departemen pendidikan diniyah wahidiyah
                                </p>
                                <p class="font-bold text-3xl uppercase">
                                    MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                                </p>
                                <p class="font-semibold uppercase tracking-widest text-sm">
                                    TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                                </p>
                            </div>
                            @elseif($kelasmi->jenjang === "Ulya")
                            <p class="text-lg uppercase font-semibold tracking-widest">
                                departemen pendidikan diniyah wahidiyah
                            </p>
                            <p class="font-bold text-3xl uppercase">
                                MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                            </p>
                            <p class="font-semibold uppercase tracking-widest text-sm">
                                TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                            </p>
                            @elseif($kelasmi->jenjang === "Ula")
                            <p class="text-lg uppercase font-semibold tracking-widest">
                                departemen pendidikan diniyah wahidiyah
                            </p>
                            <p class="font-bold text-3xl uppercase">
                                MADRASAH DINIYAH {{$kelasmi->jenjang}} WAHIDIYAH
                            </p>
                            <p class="font-semibold uppercase tracking-widest text-sm">
                                TAHUN PELAJARAN {{$kelasmi->periode}} {{$kelasmi->ket_semester}}
                            </p>
                            @endif
                        </div>
                    </div>
                    <hr class="border-b-2 border-green-900 mt-2">
                    <hr class="mt-0.5 border-b border-green-900">
                    {{-- INFO --}}
                    <div class="uppercase grid grid-cols-1 md:grid-cols-3 gap-2 py-2">
                        <div class="text-green-900 text-xl md:text-2xl font-bold">
                            Bulan : {{ $bulan->monthName }}
                        </div>
                        <div class="flex justify-center gap-3 text-green-900 font-semibold text-sm md:text-base">
                            <div class="py-1 px-3 rounded-lg bg-green-100 border border-green-300">
                                Putra : {{$dataSiswa->where('jenis_kelamin','L')->count()}}
                            </div>

                            <div class="py-1 px-3 rounded-lg bg-pink-100 border border-pink-300">
                                Putri : {{$dataSiswa->where('jenis_kelamin','P')->count()}}
                            </div>

                        </div>

                        <div class="text-right text-xl md:text-2xl text-green-900 font-bold">
                            Kelas : {{ $kelasmi->nama_kelas }}
                        </div>

                    </div>

                    <hr class="border-b border-green-600">

                    {{-- TABEL --}}
                    <div class="overflow-x-auto mt-2 rounded-lg border border-green-700">

                        <table class="table-fixed w-full text-green-900">

                            <thead class="border border-b-2 border-green-600">

                                <tr class="border border-green-600 text-xs sm:text-sm bg-green-50 dark:bg-gray-800">

                                    <th class="border border-green-600 px-1 w-8" rowspan="2">
                                        No
                                    </th>

                                    <th class="border border-green-600 px-1 w-1/5" rowspan="2">
                                        Nama Siswa
                                    </th>

                                    <th class="border border-green-600 px-1 w-9" rowspan="2">
                                        Kls
                                    </th>

                                    <th
                                        class="border border-green-600 px-1"
                                        colspan="{{ $periodeBulan->count() }}">
                                        Tanggal
                                    </th>

                                </tr>

                                <tr class="border border-green-600 text-xs sm:text-sm bg-green-100 dark:bg-gray-700">

                                    @foreach ($periodeBulan as $hari)

                                    <th class="border border-green-600 {{ $hari->isThursday() ? 'bg-green-600 text-white' : '' }}">
                                        {{ $hari->day }}
                                    </th>

                                    @endforeach

                                </tr>

                            </thead>

                            <tbody class="text-sm">

                                @foreach ($dataSiswa as $siswa)

                                <tr class="border border-green-600 even:bg-green-50 dark:even:bg-gray-800 text-xs sm:text-sm">

                                    <td class="border border-green-600 text-center px-1">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border border-green-600 px-2 py-1 text-xs capitalize">
                                        {{ strtolower($siswa->nama_siswa) }}
                                    </td>

                                    <td class="border border-green-600 text-center">
                                        {{ $siswa->nama_kelas }}
                                    </td>

                                    @foreach ($periodeBulan as $hari)

                                    <td class="border border-green-600 {{ $hari->isThursday() ? 'bg-green-600' : '' }}">
                                    </td>

                                    @endforeach

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @endif

</x-app-layout>