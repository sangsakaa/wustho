<x-app-layout>
    @section('title', ' | Presensi Kelas')

    @php
    $first = $Datasesikelas->first();
    $total = $Datasesikelas->count();
    $done = $Datasesikelas->where('status_ui', 'selesai')->count();
    $notDone = $total - $done;
    $percent = $total ? round(($done / $total) * 100) : 0;
    @endphp

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Presensi Kelas</h2>
                <p class="text-sm text-slate-500">
                    {{ $tgl?->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-xs text-slate-500">Periode Aktif</p>
                <p class="font-semibold text-indigo-600">
                    {{ $first->periode ?? '-' }} {{ $first->ket_semester ?? '' }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="p-4 space-y-6">

        {{-- SUMMARY --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-card title="Total Kelas" color="blue">{{ $total }}</x-card>
            <x-card title="Selesai" color="green">{{ $done }}</x-card>
            <x-card title="Belum Selesai" color="red">{{ $notDone }}</x-card>
            <x-card title="Progress" color="purple">{{ $percent }}%</x-card>
        </div>

        {{-- ACTION --}}
        <div class="bg-white border shadow rounded-2xl p-4 flex flex-col lg:flex-row justify-between gap-4">
            <form action="/sesikelas" method="GET" class="flex gap-2">
                <input type="date" name="tgl"
                    value="{{ $tgl?->toDateString() }}"
                    class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500">

                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">
                    Filter
                </button>
            </form>

            <div class="flex flex-wrap gap-2">
                <a href="/sesikelas/rekap"
                    class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg text-sm">
                    Rekap
                </a>

                <form id="generateForm" action="/sesikelas" method="POST">
                    @csrf
                    <input type="hidden" name="tgl" value="{{ $tgl?->toDateString() }}">
                    <button type="button" onclick="confirmGenerate()"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm">
                        + Buat Sesi
                    </button>
                </form>

                <form id="bulkDeleteForm" action="/sesikelas/bulk-delete" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmBulkDelete()"
                        class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-sm">
                        Hapus
                    </button>
                </form>

                <form id="bulkCloseForm" action="{{ route('sesi.bulkClose') }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmBulkClose()"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-sm">
                        Close Terpilih
                    </button>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white border shadow rounded-2xl overflow-hidden">
            <div class="px-4 py-3 border-b font-semibold text-slate-700">
                Daftar Sesi Kelas
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="p-3"><input type="checkbox" id="checkAll"></th>
                            <th class="p-3">No</th>
                            <th class="p-3">Kelas</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Progress</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($Datasesikelas as $sesi)
                        <tr class="border-t hover:bg-slate-50">
                            <td class="p-3 text-center">
                                <input type="checkbox" class="row-check" value="{{ $sesi->id }}">
                            </td>

                            <td class="p-3 text-center">{{ $loop->iteration }}</td>

                            <td class="p-3">
                                <a href="{{ url('/absensikelas/' . $sesi->id) }}"
                                    class="text-indigo-600 hover:underline font-medium">
                                    {{ $sesi->nama_kelas }}
                                </a>
                            </td>

                            <td class="p-3 text-center">
                                @php
                                $badge = match ($sesi->status_ui) {
                                'close' => 'bg-rose-100 text-rose-700',
                                'belum' => 'bg-slate-100 text-slate-700',
                                'proses' => 'bg-amber-100 text-amber-700',
                                default => 'bg-emerald-100 text-emerald-700',
                                };
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs {{ $badge }}">
                                    {{ strtoupper($sesi->status_ui) }}
                                </span>
                            </td>

                            <td class="p-3">
                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="h-2 rounded-full bg-indigo-500"
                                        style="width: {{ $sesi->progress }}%">
                                    </div>
                                </div>
                                <p class="text-xs text-center mt-1 text-slate-500">
                                    {{ $sesi->hadir_count }}/{{ $sesi->peserta_count }}
                                    ({{ $sesi->progress }}%)
                                </p>
                            </td>

                            <td class="p-3">
                                <div class="flex justify-center gap-2 flex-wrap">

                                    <a href="/absensi/monitor/{{ $sesi->id }}"
                                        class="px-3 py-1 rounded bg-blue-500 hover:bg-blue-600 text-white text-xs">
                                        Monitor
                                    </a>

                                    @if ($sesi->status != 'close')
                                    <button type="button"
                                        onclick="confirmClose('{{ route('sesi.close', $sesi->id) }}')"
                                        class="px-3 py-1 rounded bg-amber-500 hover:bg-amber-600 text-white text-xs">
                                        Close
                                    </button>
                                    @endif

                                    <form id="delete-form-{{ $sesi->id }}"
                                        action="/sesikelas/{{ $sesi->id }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            onclick="confirmDelete('{{ $sesi->id }}')"
                                            class="px-3 py-1 rounded bg-rose-500 hover:bg-rose-600 text-white text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-slate-500">
                                Tidak ada data sesi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('checkAll')?.addEventListener('change', function() {
                document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
            });
        });

        function checkedRows() {
            return document.querySelectorAll('.row-check:checked');
        }

        function appendIds(formId, checked) {
            let form = document.getElementById(formId);
            form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());

            checked.forEach(cb => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                form.appendChild(input);
            });

            return form;
        }

        function popup(title, text, icon, callback = null) {
            Swal.fire({
                title,
                text,
                icon,
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed && callback) callback();
            });
        }

        function confirmGenerate() {
            popup('Generate sesi?', 'Buat sesi kelas baru?', 'question', () => {
                document.getElementById('generateForm').submit();
            });
        }

        function confirmBulkDelete() {
            let checked = checkedRows();
            if (!checked.length) return Swal.fire('Oops', 'Pilih minimal 1 data', 'warning');

            popup('Hapus data?', 'Data akan dihapus permanen', 'warning', () => {
                appendIds('bulkDeleteForm', checked).submit();
            });
        }

        function confirmBulkClose() {
            let checked = checkedRows();
            if (!checked.length) return Swal.fire('Oops', 'Pilih minimal 1 data', 'warning');

            popup('Close sesi?', 'Sesi akan ditutup', 'warning', () => {
                appendIds('bulkCloseForm', checked).submit();
            });
        }

        function confirmDelete(id) {
            popup('Hapus sesi?', 'Data tidak bisa dikembalikan', 'warning', () => {
                document.getElementById('delete-form-' + id).submit();
            });
        }

        function confirmClose(url) {
            popup('Tutup sesi?', 'Sesi akan di-close', 'question', () => {
                window.location.href = url;
            });
        }
    </script>

    {{-- NOTIFIKASI SUCCESS / ERROR --}}
    @if(session('success'))
    <script>
        Swal.fire('Berhasil', '{{ session('
            success ') }}', 'success')
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire('Error', '{{ session('
            error ') }}', 'error')
    </script>
    @endif

</x-app-layout>