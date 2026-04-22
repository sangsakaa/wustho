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

            <!-- BUTTON -->
            <a href="/addGuru"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                <x-icons.adduser />
                Tambah Guru
            </a>

            <!-- SEARCH -->
            <form action="/guru" method="get" class="flex gap-2 w-full sm:w-auto">
                <input type="text" name="cari" value="{{ request('cari') }}"
                    placeholder="Cari nama / NIG..."
                    class="w-full sm:w-64 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                <button type="submit"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg">
                    Cari
                </button>
            </form>
        </div>
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

        <!-- TABLE CARD -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm">

            <div class="overflow-auto">
                <table class="w-full text-sm">

                    <!-- HEADER -->
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="py-2 border text-center">No</th>
                            <th class="border text-center">NIG</th>
                            <th class="border text-left px-3">Nama Guru</th>
                            <th class="border text-center">JK</th>
                            <th class="border text-center">Agama</th>
                            <th class="border text-center">TTL</th>
                            <th class="border text-center">Masuk</th>
                            <th class="border text-center">Status</th>
                            <th class="border text-center">Aksi</th>
                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody>
                        @forelse ($dataGuru as $item)
                        <tr class="hover:bg-gray-50">

                            <td class="border text-center py-2">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border text-center">
                                <a href="/guru/{{ $item->id }}" class="text-blue-600 hover:underline">
                                    {{ $item->NigTerakhir->nig ?? '—' }}
                                </a>
                            </td>

                            <td class="border px-3 font-medium">
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
                                <br>
                                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMM Y') }}
                            </td>

                            <td class="border text-center text-xs">
                                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D MMM Y') }}
                            </td>

                            <!-- STATUS -->
                            <td class="border text-center">
                                @if($item->status == 'Aktif')
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                                    Aktif
                                </span>
                                @else
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                                    Nonaktif
                                </span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td class="border">
                                <div class="flex justify-center gap-2 py-1">

                                    <a href="/guru/{{ $item->id }}"
                                        class="px-2 py-1 text-xs bg-sky-500 hover:bg-sky-600 text-white rounded-md">
                                        Detail
                                    </a>

                                    <a href="/guru/{{ $item->id }}/edit"
                                        class="px-2 py-1 text-xs bg-yellow-400 hover:bg-yellow-500 text-black rounded-md">
                                        Edit
                                    </a>

                                    <form action="/guru/{{ $item->id }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            onclick="return confirm('Yakin hapus: {{ $item->nama_guru }}?')"
                                            class="px-2 py-1 text-xs bg-red-500 hover:bg-red-600 text-white rounded-md">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">
                                Data guru tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class=" px-2">
                    <tr>
                        <td colspan="9 px-2">
                            {{$dataGuru->links()}}
                        </td>
                    </tr>
                </div>
            </div>

            <!-- PAGINATION -->
            <div class="p-3 border-t">

            </div>
        </div>

        <!-- INFO -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-gray-700">
            <p class="font-semibold mb-1">Keterangan:</p>
            <ul class="list-disc ml-5 space-y-1">
                <li><span class="text-green-600 font-medium">Aktif</span> = Guru masih mengajar</li>
                <li><span class="text-red-600 font-medium">Nonaktif</span> = Guru tidak aktif</li>
            </ul>
        </div>

    </div>
</x-app-layout>