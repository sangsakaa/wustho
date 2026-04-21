<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Detail : '.$siswa->nama_siswa )
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Siswa
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- 🔹 CARD BIODATA --}}
        <div class="bg-white shadow rounded-xl p-5">
            <h3 class="font-semibold text-lg mb-3">Informasi Siswa</h3>

            <div class="grid md:grid-cols-2 gap-3 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-semibold uppercase">{{ $siswa->nama_siswa }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Lahir</span>
                    <span>
                        {{ $siswa->tempat_lahir }},
                        {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Jenis Kelamin</span>
                    <span>{{ $siswa->jenis_kelamin }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Asrama</span>
                    <span>
                        {{ optional($siswa->asramaTerkhir?->asramaSiswa?->asrama)->nama_asrama ?? 'Belum ada' }}
                    </span>
                </div>

            </div>
        </div>

        {{-- 🔹 ACTION --}}
        <div class="flex flex-wrap gap-2">
            <a href="/siswa/{{ $siswa->id }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg text-sm">
                ← Kembali
            </a>

            @role('super admin')
            <a href="/nis/{{ $siswa->id }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
                NIS
            </a>

            <a href="/biodata/{{ $siswa->id }}"
                class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm">
                Biodata
            </a>
            @endrole
        </div>

        {{-- 🔹 FORM NIS --}}
        <div class="bg-white shadow rounded-xl p-5">
            <h3 class="font-semibold mb-3">Tambah Nomor Induk Siswa</h3>

            <form action="/nis/{{$siswa->id}}" method="POST" class="grid md:grid-cols-5 gap-2">
                @csrf

                <input type="hidden" name="siswa_id" value="{{$siswa->id}}">

                <input type="text" name="nis"
                    placeholder="Contoh: 2023010001"
                    class="border rounded-lg px-3 py-2 text-sm col-span-2">

                <select name="madrasah_diniyah"
                    class="border rounded-lg px-2 py-2 text-sm">
                    <option value="">Jenjang</option>
                    <option value="Ula">Ula</option>
                    <option value="Wustho">Wustho</option>
                    <option value="Ulya">Ulya</option>
                </select>

                <select name="nama_lembaga"
                    class="border rounded-lg px-2 py-2 text-sm">
                    <option value="Wahidiyah">Wahidiyah</option>
                </select>

                <input type="date" name="tanggal_masuk"
                    class="border rounded-lg px-2 py-2 text-sm">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">
                    Simpan
                </button>
            </form>
        </div>

        {{-- 🔹 TABLE NIS --}}
        <div class="bg-white shadow rounded-xl p-5">
            <h3 class="font-semibold mb-3">Riwayat NIS</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm border rounded-lg overflow-hidden">

                    <thead class="bg-gray-100 text-xs uppercase">
                        <tr>
                            <th class="border px-2 py-2">No</th>
                            <th class="border px-2">NIS</th>
                            <th class="border px-2">Lembaga</th>
                            <th class="border px-2">Madrasah</th>
                            <th class="border px-2">Masuk</th>
                            <th class="border px-2 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($nis as $i => $nomor)
                        <tr class="hover:bg-gray-50 even:bg-gray-100">

                            <td class="border text-center">{{ $i+1 }}</td>
                            <td class="border text-center">{{ $nomor->nis }}</td>
                            <td class="border text-center">{{ $nomor->nama_lembaga }}</td>
                            <td class="border text-center">{{ $nomor->madrasah_diniyah }}</td>
                            <td class="border text-center">{{ $nomor->tanggal_masuk }}</td>

                            <td class="border text-center">
                                <div class="flex justify-center gap-1">

                                    @role('super admin')
                                    <form action="/nis/{{$nomor->id}}" method="POST"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                    @endrole

                                    <a href="/nis/{{$nomor->id}}/edit"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">
                                        Edit
                                    </a>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-red-600">
                                Belum memiliki NIS
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- 🔹 INFO --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm">
            <p class="font-semibold mb-1">Keterangan</p>
            <p>Mekanisme NIS:</p>
            <p class="ml-3">TAHUN MASUK - KODE MADRASAH - NOMOR URUT</p>
            <p class="ml-3 text-gray-500">Contoh: 202002001</p>
        </div>

    </div>
</x-app-layout>