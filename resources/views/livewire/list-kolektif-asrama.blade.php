<div class="p-6">

    {{-- FILTER CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">

            {{-- Filter --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3 flex-1">

                {{-- Search --}}
                <div>
                    <label class="block mb-1 text-xs font-semibold text-gray-500 uppercase">
                        Cari Siswa
                    </label>

                    <input
                        type="search"
                        wire:model.debounce.500ms="search"
                        placeholder="Cari nama siswa..."
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                {{-- Per Page --}}
                <div>
                    <label class="block mb-1 text-xs font-semibold text-gray-500 uppercase">
                        Tampilkan
                    </label>

                    <select
                        wire:model="perPage"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <option value="10">10 Data</option>
                        <option value="25">25 Data</option>
                        <option value="50">50 Data</option>
                        <option value="100">100 Data</option>

                    </select>
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block mb-1 text-xs font-semibold text-gray-500 uppercase">
                        Jenis Kelamin
                    </label>

                    <select
                        wire:model="jenis_kelamin"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Semua</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>

                    </select>
                </div>

                {{-- Angkatan --}}
                <div>
                    <label class="block mb-1 text-xs font-semibold text-gray-500 uppercase">
                        Angkatan
                    </label>

                    <select
                        wire:model="angkatan"
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Semua Angkatan</option>

                        @foreach($angkatanList as $tahun)
                        <option value="{{ $tahun }}">
                            {{ $tahun }}
                        </option>
                        @endforeach

                    </select>
                </div>

            </div>

            {{-- Tombol Kembali --}}
            <div>

                <a href="/pesertaasrama/{{ $asramasiswa }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm hover:bg-gray-100 transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7" />

                    </svg>

                    Kembali

                </a>

            </div>

        </div>

    </div>

    {{-- INFO & ACTION --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-5 mb-4 gap-3">

        <div>

            @if(count($selected))

            <div class="inline-flex items-center gap-2 rounded-lg bg-green-100 px-4 py-2 text-sm font-medium text-green-700">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7" />

                </svg>

                {{ count($selected) }} siswa dipilih

            </div>

            @else

            <span class="text-sm text-gray-500">
                Belum ada siswa dipilih
            </span>

            @endif

        </div>

        <button
            wire:click="kolektif"
            class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 font-medium text-white shadow hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
            {{ count($selected)==0 ? 'disabled' : '' }}>

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4" />

            </svg>

            Tambahkan Kolektif

        </button>

    </div>

    {{-- TABLE --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50">

                    <tr class="text-gray-600 uppercase text-xs tracking-wider">

                        <th class="px-4 py-3 text-center w-14">
                            <input type="checkbox" wire:model="selectAll">
                        </th>

                        <th class="px-4 py-3 text-center w-16">
                            No
                        </th>

                        <th class="px-4 py-3">
                            NIS
                        </th>

                        <th class="px-4 py-3">
                            Nama Siswa
                        </th>

                        <th class="px-4 py-3 text-center">
                            JK
                        </th>

                        <th class="px-4 py-3 text-center">
                            Jenjang
                        </th>

                        <th class="px-4 py-3 text-center">
                            Angkatan
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($Datasiswa as $item)

                    <tr class="hover:bg-green-50 transition">

                        <td class="text-center py-3">
                            <input
                                type="checkbox"
                                value="{{ $item->id }}"
                                wire:model="selected">
                        </td>

                        <td class="text-center font-medium">

                            {{ ($Datasiswa->currentPage()-1)*$Datasiswa->perPage()+$loop->iteration }}

                        </td>

                        <td class="px-4 py-3 font-medium text-blue-700">

                            {{ $item->nis }}

                        </td>

                        <td class="px-4 py-3 capitalize font-medium text-gray-700">

                            {{ $item->nama_siswa }}

                        </td>

                        <td class="text-center">

                            <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold">

                                {{ $item->jenis_kelamin }}

                            </span>

                        </td>

                        <td class="text-center">

                            <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">

                                {{ $item->madrasah_diniyah }}

                            </span>

                        </td>

                        <td class="text-center font-medium text-gray-600">

                            {{ date('Y', strtotime($item->tanggal_masuk)) }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="py-12 text-center text-gray-500">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="mx-auto w-12 h-12 text-gray-300 mb-3"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M9 17v-2a4 4 0 014-4h6" />

                            </svg>

                            Tidak ada data siswa.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">

        {{ $Datasiswa->links() }}

    </div>

</div>