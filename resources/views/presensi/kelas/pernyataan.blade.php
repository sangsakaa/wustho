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
        STYLE
    ========================================================== --}}

    <style>
        .surat-page {
            min-height: 260mm;
            page-break-after: always;
        }

        .surat-page:last-child {
            page-break-after: auto;
        }

        /* =========================
           TAMPILAN LAYAR
        ========================== */

        @media screen {
            .surat-page {
                max-width: 210mm;
                margin-left: auto;
                margin-right: auto;
            }
        }

        /* =========================
           TAMPILAN CETAK
        ========================== */

        @media print {

            html,
            body {
                background: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Sembunyikan semua elemen aplikasi */
            body * {
                visibility: hidden !important;
            }

            /* Hanya area surat yang terlihat */
            #print-area,
            #print-area * {
                visibility: visible !important;
            }

            #print-area {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            .surat-page {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 0 !important;

                border: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;

                page-break-after: always !important;
                break-after: page !important;
            }

            .surat-page:last-child {
                page-break-after: auto !important;
                break-after: auto !important;
            }

            table {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            .signature-area {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            @page {
                size: A4 portrait;
                margin: 18mm;
            }
        }
    </style>


    {{-- =========================================================
        JAVASCRIPT CETAK
    ========================================================== --}}

    <script>
        function printContent() {

            // Beri sedikit waktu agar browser menyelesaikan rendering
            setTimeout(function() {
                window.print();
            }, 100);
        }

        // Setelah selesai mencetak, fokus kembali ke halaman
        window.addEventListener('afterprint', function() {
            window.focus();
        });
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


                {{-- =================================================
                    FILTER
                ================================================== --}}

                <form
                    action="{{ url('/blanko-pernyataan') }}"
                    method="GET"
                    class="flex w-full flex-col gap-3 sm:flex-row sm:items-center">

                    {{-- SELECT KELAS --}}

                    <select
                        name="kelasmi_id"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:w-auto">

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


                    {{-- =================================================
                        TAMPILKAN
                    ================================================== --}}

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">

                        {{-- ICON FILTER --}}

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 4h18M6 8h12M10 12h4M11 16h2M12 20v-4" />

                        </svg>

                        Tampilkan

                    </button>


                    {{-- =================================================
                        CETAK
                    ================================================== --}}

                    <button
                        type="button"
                        onclick="printContent()"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">

                        {{-- ICON PRINTER --}}

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 9V3h12v6M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v7H6v-7z" />

                        </svg>

                        Cetak Surat

                    </button>


                    {{-- =================================================
                        BATAL
                    ================================================== --}}

                    <a
                        href="{{ url('/pengaturan') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">

                        {{-- ICON X --}}

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />

                        </svg>

                        Batal

                    </a>

                </form>


                {{-- =================================================
                    TOTAL SISWA
                ================================================== --}}

                <div
                    class="shrink-0 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-sm text-slate-600">

                    <span>
                        Kehadiran
                    </span>

                    <span class="font-semibold text-slate-700">
                        &lt; 75%
                    </span>

                    <span>
                        :
                    </span>

                    <span class="font-bold text-red-600">
                        {{ $totalCountBelow75 }}
                    </span>

                    <span>
                        siswa
                    </span>

                </div>

            </div>

        </div>


        {{-- =====================================================
            AREA CETAK
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

                                        <span class="font-semibold text-red-600">
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
                    class="signature-area mt-16 grid grid-cols-3 gap-8 text-center text-sm">


                    {{-- KEPALA MADRASAH --}}

                    <div>

                        <p>
                            Kepala Madrasah
                        </p>

                        <div class="h-24"></div>

                        <p class="font-semibold underline">

                            {{ $namaKepalaMadrasah ?? '........................................' }}

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