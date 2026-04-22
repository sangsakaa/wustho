<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    Edit Jadwal Guru
                </h2>
                <p class="text-sm text-gray-500">
                    Atur pengajar dan mata pelajaran
                </p>
            </div>
        </div>
    </x-slot>

    <div class="p-4 space-y-4">

        <!-- FORM -->
        <div class="bg-white rounded-2xl shadow-sm border p-4">
            <form action="/jadwal-guru/{{$jadwal->id}}" method="post">
                @csrf
                <input type="hidden" name="jadwal_id" value="{{$jadwal->id}}">

                <div class="grid sm:grid-cols-2 gap-4">

                    <!-- GURU -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Pilih Pengajar
                        </label>
                        <select name="guru_id"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Pengajar</option>
                            @foreach ($daftarGuru as $item)
                            <option value="{{$item->id}}" @selected($item->id == $jadwal->guru_id)>
                                {{$item->nama_guru}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- MAPEL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Mata Pelajaran
                        </label>
                        <select name="mapel_id"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Mata Pelajaran</option>
                            @foreach($daftarMapel as $item)
                            <option value="{{$item->id}}" @selected($item->id == $jadwal->mapel_id)>
                                {{$item->kelas}} - {{$item->mapel}} {{$item->periode}} {{$item->ket_semester}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- ACTION -->
                <div class="flex justify-end gap-2 mt-4">
                    <a href="/Daftar-Jadwal"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm">
                        Kembali
                    </a>
                    <button
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm shadow">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- INFO -->
        <div class="bg-white rounded-2xl shadow-sm border p-4 text-sm">
            <div class="grid grid-cols-2 gap-2">
                <div class="text-gray-500">Hari</div>
                <div class="font-medium capitalize">
                    {{ $jadwal->hari }}
                </div>
            </div>
        </div>

        <!-- ALERT -->
        @if (session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded-lg text-sm">
            {{ session('error') }}
        </div>
        @endif

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-sm border">

            <div class="p-4 border-b">
                <h3 class="font-semibold text-gray-700">
                    Daftar Pengajar
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-center">Pengajar</th>
                            <th class="px-4 py-3 text-center">Kitab</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @foreach($daftarJadwal as $list)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-4 py-2 text-center">
                                {{$loop->iteration}}
                            </td>

                            <td class="px-4 py-2 text-center">
                                {{$list->nama_guru}}
                            </td>

                            <td class="px-4 py-2 text-center">
                                {{$list->nama_kitab}}
                            </td>

                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">

                                    <a href="/edit-jadwal/{{$list->id}}"
                                        class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-black rounded-md text-xs">
                                        Edit
                                    </a>

                                    <form action="/jadwal-guru/{{$list->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            onclick="return confirm('Yakin hapus data ini?')"
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</x-app-layout>