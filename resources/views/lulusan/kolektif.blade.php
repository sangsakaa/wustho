<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Peserta Kolektif')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Data Peserta Kolektif
        </h2>
    </x-slot>

    <div class="px-3 py-3">

        <div class="bg-white shadow-sm rounded-lg p-4">

            <!-- HEADER ACTION -->
            <div class="flex flex-wrap justify-between items-center mb-3 gap-2">
                <div class="flex gap-2">
                    <button type="submit" form="form-kolektif"
                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                        Tambah Kolektif
                    </button>

                    <a href="/daftar-lulusan/{{ $lulusan->id }}"
                        class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Kembali
                    </a>
                </div>

                <div class="text-sm text-gray-600">
                    Total Peserta:
                    <span class="font-semibold text-blue-600">
                        {{ $daftarLulusan->count() }}
                    </span>
                </div>
            </div>

            <!-- FORM -->
            <form id="form-kolektif" action="/kolektif-lulusan/{{ $lulusan->id }}" method="POST">
                @csrf
                <input type="hidden" name="lulusan_id" value="{{ $lulusan->id }}">

                <div class="overflow-x-auto">
                    <table class="w-full border text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="border px-2 py-2 w-10 text-center">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th class="border px-2 py-2 text-center">NIS</th>
                                <th class="border px-2 py-2 text-left">Nama Peserta</th>
                                <th class="border px-2 py-2 text-center">Kelas</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($daftarLulusan as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-2 py-1 text-center">
                                    <input type="checkbox"
                                        class="checkbox-item"
                                        name="pesertakelas[]"
                                        value="{{ $item->id }}">
                                </td>

                                <td class="border px-2 py-1 text-center">
                                    {{ $item->nis }}
                                </td>

                                <td class="border px-2 py-1 capitalize">
                                    {{ strtolower($item->nama_siswa) }}
                                </td>

                                <td class="border px-2 py-1 text-center">
                                    {{ $item->nama_kelas }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4"
                                    class="text-center py-4 text-red-500 font-semibold">
                                    Tidak ada data peserta
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

        </div>
    </div>

    <!-- SCRIPT SELECT ALL -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.checkbox-item');

            // Klik Select All
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
            });

            // Kalau semua checkbox dicentang manual → selectAll ikut aktif
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const allChecked = document.querySelectorAll('.checkbox-item:checked').length === checkboxes.length;
                    selectAll.checked = allChecked;
                });
            });
        });
    </script>

</x-app-layout>