<div class="space-y-3 text-sm">

    {{-- 🔔 HEADER MINI CARD --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">

        {{-- Kelas --}}
        <div class="bg-blue-600 text-white px-3 py-2 rounded-lg flex justify-between items-center">
            <div>
                <p class="text-[11px] opacity-80">Kelas</p>
                <p class="font-semibold text-sm leading-tight">{{ $datakelasmi->nama_kelas }}</p>
            </div>
            <span class="text-lg">📘</span>
        </div>

        {{-- Kuota --}}
        <div class="bg-green-600 text-white px-3 py-2 rounded-lg flex justify-between items-center">
            <div>
                <p class="text-[11px] opacity-80">Kuota</p>
                <p class="font-semibold text-sm">{{ $datakelasmi->kuota }}</p>
            </div>
            <span class="text-lg">👥</span>
        </div>

        {{-- Peserta --}}
        <div class="bg-purple-600 text-white px-3 py-2 rounded-lg flex justify-between items-center">
            <div>
                <p class="text-[11px] opacity-80">Peserta</p>
                <p class="font-semibold text-sm">{{ $hitung }}</p>
            </div>
            <span class="text-lg">📊</span>
        </div>

        {{-- JK --}}
        <div class="bg-pink-600 text-white px-3 py-2 rounded-lg">
            <p class="text-[11px] opacity-80 mb-1">JK</p>
            <div class="flex justify-between text-xs">
                <span>L: {{ $lk }}</span>
                <span>P: {{ $pr }}</span>
            </div>
        </div>

    </div>

    {{-- 🔎 ACTION BAR COMPACT --}}
    <div class="bg-white dark:bg-dark-bg px-3 py-2 rounded-lg shadow flex flex-wrap gap-2 items-center justify-between">

        <input type="search"
            wire:model.debounce.500ms="search"
            placeholder="Cari..."
            class="border rounded-md px-2 py-1 text-xs w-full sm:w-52 focus:ring focus:ring-blue-200">

        <div class="flex gap-2">
            <a href="/pesertakolektif/{{ $kelasmi }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 rounded text-xs">
                Kolektif
            </a>

            <a href="/kelas_mi"
                class="bg-gray-500 hover:bg-gray-600 text-white px-2 py-2 rounded text-xs">
                Kembali
            </a>

            <button onclick="window.print()"
                class="hidden sm:flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                <x-icons.print />
            </button>
            @if(count($selected) > 0)
            <button wire:click="deleteSelected"
                onclick="confirm('Hapus data terpilih?') || event.stopImmediatePropagation()"
                class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs">
                Hapus ({{ count($selected) }})
            </button>
            @endif
        </div>
    </div>

    {{-- 📋 TABLE DENSE --}}
    <div id="print-area" class="bg-white dark:bg-dark-bg p-2 rounded-lg shadow overflow-x-auto">

        <table class="w-full text-xs border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr>
                    {{-- CHECK ALL --}}
                    <th class="border px-2 py-2 text-center w-8">
                        <input type="checkbox" wire:model="selectAll">
                    </th>
                    <th class="border px-1 py-1 w-8 text-center">No</th>
                    <th class="border px-1 py-1 text-center">NIS</th>
                    <th class="border px-1 py-1 text-left">Nama</th>
                    <th class="border px-1 py-1 text-center w-10">JK</th>
                    <th class="border px-1 py-1 text-center">Kelas</th>
                    <th class="border px-1 py-1 text-center print:hidden w-16">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($dataKelas as $list)
                <tr class="hover:bg-gray-50 even:bg-gray-100 dark:even:bg-gray-800">

                    {{-- CHECKBOX --}}
                    <td class="border px-2 text-center py-2">
                        <input type="checkbox" value="{{ $list->id }}" wire:model="selected">
                    </td>

                    <td class="border px-1 text-center">{{ $loop->iteration }}</td>
                    <td class="border px-1 text-center">{{ $list->nis }}</td>

                    <td class="border px-1 capitalize truncate max-w-[150px]">
                        {{ strtolower($list->nama_siswa) }}
                    </td>

                    <td class="border px-1 text-center capitalize">
                        <span class="{{ $list->jenis_kelamin == 'L' ? 'text-blue-600' : 'text-pink-600' }}">
                            {{ strtolower($list->jenis_kelamin) }}
                        </span>
                    </td>

                    <td class="border px-1 text-center">
                        {{ $list->nama_kelas }}
                    </td>

                    {{-- AKSI --}}
                    <td class="border px-1 text-center print:hidden">
                        <div class="flex justify-center gap-1">
                            <a href="/pesertakelas/{{ $list->id }}/edit"
                                class="bg-yellow-400 hover:bg-yellow-500 p-1 rounded">
                                <x-icons.edit />
                            </a>

                            <form action="/pesertakelas/{{ $list->id }}" method="POST"
                                onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-600 hover:bg-red-700 text-white p-1 rounded">
                                    <x-icons.hapus />
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-3 text-xs">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- 🖨️ PRINT --}}
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #print-area,
        #print-area * {
            visibility: visible;
        }

        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>