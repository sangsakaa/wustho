<x-app-layout>
    <x-slot name="header">
        @section('title',' | NOMINASI')
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-semibold text-gray-800">
                Manajemen Nominasi Ujian
            </h2>
        </div>
    </x-slot>

    <div class="p-4 space-y-4">

        <!-- FORM -->
        <div class="bg-white shadow-sm rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase">
                Form Tambah Nominasi
            </h3>

            <form action="/daftar-seleksi" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <!-- KELAS -->
                    <div>
                        <label class="text-sm font-medium">Kelas</label>
                        <select name="kelasmi_id" required
                            class="w-full mt-1 border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($daftarKelas as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_kelas }} - {{ $item->periode }} {{ $item->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PERIODE -->
                    <div>
                        <label class="text-sm font-medium">Periode Ujian</label>
                        <select name="periode_id" required
                            class="w-full mt-1 border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Periode --</option>
                            @foreach($dataPeriode as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- TANGGAL MULAI -->
                    <div>
                        <label class="text-sm font-medium">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- TANGGAL SELESAI -->
                    <div>
                        <label class="text-sm font-medium">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai"
                            class="w-full mt-1 border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                        Simpan Nominasi
                    </button>
                </div>
            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-3 border-b">
                <h3 class="text-sm font-semibold text-gray-600 uppercase">
                    Daftar Nominasi
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="border px-2 py-2 w-10">No</th>
                            <th class="border px-2 py-2 text-center">Kelas</th>
                            <th class="border px-2 py-2 text-center">Periode</th>
                            <th class="border px-2 py-2 text-center">Tanggal Mulai</th>
                            <th class="border px-2 py-2 text-center">Tanggal Selesai</th>
                            <th class="border px-2 py-2 text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nominasi as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-2 py-1 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                <a href="/daftar-nominasi/{{ $item->id }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $item->nama_kelas }}
                                </a>
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('D MMMM Y') }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('D MMMM Y') }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                <form action="/daftar-seleksi/{{ $item->id }}" method="POST"
                                    onsubmit="return confirm('Hapus nominasi {{ $item->nama_kelas }}?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6"
                                class="text-center py-3 text-gray-500 italic">
                                Belum ada data nominasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->

        </div>

    </div>
</x-app-layout>