<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas Guru')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
            <h2 class="font-semibold text-lg sm:text-xl">
                Presensi Kelas Guru
            </h2>
            <span class="text-gray-500 text-xs sm:text-sm">
                {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, DD MMMM Y') }}
            </span>
        </div>
    </x-slot>

    <!-- TOOLBAR -->
    <div class="p-4">
        <div class="bg-white shadow-sm rounded-2xl p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 border">

            <!-- FILTER -->
            <form action="/sesi-presensi-guru" method="get" class="flex items-center gap-2">
                <input type="date" name="tanggal"
                    value="{{ $tanggal->toDateString() }}"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                    Pilih
                </button>
            </form>

            <!-- MENU -->
            <div class="flex flex-wrap gap-2">
                <form action="/sesi-presensi-guru" method="post">
                    @csrf
                    <input type="hidden" name="tanggal" value="{{ $tanggal->toDateString() }}">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm shadow">
                        + Sesi
                    </button>
                </form>

                <a href="/laporan-harian-guru"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm">
                    Harian
                </a>

                <a href="/laporan-semester-guru"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm">
                    Semester
                </a>

                <a href="/sesi-presensi-guru/rekap"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm">
                    Rekap
                </a>

                <a href="/rekap-kelas-mi"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm">
                    Kelas
                </a>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="p-4">
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <!-- HEADER -->
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-center">Tanggal</th>
                            <th class="px-4 py-3 text-center">Kelas</th>
                            <th class="px-4 py-3 text-center">Periode</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody class="divide-y">
                        @forelse ($sesikelas as $sesi)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 py-3 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ \Carbon\Carbon::parse($sesi->tanggal)->isoFormat('DD MMM Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="/sesi-presensi-guru/{{ $sesi->id }}"
                                    class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium hover:bg-blue-200">
                                    {{ $sesi->nama_kelas }}
                                </a>
                            </td>

                            <td class="px-4 py-3 text-center text-gray-600">
                                {{ $sesi->periode }} {{ $sesi->ket_semester }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($sesi->guru_id)
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $sesi->nama_guru }}
                                </span>
                                @else
                                <span class="inline-block bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-medium">
                                    Belum diisi
                                </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="/sesi-presensi-guru/{{ $sesi->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button
                                        onclick="return confirm('Hapus sesi {{ $sesi->nama_kelas }}?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs shadow">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-400">
                                Tidak ada data sesi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- KETERANGAN -->
    <div class="p-4">
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-sm text-gray-700">
            <p class="font-semibold mb-2">Keterangan:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li>Nilai diambil dari <b>Ulangan Harian dan Ujian Akhir Semester</b></li>
                <li>Jika tidak ada nilai, kosongkan saja</li>
                <li>Peserta kelas harus diinput terlebih dahulu</li>
            </ul>
        </div>
    </div>

</x-app-layout>