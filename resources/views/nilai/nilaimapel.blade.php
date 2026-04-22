<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Nilai Mata Pelajaran')
        <h2 class="font-semibold text-xl leading-tight">
            Nilai Mata Pelajaran
        </h2>
    </x-slot>

    <!-- FORM -->
    <div class="p-2">
        <div class="bg-white dark:bg-dark-bg shadow rounded-lg p-4">
            <h3 class="text-blue-500 font-semibold mb-2">Form Tambah Nilai</h3>

            <form action="/nilaimapel" method="post" class="grid sm:grid-cols-4 gap-2">
                @csrf

                <select name="mapel_id"
                    class="w-full border rounded-md px-3 py-1 dark:bg-dark-bg focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="">-- Mata Pelajaran --</option>
                    @foreach($dataMapel as $mapel)
                    <option value="{{$mapel->id}}">
                        {{$mapel->kelas}} - {{$mapel->mapel}} - {{$mapel->nama_kitab}}
                    </option>
                    @endforeach
                </select>

                <select name="guru_id"
                    class="w-full border rounded-md px-3 py-1 dark:bg-dark-bg focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="">-- Pendidik --</option>
                    @foreach($dataGuru as $guru)
                    <option value="{{$guru->id}}">
                        {{$loop->iteration}} - {{$guru->nama_guru}}
                    </option>
                    @endforeach
                </select>

                <select name="kelasmi_id"
                    class="w-full border rounded-md px-3 py-1 dark:bg-dark-bg focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="">-- Kelas --</option>
                    @foreach($dataKelas as $kelas)
                    <option value="{{$kelas->id}}">
                        {{$kelas->nama_kelas}} {{$kelas->periode}} {{$kelas->ket_semester}}
                    </option>
                    @endforeach
                </select>

                <button class="bg-red-600 hover:bg-red-700 text-white rounded-md px-3 py-1 transition">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- TOOLBAR -->
    <div class="p-2">
        <div class="bg-white dark:bg-dark-bg shadow rounded-lg p-4 flex flex-col sm:flex-row justify-between gap-2">

            <div class="flex flex-wrap gap-2">
                <a href="/mapel" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">Mata Pelajaran</a>
                <a href="/juara-pararel" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">Lager Nilai</a>
                <a href="/progress-nilai" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm">Progress</a>
            </div>

            <form action="/nilaimapel" method="get" class="flex gap-1">
                <input type="text" name="cari"
                    value="{{ request('cari') }}"
                    class="border rounded-md px-3 py-1 dark:bg-dark-bg focus:ring-2 focus:ring-blue-400"
                    placeholder="Cari...">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 rounded-md">
                    Cari
                </button>
            </form>

        </div>
    </div>

    <!-- TABLE -->
    <div class="p-2">
        <div class="bg-white dark:bg-dark-bg shadow rounded-lg overflow-auto">

            <table class="w-full text-sm border">
                <thead>
                    <tr class="bg-gray-100 dark:bg-purple-600 uppercase text-xs">
                        <th class="border px-2 py-2">No</th>
                        <th class="border px-2">Periode</th>
                        <th class="border px-2">Smt</th>
                        <th class="border px-2">Nilai</th>
                        <th class="border px-2">Guru</th>
                        <th class="border px-2">Kelas</th>
                        <th class="border px-2">Mapel</th>
                        <th class="border px-2">Qty</th>
                        <th class="border px-2">NH</th>
                        <th class="border px-2">NU</th>
                        <th class="border px-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $nilai)
                    <tr class="hover:bg-gray-50 dark:hover:bg-purple-700">

                        <td class="border px-2">{{$loop->iteration}}</td>
                        <td class="border px-2 text-center">{{$nilai->periode}} {{$nilai->ket_semester}}</td>
                        <td class="border px-2 text-center">{{$nilai->semester}}</td>

                        <td class="border px-2 text-center">
                            <a href="/nilai/{{$nilai->id}}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">
                                Nilai
                            </a>
                        </td>

                        <td class="border px-2">{{$nilai->nama_guru}}</td>
                        <td class="border px-2 text-center">{{$nilai->nama_kelas}}</td>
                        <td class="border px-2 text-center">{{$nilai->mapel}}</td>
                        <td class="border px-2 text-center">{{$nilai->jumlah_peserta_kelas}}</td>
                        <td class="border px-2 text-center">{{$nilai->jumlah_nilai_harian}}</td>
                        <td class="border px-2 text-center">{{$nilai->jumlah_nilai_ujian}}</td>

                        <td class="border px-2 flex gap-1 justify-center">

                            <form action="/nilaimapel/{{$nilai->id}}" method="post">
                                @csrf
                                @method('delete')
                                <button
                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded"
                                    onclick="return confirm('Hapus {{$nilai->mapel}}?')">
                                    ✕
                                </button>
                            </form>

                            <a href="/nilaimapel/{{$nilai->id}}/edit"
                                class="bg-yellow-400 hover:bg-yellow-500 px-2 py-1 rounded">
                                ✎
                            </a>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center text-red-500 py-4">
                            Tidak ada data ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="mt-2">
            {{$data}}
        </div>
    </div>

</x-app-layout>