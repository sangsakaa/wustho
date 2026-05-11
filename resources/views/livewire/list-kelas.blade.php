<div class="space-y-6">

    <!-- HEADER -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Dashboard Kelas MI
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Monitoring kuota dan jumlah siswa per kelas
                </p>
            </div>

            <a href="/addkelas_mi"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kelas
            </a>
        </div>
    </div>

    <!-- STATISTIC -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-5 rounded-2xl shadow">
            <p class="text-sm opacity-90">Total Kelas</p>
            <h3 class="text-3xl font-bold mt-2">{{ $listkelas->count() }}</h3>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-5 rounded-2xl shadow">
            <p class="text-sm opacity-90">Total Kuota</p>
            <h3 class="text-3xl font-bold mt-2">{{ $listkelas->sum('kuota') }}</h3>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white p-5 rounded-2xl shadow">
            <p class="text-sm opacity-90">Total Terisi</p>
            <h3 class="text-3xl font-bold mt-2">{{ $listkelas->sum('jumlah_nilai_ujian') }}</h3>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-fuchsia-600 text-white p-5 rounded-2xl shadow">
            <p class="text-sm opacity-90">Sisa Kuota</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $listkelas->sum('kuota') - $listkelas->sum('jumlah_nilai_ujian') }}
            </h3>
        </div>
    </div>

    <!-- SEARCH -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <div class="relative max-w-md ml-auto">
            <input type="search"
                wire:model.live="search"
                placeholder="Cari nama kelas..."
                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-3 top-3.5 w-5 h-5 text-gray-400"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="m21 21-4.35-4.35M11 18a7 7 0 1 1 0-14 7 7 0 0 1 0 14Z" />
            </svg>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 text-slate-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-4">No</th>
                        <th class="px-4 py-4">Periode</th>
                        <th class="px-4 py-4">Tingkat</th>
                        <th class="px-4 py-4">Jenjang</th>
                        <th class="px-4 py-4">Nama Kelas</th>
                        <th class="px-4 py-4">Kuota</th>
                        <th class="px-4 py-4">Terisi</th>
                        <th class="px-4 py-4">Progress</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($listkelas as $item)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-4 py-4 text-center">{{ $loop->iteration }}</td>

                        <td class="px-4 py-4 text-center">
                            {{ $item->periode }} {{ $item->ket_semester }}
                        </td>

                        <td class="px-4 py-4 text-center">
                            <a href="/pesertakelas/{{$item->id}}" class="text-blue-600 font-medium hover:underline">
                                {{ $item->kelas }}
                            </a>
                        </td>

                        <td class="px-4 py-4 text-center">{{ $item->jenjang }}</td>

                        <td class="px-4 py-4 font-semibold text-slate-700">
                            <a href="/pesertakelas/{{$item->id}}" class="hover:text-blue-600">
                                {{ $item->nama_kelas }}
                            </a>
                        </td>

                        <td class="px-4 py-4 text-center font-medium">
                            {{ $item->kuota }}
                        </td>

                        <td class="px-4 py-4 text-center font-medium">
                            {{ $item->jumlah_nilai_ujian }}
                        </td>

                        <!-- PROGRESS -->
                        <td class="px-4 py-4 min-w-[180px]">
                            @php
                            $progress = $item->kuota > 0
                            ? ($item->jumlah_nilai_ujian / $item->kuota) * 100
                            : 0;
                            @endphp

                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full
                                    {{ $progress >= 100 ? 'bg-red-500' : ($progress >= 80 ? 'bg-yellow-500' : 'bg-blue-500') }}"
                                    style="width: {{ min($progress,100) }}%">
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-2 text-center">
                                {{ $item->jumlah_nilai_ujian }} / {{ $item->kuota }}
                            </p>
                        </td>

                        <!-- STATUS -->
                        <td class="px-4 py-4 text-center">
                            @if($item->jumlah_nilai_ujian == $item->kuota)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                Full
                            </span>
                            @elseif($item->jumlah_nilai_ujian > $item->kuota)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">
                                Overload
                            </span>
                            @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                                Tersedia
                            </span>
                            @endif
                        </td>

                        <!-- ACTION -->
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-2">

                                <a href="kelas_mi/{{$item->id}}/edit"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition">
                                    ✏️
                                </a>

                                <a href="/pesertakelas/{{$item->id}}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 transition">
                                    👁
                                </a>

                                <form action="/kelas_mi/{{$item->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus data ini?')"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition">
                                        🗑
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-8 text-gray-400">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- INFO -->
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
        <h3 class="font-semibold text-blue-700 mb-2">Keterangan</h3>
        <ul class="space-y-2 text-sm text-blue-600">
            <li>• Pastikan jumlah siswa tidak melebihi kuota kelas</li>
            <li>• Gunakan fitur edit untuk mengatur kapasitas kelas</li>
        </ul>
    </div>

</div>