<div class="space-y-5">

    {{-- HEADER --}}
    <div class="bg-white shadow-sm rounded-2xl p-4 border border-gray-100">

        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

            {{-- LEFT --}}
            <div class="flex flex-col lg:flex-row gap-3 w-full">

                {{-- BUTTON --}}
                <div class="flex flex-col sm:flex-row gap-2">

                    <a href="/addsiswa"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl flex items-center justify-center gap-2 text-sm shadow-sm whitespace-nowrap">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>

                        Tambah Siswa
                    </a>

                    <a href="/export-siswa"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm shadow-sm text-center whitespace-nowrap">
                        Template Excel
                    </a>

                </div>

                {{-- FILTER --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 flex-1">

                    {{-- SEARCH --}}
                    <input type="search"
                        wire:model.live.debounce.500ms="search"
                        placeholder="Cari siswa..."
                        class="border rounded-xl px-3 py-2 text-sm w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">

                    {{-- PERPAGE --}}
                    <select wire:model.live="perPage"
                        class="border rounded-xl px-3 py-2 text-sm w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">

                        <option value="10">10 / halaman</option>
                        <option value="15">15 / halaman</option>
                        <option value="25">25 / halaman</option>
                        <option value="50">50 / halaman</option>
                        <option value="100">100 / halaman</option>
                        <option value="500">500 / halaman</option>

                    </select>

                    {{-- ANGKATAN --}}
                    <select wire:model.live="angkatan"
                        class="border rounded-xl px-3 py-2 text-sm w-full focus:ring-2 focus:ring-blue-200 focus:outline-none">

                        <option value="">Semua Angkatan</option>

                        @foreach($angkatanList as $tahun)
                        <option value="{{ $tahun }}">
                            {{ $tahun }}
                        </option>
                        @endforeach

                    </select>

                </div>
            </div>

            {{-- IMPORT --}}
            <form action="/import-siswa"
                method="post"
                enctype="multipart/form-data"
                class="flex flex-col sm:flex-row gap-2 w-full xl:w-auto">

                @csrf

                <input type="file"
                    name="file"
                    id="fileInput"
                    class="text-sm border rounded-xl px-3 py-2 w-full file:mr-2 file:px-3 file:py-1 file:border-0 file:bg-gray-100 file:rounded-lg">

                <button type="submit"
                    id="submitButton"
                    disabled
                    class="bg-gray-400 text-white px-4 py-2 rounded-xl text-sm cursor-not-allowed transition whitespace-nowrap">

                    Import
                </button>
            </form>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">

        <div class="overflow-x-auto">

            <table class="min-w-[1100px] w-full text-sm">

                {{-- HEAD --}}
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">

                    <tr>
                        <th class="px-3 py-3 text-center">No</th>
                        <th class="px-3 py-3 text-center">NIS</th>

                        <th class="px-3 py-3 text-center">
                            <button wire:click="sortby('nama_siswa')"
                                class="flex items-center justify-center gap-1 mx-auto">

                                Nama

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-3 h-3"
                                    viewBox="0 0 20 20"
                                    fill="currentColor">

                                    <path d="M10 3l-3 3h6l-3-3zm0 14l3-3H7l3 3z" />
                                </svg>

                            </button>
                        </th>

                        <th class="px-3 py-3 text-center">JK</th>
                        <th class="px-3 py-3 text-center">Asrama</th>
                        <th class="px-3 py-3 text-center">Kelas</th>
                        <th class="px-3 py-3 text-center">Jenjang</th>
                        <th class="px-3 py-3 text-center">Angkatan</th>
                        <th class="px-3 py-3 text-center">Aksi</th>
                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse ($data as $peserta)
                    <tr class="hover:bg-gray-50 text-xs sm:text-sm">

                        <td class="px-3 py-3 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-3 py-3 text-center">
                            {{ $peserta->NisTerakhir->nis ?? 'Belum ada' }}
                        </td>

                        <td class="px-3 py-3 capitalize">
                            <a href="/siswa/{{ $peserta->id }}"
                                class="hover:text-blue-600 font-medium">

                                {{ strtolower($peserta->nama_siswa) }}
                            </a>
                        </td>

                        <td class="px-3 py-3 text-center">
                            {{ $peserta->jenis_kelamin }}
                        </td>

                        <td class="px-3 py-3 text-center">
                            {{ $peserta->asramaTerkhir->asramaSiswa->asrama->nama_asrama ?? 'Belum ada' }}
                        </td>

                        <td class="px-3 py-3 text-center">
                            {{ $peserta->kelasTerakhir->KelasMi->nama_kelas ?? 'Belum ada' }}
                        </td>

                        <td class="px-3 py-3 text-center">
                            {{ $peserta->NisTerakhir->madrasah_diniyah ?? '-' }}
                        </td>

                        <td class="px-3 py-3 text-center">
                            {{ optional($peserta->NisTerakhir)->tanggal_masuk
                                    ? \Carbon\Carbon::parse($peserta->NisTerakhir->tanggal_masuk)->format('Y')
                                    : '-' }}
                        </td>

                        {{-- ACTION --}}
                        <td class="px-3 py-3">
                            <div class="flex flex-wrap justify-center gap-1">

                                <a href="/siswa/{{ $peserta->id }}"
                                    class="bg-sky-500 hover:bg-sky-600 text-white px-2 py-1 rounded-lg text-xs">
                                    Detail
                                </a>

                                @can('edit post')
                                <a href="/siswa/{{ $peserta->id }}/edit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded-lg text-xs">
                                    Edit
                                </a>
                                @endcan

                                @can('delete post')
                                <form action="/siswa/{{ $peserta->id }}"
                                    method="post"
                                    onsubmit="return confirm('Yakin hapus {{ $peserta->nama_siswa }}?')">

                                    @csrf
                                    @method('delete')

                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg text-xs">
                                        Hapus
                                    </button>
                                </form>
                                @endcan

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9"
                            class="text-center py-8 text-gray-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="p-4 border-t bg-gray-50">
            {{ $data->links() }}
        </div>

    </div>
</div>

<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        const btn = document.getElementById('submitButton');

        if (this.files.length > 0) {
            btn.disabled = false;
            btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
        } else {
            btn.disabled = true;
            btn.classList.add('bg-gray-400', 'cursor-not-allowed');
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        }
    });
</script>