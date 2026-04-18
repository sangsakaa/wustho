<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Perangkat')
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard Perangkat
        </h2>
    </x-slot>

    <div class="p-4 bg-gray-100 min-h-screen space-y-4">

        {{-- ACTION BUTTON --}}
        <div class="bg-white shadow rounded-xl p-4 flex flex-wrap gap-2">
            <a href="/form-perangkat"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                + Tambah Data
            </a>

            <a href="/jabatan"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                + Tambah Jabatan
            </a>
        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow rounded-xl p-4">

            <div class="mb-3 flex justify-between items-center">
                <h3 class="font-semibold text-lg">Data Perangkat</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-3 py-2 border">No</th>
                            <th class="px-3 py-2 border">NIG</th>
                            <th class="px-3 py-2 border">Nama</th>
                            <th class="px-3 py-2 border">Jabatan</th>
                            <th class="px-3 py-2 border">JK</th>
                            <th class="px-3 py-2 border">Agama</th>
                            <th class="px-3 py-2 border">TTL</th>
                            <th class="px-3 py-2 border">Masuk</th>
                            <th class="px-3 py-2 border">Status</th>
                            <th class="px-3 py-2 border text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($dataPerangkat as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border text-center">
                                {{ $loop->iteration }}
                            </td>

                            {{-- NIG --}}
                            <td class="px-3 py-2 border text-center">
                                <a href="/detail-perangkat/{{ $item->id }}" class="text-blue-600 hover:underline">
                                    {{ $item->NigTerakhir->nig ?? '-' }}
                                </a>
                            </td>

                            {{-- NAMA --}}
                            <td class="px-3 py-2 border font-medium">
                                <a href="/detail-perangkat/{{ $item->id }}" class="hover:underline">
                                    {{ $item->nama_perangkat }}
                                </a>
                            </td>

                            {{-- JABATAN --}}
                            <td class="px-3 py-2 border">
                                @if($item->Jabatan)
                                @foreach($item->Jabatan->titleJab as $jab)
                                <span class="bg-blue-100 text-blue-600 px-2 py-1 rounded text-xs">
                                    {{ $jab->nama_jabatan ?? '-' }}
                                </span>
                                @endforeach
                                @else
                                -
                                @endif
                            </td>

                            {{-- JK --}}
                            <td class="px-3 py-2 border text-center">
                                {{ $item->jenis_kelamin }}
                            </td>

                            {{-- AGAMA --}}
                            <td class="px-3 py-2 border text-center">
                                {{ $item->agama }}
                            </td>

                            {{-- TTL --}}
                            <td class="px-3 py-2 border text-center text-xs">
                                {{ $item->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMM Y') }}
                            </td>

                            {{-- MASUK --}}
                            <td class="px-3 py-2 border text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D/MM/Y') }}
                            </td>

                            {{-- STATUS --}}
                            <td class="px-3 py-2 border text-center">
                                <span class="px-2 py-1 rounded text-xs 
                                        {{ $item->status == 'aktif' ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-3 py-2 border">
                                <div class="flex justify-center gap-1">

                                    {{-- DETAIL --}}
                                    <a href="/detail-perangkat/{{ $item->id }}"
                                        class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1 rounded text-xs">
                                        Detail
                                    </a>

                                    {{-- EDIT --}}
                                    <a href="/edit-form-perangkat/{{ $item->id }}/edit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                                        Edit
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="/edit-form-perangkat/{{ $item->id }}" method="post"
                                        onsubmit="return confirm('Yakin hapus {{ $item->nama_perangkat }}?')">
                                        @csrf
                                        @method('delete')

                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-gray-500">
                                Data tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>