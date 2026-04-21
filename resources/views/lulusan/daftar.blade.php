<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Peserta Lulusan')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Data Peserta Lulusan
        </h2>
    </x-slot>

    <div class="p-4 space-y-4" x-data="{ open: false, deleteId: null, deleteName: '' }">

        <!-- ACTION BUTTON -->
        <div class="flex flex-wrap gap-2">
            <a href="/kolektif-lulusan/{{ $lulusan->id }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 text-sm">
                + Tambah User
            </a>

            <a href="/lulusan"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 text-sm">
                Kembali
            </a>

            <a href="/blangko-ijazah/{{ $lulusan->id }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 text-sm">
                Cetak Ijazah
            </a>
        </div>
        <div>
            @if (session()->has('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="fixed top-5 right-5 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                {{ session('success') }}
            </div>
            @endif

            @if (session()->has('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="fixed top-5 right-5 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                {{ session('error') }}
            </div>
            @endif
        </div>

        <!-- CARD -->
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="p-4">

                <!-- TABLE -->
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 uppercase text-xs text-gray-600">
                            <tr>
                                <th class="px-3 py-2 w-10 text-center">No</th>
                                <th class="px-3 py-2 text-center">Nomor Ijazah</th>
                                <th class="px-3 py-2 text-left">Nama Peserta</th>
                                <th class="px-3 py-2 text-center">Kelas</th>
                                <th class="px-3 py-2 text-center w-40">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($daftarLulusan as $item)
                            <tr class="border-t hover:bg-gray-50">

                                <td class="px-3 py-2 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-3 py-2 text-center">
                                    <span class="font-medium text-gray-700">
                                        {{ $item->nomor_ijazah ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-3 py-2 capitalize">
                                    {{ strtolower($item->nama_siswa) }}
                                </td>

                                <td class="px-3 py-2 text-center uppercase font-semibold">
                                    {{ $item->nama_kelas }}
                                </td>

                                <td class="px-3 py-2 text-center">
                                    <div class="flex justify-center gap-2">

                                        <!-- DELETE BUTTON -->
                                        <button
                                            @click="
                                                open = true;
                                                deleteId = {{ $item->id }};
                                                deleteName = '{{ $item->nama_siswa }}';
                                            "
                                            class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs">
                                            Hapus
                                        </button>

                                        <!-- SET NOMOR -->
                                        <a href="/reservasi-ijazah/{{ $item->id }}"
                                            class="px-3 py-1 bg-yellow-400 text-xs rounded-md hover:bg-yellow-500">
                                            Nomor
                                        </a>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5"
                                    class="text-center py-4 text-gray-500 italic">
                                    Data peserta lulusan belum tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- MODAL DELETE -->
        <div x-show="open"
            x-transition
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

            <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">

                <h2 class="text-lg font-semibold text-gray-800 mb-2">
                    Konfirmasi Hapus
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    Yakin ingin menghapus data:
                    <span class="font-semibold text-red-600" x-text="deleteName"></span> ?
                </p>

                <div class="flex justify-end gap-2">

                    <!-- CANCEL -->
                    <button
                        @click="open = false"
                        class="px-4 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-500">
                        Batal
                    </button>

                    <!-- CONFIRM DELETE -->
                    <form :action="'/daftar-lulusan/' + deleteId" method="POST">
                        @csrf
                        @method('DELETE')
                        <button
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>
        </div>

    </div>
</x-app-layout>