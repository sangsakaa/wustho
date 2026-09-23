<x-app-layout>

    <x-slot name="header">

        @section('title', '| Surat Pernyataan Kehadiran')

        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Surat Pernyataan Kehadiran
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Rekap siswa dengan tingkat kehadiran kurang dari 75%.
            </p>
        </div>

    </x-slot>


    {{-- =========================================================
        STYLE CETAK
    ========================================================== --}}

    <style>
        .surat-page {
            min-height: 260mm;
            page-break-after: always;
        }

        .surat-page:last-child {
            page-break-after: auto;
        }

        @media print {

            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .surat-page {
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                page-break-after: always;
            }

            .surat-page:last-child {
                page-break-after: auto;
            }

            @page {
                size: A4 portrait;
                margin: 18mm;
            }

        }
    </style>


    {{-- =========================================================
        JAVASCRIPT
    ========================================================== --}}

    <script>
        function printContent() {
            window.print();
        }
    </script>


    {{-- =========================================================
        CONTAINER
    ========================================================== --}}

    <div class="space-y-5 px-4 py-5">


        {{-- =====================================================
            TOOLBAR
        ====================================================== --}}

        <div
            class="no-print rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <div
                class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">


                {{-- FILTER --}}

                <form
                    action="{{ url('/blanko-pernyataan') }}"
                    method="GET"
                    class="flex w-full flex-col gap-3 sm:flex-row">

                    <select
                        name="kelasmi_id"
                        class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <option value="">
                            -- Semua Kelas --
                        </option>

                        @foreach ($dataKelasMi as $kelas)

                        <option
                            value="{{ $kelas->id }}"
                            @selected($kelasmi?->id == $kelas->id)>

                            {{ $kelas->nama_kelas }}
                            -
                            {{ $kelas->periode }}
                            {{ $kelas->ket_semester }}

                        </option>

                        @endforeach

                    </select>


                    {{-- TAMPILKAN --}}

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">

                        Tampilkan

                    </button>


                    {{-- CETAK --}}

                    <button
                        type="button"
                        onclick="printContent()"
                        class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">

                        Cetak

                    </button>


                    {{-- BATAL --}}

                    <a
                        href="{{ url('/pengaturan') }}"
                        class="inline-flex items-center justify-center rounded-xl bg-red-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-600">

                        Batal

                    </a>

                </form>


                {{-- TOTAL --}}

                <div
                    class="shrink-0 rounded-xl bg-red-50 px-4 py-3 text-sm text-slate-600">

                    Kehadiran
                    <span class="font-semibold">
                        &lt; 75%
                    </span>

                    :

                    <span class="font-bold text-red-600">
                        {{ $totalCountBelow75 }}
                    </span>

                    siswa

                </div>

            </div>

        </div>


        {{-- =====================================================
            PRINT AREA
        ====================================================== --}}

        <div id="print-area">


            @forelse ($dataAbsensi as $index => $absensi)


            {{-- =================================================
                    SURAT
                ================================================== --}}

            <div
                class="surat-page mb-6 rounded-2xl border border-slate-200 bg-white p-10 shadow-sm">


                {{-- =================================================
                        KOP SURAT
                    ================================================== --}}

                <div class="text-center">

                    <p class="text-sm font-medium tracking-wide">
                        PONDOK PESANTREN KEDUNGLO AL MUNADHDHOROH
                    </p>

                    <h1 class="mt-1 text-lg font-bold uppercase">
                        MADRASAH DINIYAH
                        {{ $absensi->jenjang }}
                        WAHIDIYAH
                    </h1>

                    <p class="mt-1 text-sm">
                        Jl. KH. Wachid Hasyim Kota Kediri
                        64114 Jawa Timur
                    </p>


                    {{-- GARIS KOP --}}

                    <div class="mt-3 border-t-2 border-black"></div>

                    <div class="border-b border-black pt-1"></div>


                    {{-- JUDUL --}}

                    <h2 class="mt-5 text-lg font-bold uppercase underline">
                        Surat Pernyataan
                    </h2>

                </div>


                {{-- =================================================
                        IDENTITAS
                    ================================================== --}}

                <div class="mt-8 text-sm leading-7">

                    <p>
                        Yang bertanda tangan di bawah ini:
                    </p>


                    <table class="mt-4 mb-6">

                        <tbody>

                            <tr>

                                <td class="w-40 align-top">
                                    Nama
                                </td>

                                <td>
                                    :
                                    <span class="font-semibold">
                                        {{ $absensi->nama_siswa }}
                                    </span>
                                </td>

                            </tr>


                            <tr>

                                <td class="align-top">
                                    Kelas / Asrama
                                </td>

                                <td>
                                    :
                                    {{ $absensi->nama_kelas }}
                                    /
                                    {{ $absensi->nama_asrama ?? '-' }}
                                </td>

                            </tr>

                        </tbody>

                    </table>


                    {{-- =================================================
                            PERNYATAAN
                        ================================================== --}}

                    <p class="text-justify">
                        Dengan ini saya menyatakan sanggup untuk
                        meningkatkan kedisiplinan, kehadiran, dan
                        kepatuhan terhadap seluruh tata tertib
                        Madrasah Diniyah Wahidiyah sebagai syarat
                        mengikuti ujian akhir semester.
                    </p>


                    {{-- =================================================
                            POIN PERNYATAAN
                        ================================================== --}}

                    <div class="mt-5 ml-6">

                        <ol class="list-decimal space-y-2">

                            <li>
                                Hadir mengikuti kegiatan belajar
                                sesuai jadwal.
                            </li>

                            <li>
                                Menjaga kedisiplinan dan tata tertib
                                madrasah.
                            </li>

                            <li>
                                Tidak mengulangi pelanggaran
                                kehadiran.
                            </li>

                            <li>
                                Aktif dalam kegiatan pembelajaran.
                            </li>

                            <li>
                                Siap menerima sanksi apabila
                                melanggar komitmen.
                            </li>

                        </ol>

                    </div>


                    {{-- =================================================
                            DETAIL KEHADIRAN
                        ================================================== --}}

                    <div class="mt-8">

                        <h3 class="mb-3 font-semibold">
                            Detail Kehadiran
                        </h3>


                        <table
                            class="w-full border-collapse border border-black text-sm">

                            <thead>

                                <tr class="bg-slate-100">

                                    <th class="border border-black p-2">
                                        Hadir
                                    </th>

                                    <th class="border border-black p-2">
                                        Izin
                                    </th>

                                    <th class="border border-black p-2">
                                        Sakit
                                    </th>

                                    <th class="border border-black p-2">
                                        Alfa
                                    </th>

                                    <th class="border border-black p-2">
                                        Persentase
                                    </th>

                                    <th class="border border-black p-2">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <tr class="text-center">

                                    <td class="border border-black p-2">
                                        {{ $absensi->hadir ?: '-' }}
                                    </td>

                                    <td class="border border-black p-2">
                                        {{ $absensi->izin ?: '-' }}
                                    </td>

                                    <td class="border border-black p-2">
                                        {{ $absensi->sakit ?: '-' }}
                                    </td>

                                    <td class="border border-black p-2">
                                        {{ $absensi->alfa ?: '-' }}
                                    </td>

                                    <td
                                        class="border border-black p-2 font-bold text-red-600">

                                        {{ number_format($absensi->persentase, 2) }}%

                                    </td>

                                    <td class="border border-black p-2">

                                        <span
                                            class="font-semibold text-red-600">

                                            Belum Tuntas

                                        </span>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>


                    {{-- =================================================
                            PENUTUP
                        ================================================== --}}

                    <p class="mt-6 text-justify">

                        Demikian surat pernyataan ini saya buat dengan
                        sadar dan tanpa paksaan dari pihak manapun
                        sebagai syarat mengikuti

                        <span class="font-semibold underline">

                            Ujian Akhir Semester
                            {{ $periode->ket_semester }}
                            Periode {{ $periode->periode }}

                        </span>.

                    </p>

                </div>


                {{-- =================================================
                        TANDA TANGAN
                    ================================================== --}}

                <div
                    class="mt-16 grid grid-cols-3 gap-8 text-center text-sm">


                    {{-- KEPALA MADRASAH --}}

                    <div>

                        <p>
                            Kepala Madrasah
                        </p>

                        <div class="h-24"></div>

                        <p class="font-semibold underline">

                            {{ $namaKepalaMadrasah }}

                        </p>

                    </div>


                    {{-- PENGURUS --}}

                    <div>

                        <p>
                            Pengurus Pondok
                        </p>

                        <div class="h-24"></div>

                        <p class="font-semibold">
                            __________________
                        </p>

                    </div>


                    {{-- SISWA --}}

                    <div>

                        <p>
                            Kediri,
                            ........................
                        </p>

                        <p>
                            Hormat Saya,
                        </p>

                        <div class="h-24"></div>

                        <p class="font-semibold capitalize">

                            {{ strtolower($absensi->nama_siswa) }}

                        </p>

                    </div>

                </div>

            </div>


            @empty


            {{-- =================================================
                    DATA KOSONG
                ================================================== --}}

            <div
                class="no-print rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">

                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50">

                    <svg
                        class="h-7 w-7 text-emerald-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7" />

                    </svg>

                </div>


                <h3 class="mt-4 text-lg font-bold text-slate-700">

                    Tidak ada siswa dengan kehadiran
                    kurang dari 75%.

                </h3>

                <p class="mt-2 text-sm text-slate-500">

                    Semua siswa pada periode atau kelas yang
                    dipilih memenuhi batas kehadiran.

                </p>

            </div>


            @endforelse

        </div>

    </div>

</x-app-layout>