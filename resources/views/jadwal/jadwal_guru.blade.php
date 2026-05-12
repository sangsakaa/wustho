<x-app-layout>

    <x-slot name="header">
        @section('title', ' | Daftar Jadwal')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                    Tambah Jadwal Guru
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Atur pengajar dan mata pelajaran
                </p>
            </div>
        </div>
    </x-slot>

    <div class="p-4 space-y-6">

        {{-- ================= NOTIFIKASI ================= --}}
        @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            {{ session('error') }}
        </div>
        @endif

        @if (session('warning'))
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl text-sm">
            {{ session('warning') }}
        </div>
        @endif

        {{-- ================= ALUR PENGISIAN ================= --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm">

            <p class="font-semibold mb-1">📌 Alur Pengisian Jadwal</p>

            <ol class="list-decimal pl-5 space-y-1">
                <li>Pilih guru terlebih dahulu</li>
                <li>Pilih mata pelajaran sesuai kelas</li>
                <li>Pastikan tidak bentrok dengan jadwal lain</li>
                <li>Klik simpan untuk menyimpan data</li>
            </ol>

        </div>

        {{-- ================= FORM ================= --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm p-6">

            <form action="/jadwal-guru/{{$jadwal->id}}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="jadwal_id" value="{{$jadwal->id}}">

                <div class="grid sm:grid-cols-2 gap-5">

                    {{-- GURU --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pengajar
                        </label>

                        <select name="guru_id"
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">

                            <option value="">Pilih Pengajar</option>

                            @foreach ($daftarGuru as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_guru }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                    {{-- MAPEL --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mata Pelajaran
                        </label>

                        <select name="mapel_id"
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">

                            <option value="">Pilih Mata Pelajaran</option>

                            @foreach($daftarMapel as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_kitab }} - {{ $item->mapel }}
                            </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex justify-end gap-3 pt-2">

                    <a href="/Daftar-Jadwal"
                        class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm transition">
                        Kembali
                    </a>

                    <button
                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm shadow-sm transition">
                        Simpan Data
                    </button>

                </div>

            </form>

        </div>

        {{-- ================= INFO HARI ================= --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm p-5">

            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Hari</span>
                <span class="font-semibold text-gray-800 dark:text-gray-200 capitalize">
                    {{ $jadwal->hari }}
                </span>
            </div>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden">

            <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                <h3 class="font-semibold text-gray-700 dark:text-gray-200">
                    Daftar Pengajar
                </h3>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-center">Pengajar</th>
                            <th class="px-4 py-3 text-center">Kitab</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse($daftarJadwal as $list)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                            <td class="px-4 py-3 text-center text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 text-center font-medium text-gray-800 dark:text-gray-200">
                                {{ $list->guru->nama_guru ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-300">
                                {{ $list->mapel->nama_kitab ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">

                                    <a href="/edit-jadwal/{{$list->id}}"
                                        class="px-3 py-1 rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black text-xs transition">
                                        Edit
                                    </a>

                                    <form action="/jadwal-guru/{{$list->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Yakin hapus data ini?')"
                                            class="px-3 py-1 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs transition">
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">
                                Belum ada data pengajar
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>