<div class="bg-white p-3 rounded shadow-sm">

    <!-- TOP BAR -->
    <div class="flex flex-col sm:flex-row justify-between gap-2 mb-3">

        <!-- BUTTON -->
        <div class="flex gap-2">
            <a href="/addasramasiswa">
                <button class="px-3 py-1 text-xs uppercase bg-blue-500 dark:bg-green-700 text-white rounded-md">
                    asrama siswa
                </button>
            </a>

            <a href="/asrama">
                <button class="px-3 py-1 text-xs uppercase bg-blue-500 dark:bg-green-700 text-white rounded-md">
                    asrama
                </button>
            </a>
        </div>

        <!-- SEARCH -->
        <div>
            <input type="search"
                wire:model="search"
                class="border rounded px-2 py-1 text-sm w-full sm:w-64"
                placeholder="Cari nama asrama...">
        </div>
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

    <!-- TABLE WRAPPER (ANTI MELEBAR) -->
    <div class="overflow-x-auto">

        <table class="w-full text-xs border">

            <thead class="bg-gray-100 dark:bg-purple-600 uppercase">
                <tr>
                    <th class="border px-2 py-1">No</th>

                    @role('super admin')
                    <th class="border px-2 py-1">Periode</th>
                    @endrole

                    <th class="border px-2 py-3">Daftar Asrama</th>
                    <th class="border px-2 py-3">Asrama</th>
                    <th class="border px-2 py-3">Kuota</th>
                    <th class="border px-2 py-3">Total</th>
                    <th class="border px-2 py-3">Status</th>
                    <th class="border px-2 py-3">Keterangan</th>
                    <th class="border px-2 py-3">Aksi</th>
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
                            class="{{ $item->type_asrama == 'Putra' ? 'text-blue-600' : 'text-pink-600' }}">
                            {{$item->asrama->nama_asrama}}
                        </a>
                    </td>

                    <td class="border text-center">{{$item->asrama->type_asrama}}</td>
                    <td class="border text-center">{{$item->kuota}} Org</td>
                    <td class="border text-center">{{$item->jumlah_nilai_ujian}} Org</td>

                    <!-- STATUS -->
                    <td class="border text-center">
                        @if($item->kuota == $item->jumlah_nilai_ujian)
                        <span class="text-red-600">Penuh</span>
                        @elseif($item->kuota < $item->jumlah_nilai_ujian)
                            <span class="text-red-500">Over</span>
                            @else
                            <span class="text-green-600">Tersedia</span>
                            @endif
                    </td>

                    <!-- KETERANGAN -->
                    <td class="border text-center">
                        @if($item->kuota == $item->jumlah_nilai_ujian)
                        Sesuai Kuota
                        @elseif($item->kuota < $item->jumlah_nilai_ujian)
                            Over {{ $item->jumlah_nilai_ujian - $item->kuota }} org
                            @else
                            Sisa {{ $item->kuota - $item->jumlah_nilai_ujian }} org
                            @endif
                    </td>

                    <!-- AKSI -->
                    <td class="border text-center">
                        <div class="flex justify-center gap-1">

                            @role('super admin')
                            <form action="/asramasiswa/{{$item->id}}" method="post">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Yakin hapus {{$item->nama_asrama}}?')"
                                    class="bg-red-500 text-white p-1 rounded">
                                    ✕
                                </button>
                            </form>
                            @endrole

                            <a href="asramasiswa/{{$item->id}}/edit">
                                <button class="bg-yellow-400 p-1 rounded">✎</button>
                            </a>

                            <a href="pesertaasrama/{{$item->id}}">
                                <button class="bg-sky-400 p-1 rounded">👁</button>
                            </a>

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="9" class="text-center py-3">
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