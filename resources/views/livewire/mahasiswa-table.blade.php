<div class=" space-y-4">

    {{-- HEADER ACTION --}}
    <div class="bg-white shadow rounded-xl p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

        {{-- LEFT --}}
        <div class="flex flex-wrap items-center gap-2">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">



            </div>

            {{-- ADD --}}
            <a href="/addsiswa"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg flex items-center gap-1 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Tambah
            </a>

            {{-- SEARCH --}}
            <input type="search" wire:model="search"
                class="border rounded-lg px-3 py-2 text-sm w-48 focus:ring focus:ring-blue-200"
                placeholder="Cari siswa...">

            {{-- PER PAGE --}}
            <select wire:model="perPage"
                class="border rounded-lg px-2 py-2 text-sm focus:ring focus:ring-blue-200">
                <option>10</option>
                <option>15</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
                <option>500</option>
            </select>

        </div>

        {{-- RIGHT --}}
        <div class="flex flex-wrap items-center gap-2">

            {{-- EXPORT --}}
            <a href="/export-siswa"
                class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm">
                Template Excel
            </a>

            {{-- IMPORT --}}
            <form action="/import-siswa" method="post" enctype="multipart/form-data"
                class="flex items-center gap-2">
                @csrf

                <input type="file" name="file" id="fileInput"
                    class="text-sm border rounded-lg px-2 py-1">

                <button type="submit" id="submitButton"
                    class="bg-gray-400 text-white px-3 py-2 rounded-lg text-sm cursor-not-allowed"
                    disabled>
                    Import
                </button>
            </form>

        </div>

    </div>

    {{-- TOAST --}}
    @if (session('success'))
    <script>
        Toastify({
            text: "Data berhasil di import",
            duration: 3000,
            gravity: "top",
            position: "right",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
        }).showToast();
    </script>
    @endif

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-xl p-4 overflow-x-auto">

        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">

            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="border px-2 py-2">No</th>
                    <th class="border px-2">NIS</th>
                    <th class="border px-2">
                        <div class="flex items-center justify-center gap-1 cursor-pointer"
                            wire:click="sortby('nama_siswa')">
                            Nama
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10 3l-3 3h6l-3-3zm0 14l3-3H7l3 3z" />
                            </svg>
                        </div>
                    </th>
                    <th class="border px-2">JK</th>
                    <th class="border px-2">Asrama</th>
                    <th class="border px-2">Kelas</th>
                    <th class="border px-2">Jenjang</th>
                    <th class="border px-2">Angkatan</th>
                    <th class="border px-2 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $peserta)
                <tr class="hover:bg-gray-50 even:bg-gray-100 text-xs sm:text-sm">

                    <td class="border text-center py-1">
                        {{ $loop->iteration }}
                    </td>

                    {{-- NIS --}}
                    <td class="border text-center">
                        {{ $peserta->NisTerakhir->nis ?? 'Belum ada' }}
                    </td>

                    {{-- NAMA --}}
                    <td class="border px-2 capitalize">
                        <a href="/siswa/{{ $peserta->id }}"
                            class="hover:text-blue-600">
                            {{ strtolower($peserta->nama_siswa) }}
                        </a>
                    </td>

                    <td class="border text-center">
                        {{ $peserta->jenis_kelamin }}
                    </td>

                    {{-- ASRAMA --}}
                    <td class="border text-center">
                        {{ $peserta->asramaTerkhir->asramaSiswa->asrama->nama_asrama ?? 'Belum ada' }}
                    </td>

                    {{-- KELAS --}}
                    <td class="border text-center">
                        {{ $peserta->kelasTerakhir->KelasMi->nama_kelas ?? 'Belum ada' }}
                    </td>

                    {{-- JENJANG --}}
                    <td class="border text-center">
                        {{ $peserta->NisTerakhir->madrasah_diniyah ?? '-' }}
                    </td>

                    {{-- ANGKATAN --}}
                    <td class="border text-center">
                        {{ optional($peserta->NisTerakhir)->tanggal_masuk
                                ? \Carbon\Carbon::parse($peserta->NisTerakhir->tanggal_masuk)->format('Y')
                                : '-' }}
                    </td>

                    {{-- AKSI --}}
                    <td class="border text-center">
                        <div class="flex justify-center gap-1">

                            <a href="/siswa/{{ $peserta->id }}"
                                class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1 rounded text-xs">
                                Detail
                            </a>

                            @can('edit post')
                            <a href="/siswa/{{ $peserta->id }}/edit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                                Edit
                            </a>
                            @endcan

                            @can('delete post')
                            <form action="/siswa/{{ $peserta->id }}" method="post"
                                onsubmit="return confirm('Yakin hapus {{ $peserta->nama_siswa }}?')">
                                @csrf
                                @method('delete')

                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                    Hapus
                                </button>
                            </form>
                            @endcan

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-red-600">
                        Data tidak ditemukan
                    </td>
                </tr>
                @endforelse

                {{-- PAGINATION --}}
                <tr>
                    <td colspan="9" class="pt-2">
                        {{ $data }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>

{{-- SCRIPT IMPORT --}}
<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        const btn = document.getElementById('submitButton');

        if (this.files.length > 0) {
            btn.disabled = false;
            btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            btn.classList.add('bg-blue-500');
        } else {
            btn.disabled = true;
            btn.classList.add('bg-gray-400', 'cursor-not-allowed');
            btn.classList.remove('bg-blue-500');
        }
    });
</script>