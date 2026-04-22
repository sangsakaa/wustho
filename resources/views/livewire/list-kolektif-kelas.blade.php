<div class="p-4 space-y-4">

    <!-- 🔹 HEADER / FILTER -->
    <div class="bg-white p-4 rounded-xl shadow-sm border">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

            <!-- LEFT -->
            <div class="flex flex-wrap items-center gap-2 w-full">

                <input type="search"
                    wire:model.debounce.500ms="search"
                    placeholder="Cari nama siswa..."
                    class="border rounded-lg px-3 py-2 w-full sm:w-64 focus:ring-2 focus:ring-blue-500">

                <select wire:model="perPage"
                    class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>

                <select wire:model="angkatan"
                    class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Angkatan</option>
                    @foreach($listAngkatan as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>

                <!-- BACK BUTTON -->
                <a href="/pesertakelas/{{ $kelasmi }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>

                    Kembali
                </a>
            </div>

            <!-- RIGHT -->
            <div class="text-sm text-gray-600 whitespace-nowrap">
                Terpilih:
                <span class="font-semibold text-blue-600">
                    {{ count($selected) }}
                </span>
            </div>

        </div>
    </div>

    <!-- 🔹 FORM -->
    <form action="/pesertakolektif" method="POST" class="space-y-3">
        @csrf

        <!-- SELECT KELAS -->
        <div class="bg-white p-4 rounded-xl shadow-sm border flex flex-col sm:flex-row gap-2 items-center">

            <select name="kelasmi_id"
                class="border rounded-lg px-3 py-2 w-full sm:w-1/3 focus:ring-2 focus:ring-blue-500"
                required>

                <option value="">-- Pilih Kelas --</option>

                @foreach($kelas as $k)
                <option value="{{ $k->id }}"
                    {{ (string)$k->id === (string)($kelasmi->id ?? $kelasmi) ? 'selected' : '' }}>
                    {{ $k->nama_kelas }} | {{ $k->periode }} | {{ $k->ket_semester }}
                </option>
                @endforeach

            </select>

            <button
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm hover:shadow transition">
                Kolektif
            </button>

        </div>

        <!-- 🔹 TABLE -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr class="text-gray-600">
                            <th class="p-3 text-center">
                                <input type="checkbox" wire:model="selectAll">
                            </th>
                            <th class="p-3 text-center">No</th>
                            <th class="p-3 text-center">NIS</th>
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-center">JK</th>
                            <th class="p-3 text-center">Asrama</th>
                            <th class="p-3 text-center">Angkatan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($Datasiswa as $item)
                        <tr wire:key="siswa-{{ $item->id }}"
                            class="border-t hover:bg-blue-50 transition">

                            <td class="text-center p-2">
                                <input type="checkbox"
                                    value="{{ $item->id }}"
                                    wire:model="selected"
                                    name="siswa[]"
                                    @checked(in_array($item->id, $selected))>
                            </td>

                            <td class="text-center">
                                {{ $Datasiswa->firstItem() + $loop->index }}
                            </td>

                            <td class="text-center">
                                {{ $item->nis }}
                            </td>

                            <td class="py-2 capitalize">
                                {{ strtolower($item->nama_siswa) }}
                            </td>

                            <td class="text-center">
                                {{ $item->jenis_kelamin }}
                            </td>

                            <td class="text-center">
                                {{ $item->nama_asrama }}
                            </td>

                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('Y') }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">
                                Tidak ada data
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

        <!-- 🔹 PAGINATION -->
        <div class="pt-2">
            {{ $Datasiswa->links() }}
        </div>

    </form>

</div>