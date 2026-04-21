<div class="p-4">

    <!-- HEADER -->
    <div class="flex justify-between mb-3">

        <div class="flex gap-2">
            <input type="search"
                wire:model.debounce.500ms="search"
                placeholder="Cari nama siswa..."
                class="border px-3 py-2 rounded">

            <select wire:model="perPage" class="border px-2 py-2 rounded">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
        </div>

        <div class="text-sm text-gray-600">
            Terpilih: <span class="font-bold">{{ count($selected) }}</span>
        </div>
    </div>

    <!-- FORM -->
    <form action="/pesertakolektif" method="POST">
        @csrf

        <div class="flex gap-2 mb-3">
            <select name="kelasmi_id" class="border px-3 py-2 rounded w-full" required>
                <option value="">-- Pilih Kelas --</option>

                @foreach($kelas as $k)
                <option value="{{ $k->id }}" {{ $k->id == ($kelasmi ?? null) ? 'selected' : '' }}>
                    {{ $k->nama_kelas }} | {{ $k->periode }} | {{ $k->ket_semester }}
                </option>
                @endforeach
            </select>

            <button class="bg-blue-600 text-white px-4 rounded">
                Kolektif
            </button>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full text-sm">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-center">
                            <input type="checkbox" wire:model="selectAll">
                        </th>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Asrama</th>
                        <th>Angkatan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($Datasiswa as $item)
                    <tr class="border-t hover:bg-green-50">

                        <td class="text-center">
                            <input type="checkbox"
                                value="{{ $item->id }}"
                                wire:model="selected"
                                name="siswa[]">
                        </td>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="text-center">
                            {{ $item->nis }}
                        </td>

                        <td class=" capitalize py-2">
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
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $Datasiswa->links() }}
        </div>

    </form>

</div>