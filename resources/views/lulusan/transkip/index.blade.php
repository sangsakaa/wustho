<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Transkip')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Data Transkip
        </h2>
    </x-slot>

    <div class="px-3 py-3 space-y-3">

        <!-- MENU -->
        <div class="bg-white shadow-sm rounded-lg p-3 flex flex-wrap gap-2">
            <a href="/periode" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Periode
            </a>
            <a href="/lulusan" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700">
                Data Lulusan
            </a>
        </div>

        <!-- FORM INPUT -->
        <div class="bg-white shadow-sm rounded-lg p-4">
            <form action="/daftar-transkip" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- PERIODE -->
                    <div>
                        <label class="text-sm text-gray-600">Periode Lulusan</label>
                        <select name="periode_id" class="w-full border rounded px-2 py-1">
                            @foreach($dataPeriode as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- MAPEL -->
                    <div>
                        <label class="text-sm text-gray-600">Mata Pelajaran</label>
                        <select name="mapel_id" class="w-full border rounded px-2 py-1">
                            @foreach($dataMapel as $item)
                            <option value="{{ $item->id }}">
                                Kelas {{ $item->kelas }} - {{ $item->mapel }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- JENIS UJIAN -->
                    <div>
                        <label class="text-sm text-gray-600">Jenis Ujian</label>
                        <select name="jenis_ujian_id" class="w-full border rounded px-2 py-1">
                            @foreach($dataJenisUjian as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_ujian }} {{ $item->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- KELAS -->
                    <div>
                        <label class="text-sm text-gray-600">Kelas</label>
                        <select name="kelasmi_id" class="w-full border rounded px-2 py-1">
                            @foreach($kelasMi as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_kelas }} - {{ $item->periode }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- ACTION -->
                <div class="flex justify-between items-center mt-4">
                    <span class="text-xs text-red-500 uppercase">
                        * Data ini wajib diisi oleh bagian kurikulum
                    </span>

                    <button type="submit"
                        class="px-4 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </div>

            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow-sm rounded-lg p-4 overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="border px-2 py-2">No</th>
                        <th class="border px-2 py-2 text-center">Periode</th>
                        <th class="border px-2 py-2 text-center">Kelas</th>
                        <th class="border px-2 py-2 text-center">Jenis Ujian</th>
                        <th class="border px-2 py-2 text-center">Mata Pelajaran</th>
                        <th class="border px-2 py-2 text-center">Jumlah Peserta</th>
                        <th class="border px-2 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dataTranskip as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-2 py-1 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border px-2 py-1 text-center">
                            <a href="/nilai_transkip/{{ $item->id }}" class="text-blue-600 hover:underline">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </a>
                        </td>

                        <td class="border px-2 py-1 text-center">
                            {{ $item->nama_kelas }}
                        </td>

                        <td class="border px-2 py-1 text-center">
                            {{ $item->nama_ujian }}
                        </td>

                        <td class="border px-2 py-1 text-center">
                            Kelas {{ $item->kelas }} - {{ $item->mapel }}
                        </td>

                        <td class="border px-2 py-1 text-center">
                            {{ $item->nilaiTranskip->count()}}
                        </td>

                        <td class="border px-2 py-1 text-center">
                            <form action="/daftar-transkip/{{ $item->id }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                    <x-icons.hapus class="w-4 h-4" />
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-red-500 font-semibold">
                            Belum ada data transkip
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="mt-3">
                {{ $dataTranskip->links() }}
            </div>
        </div>

    </div>
</x-app-layout>