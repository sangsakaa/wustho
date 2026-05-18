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

        {{-- NOTIF --}}
        @foreach (['success' => 'green', 'error' => 'red', 'warning' => 'yellow'] as $type => $color)
        @if (session($type))
        <div class="bg-{{ $color }}-50 border border-{{ $color }}-200 text-{{ $color }}-700 px-4 py-3 rounded-xl text-sm">
            {{ session($type) }}
        </div>
        @endif
        @endforeach

        {{-- INFO --}}
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm">
            <p class="font-semibold mb-1">📌 Alur Pengisian Jadwal</p>
            <ol class="list-decimal pl-5 space-y-1">
                <li>Pilih mata pelajaran terlebih dahulu</li>
                <li>Pilih guru sesuai mapel</li>
                <li>Pastikan tidak bentrok jadwal</li>
                <li>Simpan data</li>
            </ol>
        </div>

        {{-- FORM --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm p-6">

            <form action="/jadwal-guru/{{$jadwal->id}}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="jadwal_id" value="{{$jadwal->id}}">

                <div class="grid sm:grid-cols-2 gap-5">

                    {{-- MAPEL --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mata Pelajaran
                        </label>

                        <select id="mapel_id" name="mapel_id"
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

                    {{-- GURU --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pengajar
                        </label>

                        <select id="guru_id" name="guru_id"
                            class="w-full rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-white
                                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">

                            <option value="">Pilih Pengajar</option>

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

        {{-- INFO HARI --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm p-5">

            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Hari</span>
                <span class="font-semibold text-gray-800 dark:text-gray-200 capitalize">
                    {{ $jadwal->hari }}
                </span>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden">

            <div class="p-5 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-700 dark:text-gray-200">
                    Daftar Pengajar
                </h3>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-center">Pengajar</th>
                            <th class="px-4 py-3 text-center">Kitab</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse($daftarJadwal as $list)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">

                            <td class="px-4 py-3 text-center text-gray-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $list->guru->nama_guru ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $list->mapel->nama_kitab ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">

                                    <a href="/edit-jadwal/{{$list->id}}"
                                        class="px-3 py-1 rounded-lg bg-yellow-400 hover:bg-yellow-500 text-black text-xs">
                                        Edit
                                    </a>

                                    <form action="/jadwal-guru/{{$list->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Yakin hapus data ini?')"
                                            class="px-3 py-1 rounded-lg bg-red-500 hover:bg-red-600 text-white text-xs">
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

    {{-- AJAX GURU BY MAPEL --}}
    <script>
        document.getElementById('mapel_id').addEventListener('change', function() {

            let mapelId = this.value;
            let guruSelect = document.getElementById('guru_id');

            guruSelect.innerHTML = '<option>Loading...</option>';

            if (!mapelId) {
                guruSelect.innerHTML = '<option value="">Pilih Pengajar</option>';
                return;
            }

            fetch('/get-guru-by-mapel?mapel_id=' + mapelId)
                .then(res => res.json())
                .then(data => {

                    guruSelect.innerHTML = '<option value="">Pilih Pengajar</option>';

                    data.forEach(guru => {
                        guruSelect.innerHTML += `
                            <option value="${guru.id}">
                                ${guru.nama_guru}
                            </option>
                        `;
                    });

                })
                .catch(() => {
                    guruSelect.innerHTML = '<option value="">Gagal load data</option>';
                });

        });
    </script>

</x-app-layout>