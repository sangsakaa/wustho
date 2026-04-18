<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Peserta Lulusan')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Data Peserta Lulusan
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        <!-- ACTION BUTTON -->
        <div class="flex flex-wrap gap-2">
            <a href="/kolektif-lulusan/{{ $lulusan->id }}"
                class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                + Tambah User
            </a>

            <a href="/lulusan"
                class="px-3 py-1.5 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">
                Kembali
            </a>

            <a href="/blangko-ijazah/{{ $lulusan->id }}"
                class="px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                Cetak Ijazah
            </a>
        </div>

        <!-- CARD -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-4">

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead class="bg-gray-100 uppercase text-xs text-gray-600">
                            <tr>
                                <th class="border px-2 py-2 w-10">No</th>
                                <th class="border px-2 py-2 text-center">Nomor Ijazah</th>
                                <th class="border px-2 py-2 text-left">Nama Peserta</th>
                                <th class="border px-2 py-2 text-center">Kelas</th>
                                <th class="border px-2 py-2 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarLulusan as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-2 py-1 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-2 py-1 text-center">
                                    {{ $item->nomor_ijazah ?? '-' }}
                                </td>

                                <td class="border px-2 py-1 capitalize">
                                    {{ strtolower($item->nama_siswa) }}
                                </td>

                                <td class="border px-2 py-1 text-center uppercase">
                                    {{ $item->nama_kelas }}
                                </td>

                                <td class="border px-2 py-1 text-center">
                                    <div class="flex justify-center gap-1">

                                        <!-- DELETE -->
                                        <form action="/daftar-lulusan/{{ $item->id }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus data {{ $item->nama_siswa }} ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>

                                        <!-- SET NOMOR IJAZAH -->
                                        <a href="/reservasi-ijazah/{{ $item->id }}"
                                            class="px-2 py-1 bg-yellow-400 text-xs rounded hover:bg-yellow-500">
                                            Nomor
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"
                                    class="text-center py-3 text-gray-500 italic">
                                    Data peserta lulusan belum tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>