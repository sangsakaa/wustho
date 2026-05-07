<x-app-layout>
    <x-slot name="header">
        @section('title', '| Surat Pernyataan Kehadiran')

        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Surat Pernyataan Kehadiran
            </h2>
            <p class="text-sm text-slate-500">
                Rekap siswa dengan kehadiran kurang dari 75%
            </p>
        </div>
    </x-slot>

    <style>
        .page-break {
            page-break-after: always;
        }

        .surat-page {
            min-height: 270mm;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .surat-page {
                box-shadow: none !important;
                border: none !important;
                margin: 0;
                padding: 0;
            }

            @page {
                size: A4 portrait;
                margin: 18mm;
            }
        }
    </style>

    <script>
        function printContent() {
            window.print();
        }
    </script>

    <div class="py-4 px-4 space-y-4">

        {{-- TOOLBAR --}}
        <div class="no-print bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <form action="/blanko-pernyataan" method="get"
                    class="flex flex-col md:flex-row gap-3 w-full">

                    <select name="kelasmi_id"
                        class="border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($dataKelasMi as $kelas)
                        <option value="{{ $kelas->id }}"
                            {{ $kelasmi?->id == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }} - {{ $kelas->periode }}
                            {{ $kelas->ket_semester }}
                        </option>
                        @endforeach
                    </select>

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium">
                        Tampilkan
                    </button>

                    <button type="button"
                        onclick="printContent()"
                        class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-xl text-sm font-medium">
                        Cetak
                    </button>

                    <a href="/pengaturan"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-medium text-center">
                        Batal
                    </a>
                </form>

                <div class="text-sm text-slate-600">
                    Total Kehadiran &lt; 75% :
                    <span class="font-bold text-red-600">
                        {{ $totalCountBelow75 }}
                    </span>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div id="print-area">

            @forelse ($dataAbsensi as $absensi)
            <div class="surat-page bg-white rounded-2xl shadow-sm border border-slate-200 p-10 mb-6">

                {{-- HEADER --}}
                <div class="text-center mb-8">
                    <p class="text-sm tracking-wide">
                        PONDOK PESANTREN KEDUNGLO AL MUNADHDHOROH
                    </p>

                    <h1 class="text-lg font-bold uppercase">
                        MADRASAH DINIYAH {{ $absensi->jenjang }} WAHIDIYAH
                    </h1>

                    <p class="text-sm">
                        Jl. KH. Wachid Hasyim Kota Kediri 64114 Jawa Timur
                    </p>

                    <div class="border-t-2 border-b border-black mt-3 pt-1 pb-1"></div>

                    <h2 class="mt-4 font-bold text-lg underline uppercase">
                        Surat Pernyataan
                    </h2>
                </div>

                {{-- BODY --}}
                <div class="text-sm leading-7">

                    <p>Yang bertanda tangan di bawah ini:</p>

                    <table class="mt-4 mb-6">
                        <tr>
                            <td class="w-40">Nama</td>
                            <td>: {{ $absensi->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td>Kelas / Asrama</td>
                            <td>: {{ $absensi->nama_kelas }} / {{ $absensi->nama_asrama ?? '-' }}</td>
                        </tr>
                    </table>

                    <p class="text-justify">
                        Dengan ini saya menyatakan sanggup untuk meningkatkan
                        kedisiplinan, kehadiran, dan kepatuhan terhadap seluruh
                        tata tertib Madrasah Diniyah Wahidiyah sebagai syarat
                        mengikuti ujian akhir semester.
                    </p>

                    <div class="mt-5 ml-6">
                        <ol class="list-decimal space-y-2">
                            <li>Hadir mengikuti kegiatan belajar sesuai jadwal.</li>
                            <li>Menjaga kedisiplinan dan tata tertib madrasah.</li>
                            <li>Tidak mengulangi pelanggaran kehadiran.</li>
                            <li>Aktif dalam kegiatan pembelajaran.</li>
                            <li>Siap menerima sanksi apabila melanggar komitmen.</li>
                        </ol>
                    </div>

                    {{-- DETAIL KEHADIRAN --}}
                    <div class="mt-8">
                        <h3 class="font-semibold mb-3">Detail Kehadiran</h3>

                        <table class="w-full border border-black text-sm">
                            <thead>
                                <tr class="bg-slate-100">
                                    <th class="border border-black p-2">Hadir</th>
                                    <th class="border border-black p-2">Izin</th>
                                    <th class="border border-black p-2">Sakit</th>
                                    <th class="border border-black p-2">Alfa</th>
                                    <th class="border border-black p-2">Persentase</th>
                                    <th class="border border-black p-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td class="border border-black p-2">{{ $absensi->hadir ?: '-' }}</td>
                                    <td class="border border-black p-2">{{ $absensi->izin ?: '-' }}</td>
                                    <td class="border border-black p-2">{{ $absensi->sakit ?: '-' }}</td>
                                    <td class="border border-black p-2">{{ $absensi->alfa ?: '-' }}</td>
                                    <td class="border border-black p-2 font-semibold text-red-600">
                                        {{ $absensi->persentase }}%
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

                    <p class="mt-6 text-justify">
                        Demikian surat pernyataan ini saya buat dengan sadar
                        dan tanpa paksaan dari pihak manapun sebagai syarat
                        mengikuti
                        <span class="font-semibold underline">
                            Ujian Akhir Semester {{ $periode->ket_semester }}
                            Periode {{ $periode->periode }}
                        </span>.
                    </p>
                </div>

                {{-- SIGNATURE --}}
                <div class="grid grid-cols-3 gap-8 mt-16 text-sm text-center">

                    <div>
                        <p>Kepala Madrasah</p>
                        <div class="h-24"></div>
                        <p class="font-semibold">
                            Muh. Bahrul Ulum, S.H.
                        </p>
                    </div>

                    <div>
                        <p>Pengurus Pondok</p>
                        <div class="h-24"></div>
                        <p>__________________</p>
                    </div>

                    <div>
                        <p>Kediri, .......................</p>
                        <p>Hormat Saya,</p>
                        <div class="h-24"></div>
                        <p class="font-semibold capitalize">
                            {{ strtolower($absensi->nama_siswa) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="page-break"></div>
            @empty
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-10 text-center">
                <h3 class="text-lg font-semibold text-slate-700">
                    Tidak ada siswa dengan kehadiran kurang dari 75%
                </h3>
            </div>
            @endforelse

        </div>
    </div>
</x-app-layout>