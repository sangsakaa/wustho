<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail Data Siswa')
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard Detail Siswa
        </h2>
    </x-slot>

    <!-- PROFILE CARD -->
    <div class="px-4 py-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 mb-4">Informasi Siswa</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Nama</p>
                    <p class="font-semibold uppercase">{{ $siswa->nama_siswa }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Tempat, Tanggal Lahir</p>
                    <p class="capitalize">
                        {{ strtolower($siswa->tempat_lahir) }},
                        {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Jenis Kelamin</p>
                    <p>{{ $siswa->jenis_kelamin }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Status Asrama</p>
                    <p>
                        @if($siswa->asramaTerkhir?->asramaSiswa->asrama->nama_asrama)
                        {{ $siswa->asramaTerkhir->asramaSiswa->asrama->nama_asrama }}
                        @else
                        <span class="text-red-500 font-medium">Belum ada</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ACTION BUTTON -->
    <div class="px-4">
        <div class="flex flex-wrap gap-2 mb-4">
            <a href="/siswa"
                class="px-4 py-2 text-sm bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow">
                Kembali
            </a>

            <a href="/nis/{{ $siswa->id }}"
                class="px-4 py-2 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                Nomor Induk
            </a>

            @role('super admin')
            <a href="/biodata/{{ $siswa->id }}"
                class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                Biodata
            </a>

            <a href="/statuspengamal/{{ $siswa->id }}"
                class="px-4 py-2 text-sm bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow">
                Status Pengamal
            </a>

            <a href="/statusanak/{{ $siswa->id }}"
                class="px-4 py-2 text-sm bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow">
                Status Anak
            </a>
            @endrole
        </div>
    </div>

    <!-- TABLE SECTION -->
    <div class="px-4 space-y-6">

        <!-- GRID TABLE -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- KELAS -->
            <div class="bg-white rounded-xl shadow-sm border p-4">
                <h3 class="text-sm font-semibold text-gray-500 mb-3">Riwayat Kelas</h3>

                <div class="overflow-auto">
                    <table class="w-full text-sm border rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="py-2 border">No</th>
                                <th class="border">Periode</th>
                                <th class="border">Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesertakelas as $kelas)
                            <tr class="hover:bg-gray-50">
                                <td class="border text-center py-1">{{ $loop->iteration }}</td>
                                <td class="border text-center">
                                    {{ $kelas->periode }} {{ $kelas->ket_semester }}
                                </td>
                                <td class="border text-center">
                                    {{ $kelas->nama_kelas }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-red-500 py-2">
                                    Data tidak tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ASRAMA -->
            <div class="bg-white rounded-xl shadow-sm border p-4">
                <h3 class="text-sm font-semibold text-gray-500 mb-3">Riwayat Asrama</h3>

                <div class="overflow-auto">
                    <table class="w-full text-sm border rounded-lg overflow-hidden">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="py-2 border">No</th>
                                <th class="border">Periode</th>
                                <th class="border">Asrama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historiAsrama as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border text-center py-1">{{ $loop->iteration }}</td>
                                <td class="border text-center">
                                    {{ $item->periode }} {{ $item->ket_semester }}
                                </td>
                                <td class="border text-center">
                                    {{ $item->nama_asrama }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-red-500 py-2">
                                    Data tidak tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- PRESENSI -->
        <div class="bg-white rounded-xl shadow-sm border p-4">
            <h3 class="text-sm font-semibold text-gray-500 mb-3">Rekap Presensi</h3>

            <div class="overflow-auto">
                <table class="w-full text-sm border rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-600">
                        <tr>
                            <th class="border" rowspan="2">Periode</th>
                            <th class="border" rowspan="2">Sesi</th>
                            <th class="border" colspan="6">Keterangan</th>
                        </tr>
                        <tr>
                            <th class="border">H</th>
                            <th class="border">S</th>
                            <th class="border">I</th>
                            <th class="border">A</th>
                            <th class="border">%H</th>
                            <th class="border">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($PresensiKelas as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border text-center">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </td>
                            <td class="border text-center">
                                {{ $item->count_sesikelas_id }}
                            </td>
                            <td class="border text-center">{{ $item->hadir }}</td>
                            <td class="border text-center">{{ $item->sakit }}</td>
                            <td class="border text-center">{{ $item->izin }}</td>
                            <td class="border text-center">{{ $item->alfa }}</td>
                            <td class="border text-center">
                                {{ number_format($item->presentase_kehadiran,0) }}%
                            </td>
                            <td class="border text-center">
                                @if($item->presentase_kehadiran >= 75)
                                <span class="text-green-600 font-semibold">M</span>
                                @else
                                <span class="text-red-600 font-semibold">TM</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>