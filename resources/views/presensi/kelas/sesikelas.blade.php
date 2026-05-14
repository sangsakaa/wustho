<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Presensi Kelas')

        @php
        $first = $Datasesikelas->first();
        $total = $Datasesikelas->count();
        $done = $Datasesikelas->where('status_ui', 'selesai')->count();
        $notDone = $total - $done;
        $percent = $total ? round(($done / $total) * 100) : 0;
        @endphp

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Presensi Kelas</h2>
                <p class="text-sm text-gray-500">
                    {{ $tgl?->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-xs text-gray-500">Periode Aktif</p>
                <p class="font-semibold text-indigo-600">
                    {{ $first->periode ?? '-' }}
                    {{ $first->ket_semester ?? '' }}
                </p>
            </div>
        </div>
    </x-slot>

    {{-- SUMMARY --}}
    <div class="px-4 py-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border shadow rounded-xl p-5">
                <p class="text-sm text-gray-500">Total Kelas</p>
                <h3 class="text-3xl font-bold text-blue-600">{{ $total }}</h3>
            </div>

            <div class="bg-white border shadow rounded-xl p-5">
                <p class="text-sm text-gray-500">Selesai</p>
                <h3 class="text-3xl font-bold text-green-600">{{ $done }}</h3>
            </div>

            <div class="bg-white border shadow rounded-xl p-5">
                <p class="text-sm text-gray-500">Belum Selesai</p>
                <h3 class="text-3xl font-bold text-red-600">{{ $notDone }}</h3>
            </div>

            <div class="bg-white border shadow rounded-xl p-5">
                <p class="text-sm text-gray-500">Progress</p>
                <h3 class="text-3xl font-bold text-purple-600">{{ $percent }}%</h3>
            </div>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="px-4">
        <div class="bg-white shadow rounded-xl p-4 flex flex-col lg:flex-row justify-between gap-4">

            <form action="/sesikelas" method="GET" class="flex gap-2">
                <input
                    type="date"
                    name="tgl"
                    value="{{ $tgl?->toDateString() }}"
                    class="border rounded-lg px-3 py-2 text-sm">

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-lg text-sm">
                    Filter
                </button>
            </form>

            <div class="flex flex-wrap gap-2">
                <a href="/sesikelas/rekap"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                    Rekap
                </a>

                <form action="/sesikelas" method="POST">
                    @csrf
                    <input type="hidden" name="tgl" value="{{ $tgl?->toDateString() }}">

                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                        + Buat Sesi
                    </button>
                </form>

                <button
                    type="button"
                    onclick="document.getElementById('bulkDeleteForm').submit()"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                    Hapus
                </button>

                <form id="bulkCloseForm" action="{{ route('sesi.bulkClose') }}" method="POST">
                    @csrf
                    <button
                        type="button"
                        onclick="confirmBulkClose()"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm">
                        Close Terpilih
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="px-4 py-4">
        <div class="bg-white shadow rounded-xl overflow-hidden">

            <div class="px-4 py-3 border-b font-semibold text-gray-700">
                Daftar Sesi Kelas
            </div>

            <form id="bulkDeleteForm" action="/sesikelas/bulk-delete" method="POST">
                @csrf
                @method('DELETE')

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="p-3 text-center">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th class="p-3 text-center">No</th>
                                <th class="p-3">Kelas</th>
                                <th class="p-3 text-center">Status</th>
                                <th class="p-3 text-center">Progress</th>
                                <th class="p-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($Datasesikelas as $sesi)
                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-3 text-center">
                                    <input
                                        type="checkbox"
                                        class="row-check"
                                        name="ids[]"
                                        value="{{ $sesi->id }}">
                                </td>

                                <td class="p-3 text-center">{{ $loop->iteration }}</td>

                                <td class="p-3">
                                    <a href="{{ url('/absensikelas/' . $sesi->id) }}"
                                        class="font-medium text-blue-600 hover:underline">
                                        {{ $sesi->nama_kelas }}
                                    </a>
                                </td>

                                <td class="p-3 text-center">
                                    @switch($sesi->status_ui)
                                    @case('close')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">CLOSE</span>
                                    @break

                                    @case('belum')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">BELUM MULAI</span>
                                    @break

                                    @case('proses')
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">PROSES</span>
                                    @break

                                    @default
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">SELESAI</span>
                                    @endswitch
                                </td>

                                <td class="p-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div
                                            class="h-2 rounded-full
                                                {{ $sesi->progress == 100
                                                    ? 'bg-green-500'
                                                    : ($sesi->progress > 0 ? 'bg-yellow-500' : 'bg-gray-400') }}"
                                            style="width: {{ $sesi->progress }}%">
                                        </div>
                                    </div>

                                    <div class="text-xs text-center text-gray-500 mt-1">
                                        {{ $sesi->hadir_count }}/{{ $sesi->peserta_count }}
                                        ({{ $sesi->progress }}%)
                                    </div>
                                </td>

                                <td class="p-3">
                                    <div class="flex justify-center gap-2 flex-wrap">

                                        <a href="/absensi/monitor/{{ $sesi->id }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                            Monitor
                                        </a>

                                        @if ($sesi->status != 'close')
                                        <a href="{{ route('sesi.close', $sesi->id) }}"
                                            onclick="return confirm('Tutup sesi ini?')"
                                            class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-xs">
                                            Close
                                        </a>
                                        @endif

                                        <button type="submit" formaction="/sesikelas/{{ $sesi->id }}"
                                            formmethod="POST"
                                            onclick="return confirm('Hapus sesi ini?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-10 text-gray-500">
                                    Tidak ada data sesi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <script>
        const checkAll = document.getElementById('checkAll');

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                document.querySelectorAll('.row-check').forEach(cb => {
                    cb.checked = this.checked;
                });
            });
        }

        function confirmBulkClose() {
            const checked = document.querySelectorAll('.row-check:checked');

            if (checked.length === 0) {
                alert('Pilih minimal 1 sesi');
                return;
            }

            if (!confirm('Yakin close sesi terpilih?')) return;

            const form = document.getElementById('bulkCloseForm');
            form.querySelectorAll('input[name="ids[]"]').forEach(el => el.remove());

            checked.forEach(cb => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                form.appendChild(input);
            });

            form.submit();
        }
    </script>
</x-app-layout>