<div class="p-4">

    <!-- FILTER -->
    <div class="flex flex-wrap gap-2 mb-3">

        <input type="search"
            wire:model.debounce.500ms="search"
            placeholder="Cari nama siswa..."
            class="border rounded-md px-3 py-2">

        <select wire:model="perPage" class="border rounded-md px-2 py-2  w-30">
            <option>10</option>
            <option>25</option>
            <option>50</option>
            <option>100</option>
        </select>

        <select wire:model="jenis_kelamin" class="border rounded-md px-2 py-2 w-52">
            <option value="">Semua JK</option>
            <option value="L">L</option>
            <option value="P">P</option>
        </select>

        <select wire:model="angkatan" class="border rounded-md px-2 py-2 w-52">
            <option value="">Semua Angkatan</option>
            @foreach($angkatanList as $tahun)
            <option value="{{ $tahun }}">{{ $tahun }}</option>
            @endforeach
        </select>
        <div class="mb-3">
            <a href="/pesertaasrama/{{$asramasiswa}}"
                class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-md shadow-sm transition">

                <!-- Icon panah kiri -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />
                </svg>

                <span>Kembali</span>
            </a>
        </div>

    </div>


    <div class="flex justify-between items-center mb-3">

        <div class="text-sm text-gray-600">
            @if(count($selected))
            {{ count($selected) }} siswa dipilih
            @endif
        </div>

        <button
            wire:click="kolektif"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow disabled:opacity-50"
            {{ count($selected) == 0 ? 'disabled' : '' }}>
            Kolektif
        </button>

    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="p-2 text-center">
                        <input type="checkbox" wire:model="selectAll">
                    </th>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Jenjang</th>
                    <th>Angkatan</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($Datasiswa as $item)
                <tr class="border-t hover:bg-green-50">

                    <td class="text-center py-2">
                        <input type="checkbox"
                            value="{{ $item->id }}"
                            wire:model="selected">
                    </td>

                    <td class="text-center">
                        {{ ($Datasiswa->currentPage()-1)*$Datasiswa->perPage()+$loop->iteration }}
                    </td>

                    <td>{{ $item->nis }}</td>

                    <td class="capitalize">
                        {{ ($item->nama_siswa) }}
                    </td>

                    <td class="text-center">
                        {{ $item->jenis_kelamin }}
                    </td>

                    <td class="text-center">
                        {{ $item->madrasah_diniyah }}
                    </td>

                    <td class="text-center">
                        {{ date('Y', strtotime($item->tanggal_masuk)) }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
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

</div>