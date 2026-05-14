<x-app-layout>
    @section('title', ' | Kurikulum')

    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Kurikulum & Mata Pelajaran
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data mata pelajaran, pengampu, dan kurikulum sekolah.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="/mapel/laporan/pdf"
                    target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-red-700 transition">
                    📄 Export PDF
                </a>

                <a href="/addmapel"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                    ➕ Tambah Mapel
                </a>

                <form action="{{ route('mapel.generate-pengampu') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow hover:bg-emerald-700 transition">
                        ⚡ Generate Pengampu
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 px-4 py-6">

        {{-- ALERT --}}
        @foreach (['success' => 'green', 'delete' => 'red', 'update' => 'blue'] as $key => $color)
        @if (session($key))
        <div class="rounded-xl border border-{{ $color }}-200 bg-{{ $color }}-50 px-4 py-3 text-sm text-{{ $color }}-700 shadow-sm">
            {{ session($key) }}
        </div>
        @endif
        @endforeach

        {{-- INFO CARD --}}
        <div class="rounded-2xl border border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50 p-5 shadow-sm">
            <h3 class="font-semibold text-slate-800 mb-3">📌 Alur Pengisian Kurikulum</h3>

            <div class="grid gap-2 md:grid-cols-2 text-sm text-slate-600">
                <div>1. Pilih <b>Periode Aktif</b></div>
                <div>2. Input data <b>Kelas</b></div>
                <div>3. Tambah <b>Mata Pelajaran</b></div>
                <div>4. Isi data <b>Kitab</b> (opsional)</div>
                <div>5. Atur <b>Guru Pengampu</b></div>
                <div>6. Gunakan <b>Generate dari Jadwal</b></div>
            </div>

            <p class="mt-3 text-xs text-blue-700">
                Hindari duplikasi mapel pada kelas dan periode yang sama.
            </p>
        </div>

        {{-- STATS --}}
        @php
        $totalMapel = $listmapel->count();
        $totalKelas = $listmapel->groupBy('kelas')->count();
        $ganjil = $listmapel->where('ket_semester', 'Ganjil')->count();
        $genap = $listmapel->where('ket_semester', 'Genap')->count();
        @endphp

        <div class="grid grid-cols-1 gap-5 md:grid-cols-4">
            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500">Total Mapel</p>
                <h3 class="mt-2 text-3xl font-bold text-blue-600">{{ $totalMapel }}</h3>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500">Total Kelas</p>
                <h3 class="mt-2 text-3xl font-bold text-emerald-600">{{ $totalKelas }}</h3>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500">Semester Ganjil</p>
                <h3 class="mt-2 text-3xl font-bold text-amber-500">{{ $ganjil }}</h3>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-100">
                <p class="text-sm text-slate-500">Semester Genap</p>
                <h3 class="mt-2 text-3xl font-bold text-purple-600">{{ $genap }}</h3>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b px-6 py-4">
                <div>
                    <h3 class="font-semibold text-slate-800">Daftar Mata Pelajaran</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        Total {{ $totalMapel }} mata pelajaran tersedia
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-4 py-4 text-center">No</th>
                            <th class="px-4 py-4 text-center">Periode</th>
                            <th class="px-4 py-4 text-left">Mapel</th>
                            <th class="px-4 py-4 text-left">Kitab</th>
                            <th class="px-4 py-4 text-center">Kelas</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($listmapel as $list)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 text-center">{{ $loop->iteration }}</td>

                            <td class="px-4 py-4 text-center">
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700">
                                    {{ $list->periode }} {{ $list->ket_semester }}
                                </span>
                            </td>

                            <td class="px-4 py-4 font-semibold text-blue-600">
                                {{ $list->mapel }}
                            </td>

                            <td class="px-4 py-4 text-slate-600">
                                {{ $list->nama_kitab ?: '-' }}
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                    {{ $list->kelas }}
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="/edit-mapel/{{ $list->id }}"
                                        class="rounded-lg bg-amber-50 px-3 py-2 text-xs font-medium text-amber-700 hover:bg-amber-100">
                                        Edit
                                    </a>

                                    <a href="/mapel/{{ $list->id }}"
                                        class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-medium text-blue-700 hover:bg-blue-100">
                                        Pengampu
                                    </a>

                                    <form action="/mapel/{{ $list->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Hapus {{ $list->mapel }}?')"
                                            class="rounded-lg bg-red-50 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                Belum ada data mata pelajaran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>