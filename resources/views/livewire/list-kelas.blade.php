<div class="bg-white p-4 rounded shadow-sm space-y-4">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
        <div>
            <h2 class="text-lg font-semibold text-gray-700">
                Dashboard Kelas MI
            </h2>
            <p class="text-xs text-gray-500">
                Monitoring kuota dan jumlah siswa per kelas
            </p>
        </div>

        <a href="/addkelas_mi"
            class="flex items-center gap-1 px-3 py-1 text-xs uppercase bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Tambah Kelas
        </a>
    </div>

    <!-- DASHBOARD INFO -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

        <div class="bg-blue-100 text-blue-700 p-3 rounded shadow-sm">
            <p class="text-xs">Total Kelas</p>
            <h3 class="text-lg font-bold">{{ $listkelas->count() }}</h3>
        </div>

        <div class="bg-green-100 text-green-700 p-3 rounded shadow-sm">
            <p class="text-xs">Total Kuota</p>
            <h3 class="text-lg font-bold">{{ $listkelas->sum('kuota') }}</h3>
        </div>

        <div class="bg-yellow-100 text-yellow-700 p-3 rounded shadow-sm">
            <p class="text-xs">Total Terisi</p>
            <h3 class="text-lg font-bold">{{ $listkelas->sum('jumlah_nilai_ujian') }}</h3>
        </div>

        <div class="bg-purple-100 text-purple-700 p-3 rounded shadow-sm">
            <p class="text-xs">Sisa Kuota</p>
            <h3 class="text-lg font-bold">
                {{ $listkelas->sum('kuota') - $listkelas->sum('jumlah_nilai_ujian') }}
            </h3>
        </div>

    </div>

    <!-- SEARCH -->
    <div class="flex justify-end">
        <input type="search"
            wire:model="search"
            class="border rounded px-3 py-1 text-sm w-full sm:w-64 focus:ring focus:ring-blue-200"
            placeholder="Cari nama kelas...">
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-xs border">

            <thead class="bg-gray-100 dark:bg-purple-600 uppercase">
                <tr>
                    <th class="border py-2">No</th>
                    <th class="border">Periode</th>
                    <th class="border">Tingkat</th>
                    <th class="border">Jenjang</th>
                    <th class="border">Nama Kelas</th>
                    <th class="border">Kuota</th>
                    <th class="border">Terisi</th>
                    <th class="border">Progress</th>
                    <th class="border">Status</th>
                    <th class="border">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($listkelas as $item)
                <tr class="hover:bg-green-50 dark:hover:bg-purple-600 even:bg-gray-50 text-xs">

                    <td class="border text-center">{{ $loop->iteration }}</td>

                    <td class="border text-center">
                        {{ $item->periode }} {{ $item->ket_semester }}
                    </td>

                    <td class="border text-center">
                        <a href="/pesertakelas/{{$item->id}}" class="text-blue-600">
                            {{ $item->kelas }}
                        </a>
                    </td>

                    <td class="border text-center">{{ $item->jenjang }}</td>

                    <td class="border text-center font-semibold">
                        <a href="/pesertakelas/{{$item->id}}" class="uppercase">
                            {{ $item->nama_kelas }}
                        </a>
                    </td>

                    <td class="border text-center">{{ $item->kuota }}</td>

                    <td class="border text-center">
                        {{ $item->jumlah_nilai_ujian }}
                    </td>

                    <!-- PROGRESS -->
                    <td class="border px-2">
                        <div class="w-full bg-gray-200 rounded h-2">
                            <div class="bg-blue-500 h-2 rounded"
                                style="width: {{ $item->kuota > 0 ? ($item->jumlah_nilai_ujian / $item->kuota) * 100 : 0 }}%">
                            </div>
                        </div>
                        <p class="text-[10px] text-center mt-1">
                            {{ $item->jumlah_nilai_ujian }} / {{ $item->kuota }}
                        </p>
                    </td>

                    <!-- STATUS -->
                    <td class="border text-center">
                        @if($item->jumlah_nilai_ujian == $item->kuota)
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                            Full
                        </span>
                        @elseif($item->jumlah_nilai_ujian > $item->kuota)
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded">
                            Over
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded">
                            Tersedia
                        </span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="border text-center">
                        <div class="flex justify-center gap-1">

                            <form action="/kelas_mi/{{$item->id}}" method="post">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Yakin hapus?')"
                                    class="bg-red-500 text-white px-2 py-1 rounded">
                                    ✕
                                </button>
                            </form>

                            <a href="kelas_mi/{{$item->id}}/edit"
                                class="bg-yellow-400 px-2 py-1 rounded">
                                ✎
                            </a>

                            <a href="/pesertakelas/{{$item->id}}"
                                class="bg-sky-400 px-2 py-1 rounded">
                                👁
                            </a>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="10" class="text-center py-3 text-gray-500">
                        Data tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- KETERANGAN -->
<div class="mt-3 bg-blue-100 p-3 rounded text-sm">
    <p class="font-semibold mb-1">Keterangan:</p>
    <ol class="list-decimal ml-4 space-y-1">
        <li>Pastikan jumlah siswa tidak melebihi kuota kelas</li>
        <li>Gunakan fitur edit untuk mengatur kapasitas kelas</li>
    </ol>
</div>