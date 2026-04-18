<x-app-layout>
    <x-slot name="header">
        @section('title',' | NOMINASI')
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="text-xl font-semibold text-gray-800">
                Dashboard Nominasi Peserta
            </h2>
        </div>
    </x-slot>

    <div class="p-4 space-y-4">

        <!-- INFO KELAS -->
        <div class="bg-white shadow-sm rounded-lg p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                <div>
                    <span class="font-semibold">Kelas</span> :
                    {{ $title->nama_kelas }}
                </div>
                <div>
                    <span class="font-semibold">Periode Seleksi</span> :
                    {{ $title->periode }} {{ $title->ket_semester }}
                </div>
            </div>
        </div>

        <!-- ACTION BUTTON -->
        <div class="flex flex-wrap gap-2">
            <a href="/kolektif-daftar-nominasi/{{ $title->id }}"
                class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                + Kolektif
            </a>

            <a href="/daftar-seleksi"
                class="px-3 py-1.5 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">
                Kembali
            </a>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="border px-2 py-2 w-10">No</th>
                            <th class="border px-2 py-2 text-center">Nomor Ujian</th>
                            <th class="border px-2 py-2 text-left">Nama Peserta</th>
                            <th class="border px-2 py-2 text-center">Kelas</th>
                            <th class="border px-2 py-2 text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($daftarNominasi as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-2 py-1 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                {{ $item->nomor_ujian ?? '-' }}
                            </td>

                            <td class="border px-2 py-1 capitalize">
                                {{ strtolower($item->nama_siswa) }}
                            </td>

                            <td class="border px-2 py-1 text-center uppercase">
                                {{ $item->nama_kelas }}
                            </td>

                            <td class="border px-2 py-1 text-center">
                                <form action="/daftar-nominasi/{{ $item->id }}" method="POST"
                                    onsubmit="return confirm('Hapus {{ $item->nama_siswa }} dari nominasi?')">
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
                            <td colspan="5"
                                class="text-center py-3 text-gray-500 italic">
                                Data nominasi belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- OPTIONAL PAGINATION -->

        </div>

    </div>
</x-app-layout>