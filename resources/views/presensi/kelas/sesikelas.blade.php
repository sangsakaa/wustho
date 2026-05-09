<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas')

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
            <h2 class="font-semibold text-lg sm:text-xl">
                Presensi Kelas
            </h2>

            <span class="text-sm text-gray-500">
                {{ $tgl->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
    </x-slot>

    @php
    $total = $Datasesikelas->count();
    $done = $Datasesikelas->where('absensi_count', '>', 0)->count();
    $notDone = $Datasesikelas->where('absensi_count', 0)->count();
    $percent = $total ? round(($done / $total) * 100) : 0;
    @endphp

    {{-- SUMMARY --}}
    <div class="px-4 mt-2">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">

            <div class="bg-white p-4 rounded shadow-sm border text-center">
                <div class="text-xs text-gray-500">Total Sesi</div>
                <div class="text-xl font-bold text-blue-600">{{ $total }}</div>
            </div>

            <div class="bg-white p-4 rounded shadow-sm border text-center">
                <div class="text-xs text-gray-500">Sudah Diisi</div>
                <div class="text-xl font-bold text-green-600">{{ $done }}</div>
            </div>

            <div class="bg-white p-4 rounded shadow-sm border text-center">
                <div class="text-xs text-gray-500">Belum Diisi</div>
                <div class="text-xl font-bold text-red-600">{{ $notDone }}</div>
            </div>

            <div class="bg-white p-4 rounded shadow-sm border text-center">
                <div class="text-xs text-gray-500">Progress</div>
                <div class="text-xl font-bold text-purple-600">{{ $percent }}%</div>
            </div>

        </div>
    </div>

    {{-- ACTION BAR --}}
    <div class="px-4">
        <div class="bg-white shadow-sm rounded p-3 mb-3 flex flex-wrap gap-2 justify-between items-center">

            <form action="/sesikelas" method="get" class="flex gap-2 items-center">
                <input type="date"
                    name="tgl"
                    class="py-1 px-2 border rounded dark:bg-dark-bg"
                    value="{{ $tgl->toDateString() }}">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                    Filter
                </button>
            </form>

            <div class="flex gap-2 flex-wrap">
                <a href="/sesikelas/rekap"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded">
                    Rekap
                </a>

                <form action="/sesikelas" method="post">
                    @csrf
                    <input type="hidden" name="tgl" value="{{ $tgl->format('Y-m-d') }}">

                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">
                        + Buat Sesi
                    </button>
                </form>

                <button type="button"
                    id="bulkDeleteBtn"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                    Hapus Terpilih
                </button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="px-4">
        <div class="bg-white shadow-sm rounded overflow-hidden">

            <div class="p-3 border-b font-semibold text-gray-700">
                Daftar Sesi Kelas
            </div>

            <form id="bulkDeleteForm" action="/sesikelas/bulk-delete" method="POST">
                @csrf
                @method('DELETE')

                <div class="overflow-auto">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-center">
                                <th class="border px-2 py-2 w-10">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th class="border px-2 py-2 w-12">No</th>
                                <th class="border px-2 py-2">Tanggal</th>
                                <th class="border px-2 py-2">Kelas</th>
                                <th class="border px-2 py-2">Periode</th>
                                <th class="border px-2 py-2">Status</th>
                                <th class="border px-2 py-2 w-20">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($Datasesikelas as $sesi)
                            <tr class="hover:bg-gray-50 text-center">

                                <td class="border px-2 py-2">
                                    <input type="checkbox"
                                        class="row-check"
                                        value="{{ $sesi->id }}">
                                </td>

                                <td class="border px-2 py-2">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-2 py-2">
                                    {{ \Carbon\Carbon::parse($sesi->tgl)->isoFormat('DD MMM YYYY') }}
                                </td>

                                <td class="border px-2 py-2">
                                    <a href="/absensikelas/{{ $sesi->id }}"
                                        class="text-blue-600 hover:underline font-medium">
                                        {{ $sesi->nama_kelas }}
                                    </a>
                                </td>

                                <td class="border px-2 py-2">
                                    {{ $sesi->periode }} {{ $sesi->ket_semester }}
                                </td>

                                <td class="border px-2 py-2">
                                    @if ($sesi->absensi_count > 0)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                        ✔ Sudah Diisi
                                    </span>
                                    @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                                        ✖ Belum
                                    </span>
                                    @endif
                                </td>

                                <td class="border px-2 py-2">
                                    <form action="/sesikelas/{{ $sesi->id }}"
                                        method="post"
                                        class="form-delete">
                                        @csrf
                                        @method('delete')

                                        <button type="button"
                                            data-nama="{{ $sesi->nama_kelas }}"
                                            data-tanggal="{{ \Carbon\Carbon::parse($sesi->tgl)->isoFormat('DD MMMM Y') }}"
                                            class="btn-delete bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    Tidak ada data sesi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            {{-- NOTE --}}
            <div class="p-4 border-t bg-yellow-50 text-sm text-yellow-800">
                <b>Catatan:</b>
                <ul class="list-disc ml-5 mt-2 space-y-1">
                    <li>Klik nama kelas untuk masuk ke halaman absensi siswa.</li>
                    <li>Status <b>Sudah Diisi</b> berarti minimal terdapat 1 data absensi pada sesi tersebut.</li>
                    <li>Gunakan <b>Hapus Terpilih</b> untuk menghapus banyak sesi sekaligus.</li>
                    <li>Data yang dihapus tidak dapat dikembalikan.</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const checkAll = document.getElementById('checkAll');
            const rowChecks = document.querySelectorAll('.row-check');

            checkAll.addEventListener('change', function() {
                rowChecks.forEach(cb => cb.checked = this.checked);
            });

            // BULK DELETE
            document.getElementById('bulkDeleteBtn').addEventListener('click', function() {

                let selected = [];

                document.querySelectorAll('.row-check:checked').forEach(cb => {
                    selected.push(cb.value);
                });

                if (selected.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ada data dipilih'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Hapus data terpilih?',
                    text: `${selected.length} data akan dihapus`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {

                        let form = document.getElementById('bulkDeleteForm');

                        // hapus input lama
                        form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());

                        selected.forEach(id => {
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'ids[]';
                            input.value = id;
                            form.appendChild(input);
                        });

                        form.submit();
                    }
                });
            });

            // SINGLE DELETE
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {

                    let form = this.closest('form');

                    Swal.fire({
                        title: 'Yakin hapus?',
                        html: `Sesi <b>${this.dataset.nama}</b><br>${this.dataset.tanggal}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });

                });
            });

        });
    </script>
</x-app-layout>