<x-app-layout>
    <x-slot name="header">
        @section('title', ' | KHT')

        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                Kartu Hasil Tadris
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-300">
                Rekap nilai akademik siswa
            </p>
        </div>
    </x-slot>

    <div class="p-3 space-y-4">

        {{-- FILTER + ACTION --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl p-4">
            <div class="flex flex-col sm:flex-row gap-3 justify-between">

                <button onclick="printContent('div1')"
                    class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl font-medium transition">
                    <x-icons.print />
                    Print
                </button>

                <form action="/nilai" method="get" class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <select name="kelasmi"
                        class="border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach ($kelasmiSiswa as $kelas)
                        <option value="{{ $kelas->id }}"
                            {{ $kelasmiTerpilih->id == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }} {{ $kelas->periode }} {{ $kelas->ket_semester }}
                        </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-medium transition">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        {{-- PRINT AREA --}}
        <div id="div1" class="bg-white shadow rounded-2xl p-5">

            {{-- TITLE --}}
            <div class="text-center mb-6">
                <h1 class="text-lg sm:text-2xl font-bold uppercase underline">
                    Kartu Hasil Tadris
                </h1>
            </div>

            {{-- BIODATA --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm mb-6">

                <div class="space-y-2">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium">Nomor Induk</span>
                        <span>{{ $user->nis }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium">Nama Siswa</span>
                        <span>{{ Str::limit($user->nama_siswa, 25) }}</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium">Kelas / Semester</span>
                        <span>{{ $title->nama_kelas }} / {{ $title->semester }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="font-medium">Periode</span>
                        <span>{{ $title->periode }} {{ $title->ket_semester }}</span>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm border-collapse">
                    <thead>
                        <tr class="bg-slate-100 dark:bg-purple-600 text-slate-700 dark:text-white">
                            <th class="border p-3">No</th>
                            <th class="border p-3">Pelajaran</th>
                            <th class="border p-3">Kitab</th>
                            <th class="border p-3">Guru</th>
                            <th class="border p-3">NH</th>
                            <th class="border p-3">NU</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataNilai->count())
                        @foreach ($dataNilai as $nilai)
                        <tr class="hover:bg-slate-50">
                            <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border p-2">{{ $nilai->mapel }}</td>
                            <td class="border p-2">{{ $nilai->nama_kitab }}</td>
                            <td class="border p-2">{{ $nilai->nama_guru }}</td>

                            <td class="border p-2 text-center">
                                @if($nilai->nilai_harian == 0)
                                <span class="text-red-500 font-semibold">NaN</span>
                                @else
                                {{ $nilai->nilai_harian }}
                                @endif
                            </td>

                            <td class="border p-2 text-center">
                                @if($nilai->nilai_ujian == 0)
                                <span class="text-red-500 font-semibold">NaN</span>
                                @else
                                {{ $nilai->nilai_ujian }}
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        <tr class="bg-slate-50 font-semibold">
                            <td colspan="4" class="border p-3 text-center">Total Nilai</td>
                            <td class="border p-3 text-center">{{ $dataNilai->sum->nilai_harian }}</td>
                            <td class="border p-3 text-center">{{ $dataNilai->sum->nilai_ujian }}</td>
                        </tr>

                        <tr class="bg-slate-50 font-semibold">
                            <td colspan="4" class="border p-3 text-center">Rata-rata</td>
                            <td class="border p-3 text-center">
                                {{ number_format($dataNilai->avg('nilai_harian'), 2) }}
                            </td>
                            <td class="border p-3 text-center">
                                {{ number_format($dataNilai->avg('nilai_ujian'), 2) }}
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td colspan="6" class="border text-center py-6">
                                <span class="text-red-500 font-semibold">
                                    Tidak ada nilai yang dimasukkan
                                </span>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- NOTE --}}
        <div class="bg-sky-100 rounded-2xl p-4 text-sm">
            <h3 class="font-semibold mb-2">Catatan</h3>
            <p>1. <strong>NaN</strong> = Tidak memiliki nilai atau belum tuntas</p>
        </div>

    </div>

    <script>
        function printContent(el) {
            let restorePage = document.body.innerHTML;
            let printContent = document.getElementById(el).innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = restorePage;
            location.reload();
        }
    </script>
</x-app-layout>