<x-app-layout>
    <x-slot name="header">
        @section('title',' | Daftar Nominasi Kolektif')
        <h2 class="text-xl font-semibold text-gray-800">
            Daftar Nominasi Kolektif
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        <!-- INFO -->
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

        <!-- FORM -->
        <form action="/daftar-nominasi/{{ $title->id }}" method="POST"
            onsubmit="return confirm('Simpan peserta ke nominasi?')">

            @csrf

            <!-- hidden (sekali saja) -->
            <input type="hidden" name="nominasi_id" value="{{ $nominasi->id }}">

            <!-- ACTION -->
            <div class="flex gap-2 mb-2">
                <button type="submit"
                    class="px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                    Simpan
                </button>

                <a href="/daftar-nominasi/{{ $title->id }}"
                    class="px-3 py-1.5 bg-gray-500 text-white rounded-md hover:bg-gray-600 text-sm">
                    Kembali
                </a>
            </div>

            <!-- TABLE -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full border text-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                            <tr>
                                <th class="border px-2 py-2 w-10">No</th>

                                <!-- SELECT ALL -->
                                <th class="border px-2 py-2 text-center w-12">
                                    <input type="checkbox" id="selectAll">
                                </th>

                                <th class="border px-2 py-2 text-left">
                                    Nama Peserta
                                </th>

                                <th class="border px-2 py-2 text-center">
                                    Kelas
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($daftarNominasi as $list)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-2 py-1 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-2 py-1 text-center">
                                    <input type="checkbox"
                                        name="pesertakelas[]"
                                        value="{{ $list->id }}"
                                        class="checkbox-item">
                                </td>

                                <td class="border px-2 py-1 capitalize">
                                    {{ strtolower($list->nama_siswa) }}
                                </td>

                                <td class="border px-2 py-1 text-center uppercase">
                                    {{ $list->nama_kelas }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4"
                                    class="text-center py-3 text-gray-500 italic">
                                    Data peserta tidak tersedia
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

    </div>

    <!-- SCRIPT SELECT ALL -->
    <script>
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.checkbox-item');

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>

</x-app-layout>