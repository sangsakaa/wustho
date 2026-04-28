<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Guru')
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard Daftar Guru
        </h2>
    </x-slot>

    <div class="px-4 py-4 space-y-4">

        <!-- ALERT -->
        @foreach (['delete' => 'red', 'success' => 'green', 'update' => 'blue'] as $key => $color)
        @if (session($key))
        <div class="px-4 py-2 rounded-lg bg-{{ $color }}-100 text-{{ $color }}-700 text-sm">
            {{ session($key) }}
        </div>
        @endif
        @endforeach

        <!-- ACTION & SEARCH -->
        <div class="flex flex-col sm:flex-row justify-between gap-3">

            <a href="/addGuru"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                <x-icons.adduser />
                Tambah Guru
            </a>

            <form action="/guru" method="get" class="flex gap-2 w-full sm:w-auto">
                <input type="hidden" name="tab" value="{{ $tab }}">

                <input type="text" name="cari" value="{{ request('cari') }}"
                    placeholder="Cari nama..."
                    class="w-full sm:w-64 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                <button type="submit"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg">
                    Cari
                </button>
            </form>
        </div>

        <!-- STAT CARD -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

            <div class="bg-white border rounded-xl p-4 shadow-sm">
                <p class="text-sm text-gray-500">Total Guru</p>
                <p class="text-2xl font-bold">{{ $totalGuru }}</p>
            </div>

            <div class="bg-white border rounded-xl p-4 shadow-sm">
                <p class="text-sm text-gray-500">Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $aktif }}</p>
            </div>

            <div class="bg-white border rounded-xl p-4 shadow-sm">
                <p class="text-sm text-gray-500">Non Aktif</p>
                <p class="text-2xl font-bold text-red-600">{{ $nonaktif }}</p>
            </div>

            <div class="bg-white border rounded-xl p-4 shadow-sm">
                <p class="text-sm text-gray-500">Cuti</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $cuti }}</p>
            </div>

        </div>

        <!-- TAB FILTER -->
        <div class="flex gap-2 border-b pb-2 text-sm">

            <a href="/guru?tab=aktif"
                class="px-4 py-2 rounded-lg {{ $tab == 'aktif' ? 'bg-green-600 text-white' : 'bg-gray-200' }}">
                Aktif ({{ $aktif }})
            </a>

            <a href="/guru?tab=nonaktif"
                class="px-4 py-2 rounded-lg {{ $tab == 'nonaktif' ? 'bg-red-600 text-white' : 'bg-gray-200' }}">
                Non Aktif ({{ $nonaktif }})
            </a>

            <a href="/guru?tab=cuti"
                class="px-4 py-2 rounded-lg {{ $tab == 'cuti' ? 'bg-yellow-500 text-white' : 'bg-gray-200' }}">
                Cuti ({{ $cuti }})
            </a>

            <a href="/guru?tab=semua"
                class="px-4 py-2 rounded-lg {{ $tab == 'semua' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
                Semua
            </a>

        </div>

        <!-- TABLE -->
        <div class="bg-white border rounded-xl shadow-sm overflow-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="p-2 border text-center">No</th>
                        <th class="p-2 border">NIG</th>
                        <th class="p-2 border text-left">Nama</th>
                        <th class="p-2 border">JK</th>
                        <th class="p-2 border">Agama</th>
                        <th class="p-2 border">TTL</th>
                        <th class="p-2 border">Masuk</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($dataGuru as $item)
                    <tr class="hover:bg-gray-50">

                        <td class="border text-center p-2">
                            {{ ($dataGuru->currentPage() - 1) * $dataGuru->perPage() + $loop->iteration }}
                        </td>

                        <td class="border text-center">
                            {{ $item->NigTerakhir->nig ?? '-' }}
                        </td>

                        <td class="border px-2 font-medium">
                            {{ $item->nama_guru }}
                        </td>

                        <td class="border text-center">
                            {{ $item->jenis_kelamin }}
                        </td>

                        <td class="border text-center">
                            {{ $item->agama }}
                        </td>

                        <td class="border text-center text-xs">
                            {{ $item->tempat_lahir }},
                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMM Y') }}
                        </td>

                        <td class="border text-center text-xs">
                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D MMM Y') }}
                        </td>

                        <!-- STATUS -->
                        <td class="border text-center">
                            @if($item->status == 'Aktif')
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Aktif</span>
                            @elseif($item->status == 'Non Aktif')
                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">Non Aktif</span>
                            @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">Cuti</span>
                            @endif
                        </td>

                        <!-- AKSI -->
                        <td class="border">
                            <div class="flex justify-center gap-1">

                                <a href="/guru/{{ $item->id }}"
                                    class="px-2 py-1 text-xs bg-sky-500 text-white rounded">Detail</a>

                                <a href="/guru/{{ $item->id }}/edit"
                                    class="px-2 py-1 text-xs bg-yellow-400 text-black rounded">Edit</a>

                                <form action="/guru/{{ $item->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button onclick="return confirm('Hapus {{ $item->nama_guru }}?')"
                                        class="px-2 py-1 text-xs bg-red-500 text-white rounded">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center p-4 text-gray-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

            <!-- PAGINATION -->
            <div class="p-3">
                {{ $dataGuru->links() }}
            </div>

        </div>

    </div>
</x-app-layout>