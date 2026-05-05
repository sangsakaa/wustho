<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Transkip')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                    Dashboard Data Transkip
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Manajemen data transkip dan kelulusan siswa kelas 3
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- NAVIGATION --}}
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700 p-4">
            <div class="flex flex-wrap gap-3">
                <a href="/periode"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition">
                    Periode
                </a>

                <a href="/lulusan"
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-medium transition">
                    Data Lulusan
                </a>
            </div>
        </div>

        {{-- ALERT INFO --}}
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="text-3xl">🎓</div>

                <div class="flex-1">
                    <h3 class="font-semibold text-amber-800 dark:text-amber-300">
                        Ketentuan Input Transkip
                    </h3>

                    <ul class="mt-3 space-y-1 text-sm text-amber-700 dark:text-amber-400">
                        <li>• Input transkip hanya untuk <b>kelas 3</b></li>
                        <li>• Hanya tersedia pada <b>semester genap</b></li>
                        <li>• Pastikan seluruh nilai siswa sudah lengkap</li>
                    </ul>

                    @if(!$isGenap)
                    <div
                        class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-sm font-medium">
                        ⛔ Input dinonaktifkan karena periode aktif semester ganjil
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- FORM --}}
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Form Input Data Transkip
                </h3>
            </div>

            <form action="/daftar-transkip" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Periode Lulusan
                        </label>
                        <select name="periode_id"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @foreach($dataPeriode as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->periode }} - {{ $item->ket_semester }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Mata Pelajaran
                        </label>
                        <select name="mapel_id"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @foreach($dataMapel as $item)
                            <option value="{{ $item->id }}">
                                Kelas {{ $item->kelas }} - {{ $item->mapel }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Jenis Ujian
                        </label>
                        <select name="jenis_ujian_id"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @foreach($dataJenisUjian as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_ujian }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Kelas
                        </label>
                        <select name="kelasmi_id"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                            @foreach($kelasMi as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-5 border-t border-slate-200 dark:border-slate-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <p class="text-xs uppercase tracking-wider text-slate-400">
                        Wajib diisi oleh bagian kurikulum
                    </p>

                    <button type="submit"
                        {{ !$isGenap ? 'disabled' : '' }}
                        class="px-6 py-2.5 rounded-xl font-medium text-white transition
                        {{ $isGenap
                            ? 'bg-blue-600 hover:bg-blue-700 shadow-sm'
                            : 'bg-slate-400 cursor-not-allowed' }}">
                        {{ $isGenap ? 'Simpan Data' : 'Semester Ganjil Nonaktif' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white dark:bg-slate-800 shadow-sm rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Data Transkip
                </h3>

                <span class="text-sm text-slate-500 dark:text-slate-400">
                    Total: {{ $dataTranskip->total() }} data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-center">No</th>
                            <th class="px-4 py-3 text-center">Periode</th>
                            <th class="px-4 py-3 text-center">Kelas</th>
                            <th class="px-4 py-3 text-center">Jenis Ujian</th>
                            <th class="px-4 py-3">Mapel</th>
                            <th class="px-4 py-3 text-center">Peserta</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($dataTranskip as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/40 transition">
                            <td class="px-4 py-3 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="/nilai_transkip/{{ $item->id }}"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">
                                    {{ $item->periode }} {{ $item->ket_semester }}
                                </a>
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->nama_kelas }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->nama_ujian }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->mapel }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <span
                                    class="px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium">
                                    {{ $item->nilaiTranskip->count() }} siswa
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="/daftar-transkip/{{ $item->id }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="px-3 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-300 rounded-lg font-medium transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400">
                                Belum ada data transkip
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                {{ $dataTranskip->links() }}
            </div>
        </div>
    </div>
</x-app-layout>