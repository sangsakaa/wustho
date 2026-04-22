<div class="bg-white p-4 rounded shadow-sm space-y-4">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
        <div>
            <h2 class="text-lg font-semibold text-gray-700">
                Dashboard Asrama
            </h2>
            <p class="text-xs text-gray-500">
                Monitoring kuota dan penghuni asrama
            </p>
        </div>

        <!-- BUTTON -->
        <div class="flex gap-2">
            <a href="/addasramasiswa"
                class="px-3 py-1 text-xs uppercase bg-blue-500 hover:bg-blue-600 text-white rounded-md shadow">
                + Asrama Siswa
            </a>

            <a href="/asrama"
                class="px-3 py-1 text-xs uppercase bg-green-600 hover:bg-green-700 text-white rounded-md shadow">
                Data Asrama
            </a>
        </div>
    </div>

    <!-- DASHBOARD INFO -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

        <div class="bg-blue-100 text-blue-700 p-3 rounded shadow-sm">
            <p class="text-xs">Total Asrama</p>
            <h3 class="text-lg font-bold">{{ $data->count() }}</h3>
        </div>

        <div class="bg-green-100 text-green-700 p-3 rounded shadow-sm">
            <p class="text-xs">Total Kuota</p>
            <h3 class="text-lg font-bold">{{ $data->sum('kuota') }}</h3>
        </div>

        <div class="bg-yellow-100 text-yellow-700 p-3 rounded shadow-sm">
            <p class="text-xs">Total Terisi</p>
            <h3 class="text-lg font-bold">{{ $data->sum('pesertaasrama_count') }}</h3>
        </div>

        <div class="bg-purple-100 text-purple-700 p-3 rounded shadow-sm">
            <p class="text-xs">Sisa Kuota</p>
            <h3 class="text-lg font-bold">
                {{ $data->sum('kuota') - $data->sum('pesertaasrama_count') }}
            </h3>
        </div>

    </div>

    <!-- SEARCH -->
    <div class="flex justify-end">
        <input type="search"
            wire:model="search"
            class="border rounded px-3 py-1 text-sm w-full sm:w-64 focus:ring focus:ring-blue-200"
            placeholder="Cari nama asrama...">
    </div>

    <!-- TOAST -->
    @if (session('update'))
    <script>
        Toastify({
            text: "Data berhasil di update",
            className: "update",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
        }).showToast();
    </script>
    @endif

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-xs border">

            <thead class="bg-gray-100 dark:bg-purple-600 uppercase">
                <tr>
                    <th class="border px-2 py-1">No</th>

                    @role('super admin')
                    <th class="border px-2 py-1">Periode</th>
                    @endrole

                    <th class="border px-2 py-2">Daftar Asrama</th>
                    <th class="border px-2 py-2">Tipe</th>
                    <th class="border px-2 py-2">Kuota</th>
                    <th class="border px-2 py-2">Terisi</th>
                    <th class="border px-2 py-2">Progress</th>
                    <th class="border px-2 py-2">Status</th>
                    <th class="border px-2 py-2">Keterangan</th>
                    <th class="border px-2 py-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($data as $item)
                <tr class="hover:bg-purple-50 dark:hover:bg-purple-600">

                    <td class="border text-center">{{$loop->iteration}}</td>

                    @role('super admin')
                    <td class="border text-center">
                        <a href="pesertaasrama/{{$item->id}}">
                            {{$item->periode->periode}}
                        </a>
                    </td>
                    @endrole

                    <!-- NAMA -->
                    <td class="border text-center font-semibold">
                        <a href="pesertaasrama/{{$item->id}}"
                            class="{{ $item->asrama->type_asrama == 'Putra' ? 'text-blue-600' : 'text-pink-600' }}">
                            {{$item->asrama->nama_asrama}}
                        </a>
                    </td>

                    <td class="border text-center">
                        {{$item->asrama->type_asrama}}
                    </td>

                    <td class="border text-center">
                        {{$item->kuota}}
                    </td>

                    <td class="border text-center">
                        {{$item->pesertaasrama_count}}
                    </td>

                    <!-- PROGRESS BAR -->
                    <td class="border px-2 py-1">
                        <div class="w-full bg-gray-200 rounded h-2">
                            <div class="bg-blue-500 h-2 rounded"
                                style="width: {{ $item->kuota > 0 ? ($item->pesertaasrama_count / $item->kuota) * 100 : 0 }}%">
                            </div>
                        </div>
                        <p class="text-[10px] text-center mt-1">
                            {{ $item->pesertaasrama_count }} / {{ $item->kuota }}
                        </p>
                    </td>

                    <!-- STATUS -->
                    <td class="border text-center">
                        @if($item->pesertaasrama_count >= $item->kuota)
                        <span class="px-2 py-1 text-xs bg-red-100 text-red-600 rounded">
                            Penuh
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-600 rounded">
                            Tersedia
                        </span>
                        @endif
                    </td>

                    <!-- KETERANGAN -->
                    <td class="border text-center text-xs">
                        @if($item->pesertaasrama_count >= $item->kuota)
                        <span class="text-red-600">Kuota penuh</span>
                        @else
                        <span class="text-green-600">
                            Sisa {{ $item->kuota - $item->pesertaasrama_count }}
                        </span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="border text-center">
                        <div class="flex justify-center gap-1">

                            @role('super admin')
                            <form action="/asramasiswa/{{$item->id}}" method="post">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Yakin hapus?')"
                                    class="bg-red-500 text-white px-2 py-1 rounded">
                                    ✕
                                </button>
                            </form>
                            @endrole

                            <a href="asramasiswa/{{$item->id}}/edit"
                                class="bg-yellow-400 px-2 py-1 rounded">
                                ✎
                            </a>

                            <a href="pesertaasrama/{{$item->id}}"
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
        <li>Penambahan anggota asrama wajib memiliki <b>NIM</b></li>
        <li>Jika belum ada NIM, konfirmasi ke bagian kesiswaan / kepala sekolah</li>
    </ol>
</div>