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
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Presensi Kelas
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Monitoring sesi presensi siswa •
                    {{ $tgl?->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>


        </div>
    </x-slot>

    <div class="p-4 md:p-6 bg-slate-100 dark:bg-slate-900 min-h-screen space-y-6">

        {{-- SUMMARY CARD --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- TOTAL --}}
            <div
                class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">
                            Total Kelas
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                            {{ $total }}
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
                        🏫
                    </div>
                </div>
            </div>

            {{-- DONE --}}
            <div
                class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">
                            Selesai
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-emerald-600">
                            {{ $done }}
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
                        ✅
                    </div>
                </div>
            </div>

            {{-- BELUM --}}
            <div
                class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">
                            Belum Selesai
                        </p>

                        <h2 class="mt-2 text-3xl font-bold text-rose-600">
                            {{ $notDone }}
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl">
                        ⏳
                    </div>
                </div>
            </div>

            {{-- PROGRESS --}}
            <div
                class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-3xl p-5 shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-indigo-100">
                            Progress Hari Ini
                        </p>

                        <h2 class="mt-2 text-3xl font-bold">
                            {{ $percent }}%
                        </h2>
                    </div>

                    <div
                        class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-2xl">
                        📊
                    </div>
                </div>

                <div class="mt-4">
                    <div class="w-full h-2 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-2 bg-white rounded-full"
                            style="width: {{ $percent }}%">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- FILTER & ACTION --}}
        <div
            class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl p-5 shadow-sm">

            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

                {{-- FILTER --}}
                <form action="/sesikelas" method="GET"
                    class="flex flex-col sm:flex-row gap-3">

                    <input type="date"
                        name="tgl"
                        value="{{ $tgl?->toDateString() }}"
                        class="border border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-2xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500">

                    <button
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-sm font-medium transition">
                        Filter
                    </button>
                </form>

                {{-- ACTION --}}
                <div class="flex flex-wrap gap-3">

                    <a href="/sesikelas/rekap"
                        class="px-4 py-2 bg-slate-700 hover:bg-slate-800 text-white rounded-2xl text-sm font-medium transition">
                        📄 Rekap
                    </a>

                    <form id="generateForm" action="/sesikelas" method="POST">
                        @csrf
                        <input type="hidden" name="tgl" value="{{ $tgl?->toDateString() }}">

                        <button type="button"
                            onclick="confirmGenerate()"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-sm font-medium transition">
                            + Buat Sesi
                        </button>
                    </form>

                    <form id="bulkToggleForm" action="{{ route('sesi.bulkToggle') }}" method="POST">
                        @csrf

                        <button type="button"
                            onclick="confirmBulkToggle()"
                            class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl text-sm font-medium transition">
                            🔄 Toggle Status
                        </button>
                    </form>

                    <form id="bulkDeleteForm" action="/sesikelas/bulk-delete" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            onclick="confirmBulkDelete()"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl text-sm font-medium transition">
                            🗑 Hapus
                        </button>
                    </form>

                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div
            class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h3 class="font-bold text-slate-800 dark:text-white">
                    Daftar Sesi Presensi
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Monitoring progress presensi setiap kelas
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead class="bg-slate-100 dark:bg-slate-900 text-slate-700 dark:text-slate-300 text-sm">
                        <tr>
                            <th class="px-4 py-4 text-center">
                                <input type="checkbox"
                                    id="checkAll"
                                    class="rounded border-slate-300">
                            </th>

                            <th class="px-4 py-4 text-center">
                                No
                            </th>

                            <th class="px-4 py-4 text-left">
                                Kelas
                            </th>

                            <th class="px-4 py-4 text-center">
                                Status
                            </th>

                            <th class="px-4 py-4">
                                Progress
                            </th>

                            <th class="px-4 py-4 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">

                        @forelse($Datasesikelas as $sesi)

                        @php
                        $badge = match ($sesi->status_ui) {
                        'close' => 'bg-rose-100 text-rose-700',
                        'belum' => 'bg-slate-100 text-slate-700',
                        'proses' => 'bg-amber-100 text-amber-700',
                        default => 'bg-emerald-100 text-emerald-700',
                        };
                        @endphp

                        <tr
                            class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">

                            <td class="px-4 py-4 text-center">
                                <input type="checkbox"
                                    class="row-check rounded border-slate-300"
                                    value="{{ $sesi->id }}">
                            </td>

                            <td class="px-4 py-4 text-center text-slate-500">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-4">
                                <a href="{{ url('/absensikelas/' . $sesi->id) }}"
                                    class="font-semibold text-indigo-600 hover:text-indigo-700 hover:underline">

                                    {{ $sesi->nama_kelas }}
                                </a>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $sesi->hadir_count }} hadir dari
                                    {{ $sesi->peserta_count }} siswa
                                </p>
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ strtoupper($sesi->status_ui) }}
                                </span>
                            </td>

                            <td class="px-4 py-4 min-w-[220px]">

                                <div class="w-full h-3 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-3 rounded-full bg-indigo-500"
                                        style="width: {{ $sesi->progress }}%">
                                    </div>
                                </div>

                                <div class="flex justify-between mt-2 text-xs text-slate-500">
                                    <span>{{ $sesi->progress }}%</span>
                                    <span>
                                        {{ $sesi->hadir_count }}/{{ $sesi->peserta_count }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex justify-center gap-2 flex-wrap">

                                    <a href="/absensi/monitor/{{ $sesi->id }}"
                                        class="px-3 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium transition">
                                        👁 Monitor
                                    </a>

                                    @if ($sesi->status == 'open')

                                    <form id="toggle-form-{{ $sesi->id }}"
                                        action="{{ route('sesi.toggle', $sesi->id) }}"
                                        method="POST">

                                        @csrf

                                        <button type="button"
                                            onclick="confirmToggleForm('{{ $sesi->id }}', 'close')"
                                            class="px-3 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-medium transition">

                                            🔒 Close
                                        </button>
                                    </form>

                                    @else

                                    <form id="toggle-form-{{ $sesi->id }}"
                                        action="{{ route('sesi.toggle', $sesi->id) }}"
                                        method="POST">

                                        @csrf

                                        <button type="button"
                                            onclick="confirmToggleForm('{{ $sesi->id }}', 'open')"
                                            class="px-3 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium transition">

                                            🔓 Open
                                        </button>
                                    </form>

                                    @endif

                                    <form id="delete-form-{{ $sesi->id }}"
                                        action="/sesikelas/{{ $sesi->id }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            onclick="confirmDelete('{{ $sesi->id }}')"
                                            class="px-3 py-2 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-xs font-medium transition">
                                            🗑 Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="6"
                                class="text-center py-16">

                                <div class="flex flex-col items-center">
                                    <div class="text-5xl mb-4">
                                        📭
                                    </div>

                                    <h3 class="font-bold text-slate-700 dark:text-white text-lg">
                                        Tidak ada sesi presensi
                                    </h3>

                                    <p class="text-slate-500 mt-1">
                                        Belum ada data sesi pada tanggal ini
                                    </p>
                                </div>
                            </td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SWEETALERT --}}
    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | CHECK ALL
            |--------------------------------------------------------------------------
            */
            const checkAll = document.getElementById('checkAll');

            if (checkAll) {
                checkAll.addEventListener('change', function() {

                    document.querySelectorAll('.row-check')
                        .forEach(cb => {
                            cb.checked = this.checked;
                        });
                });
            }

        });

        /*
        |--------------------------------------------------------------------------
        | GET CHECKED ROWS
        |--------------------------------------------------------------------------
        */
        function checkedRows() {

            return document.querySelectorAll('.row-check:checked');
        }

        /*
        |--------------------------------------------------------------------------
        | APPEND IDS
        |--------------------------------------------------------------------------
        */
        function appendIds(formId, checked) {

            const form = document.getElementById(formId);

            if (!form) return null;

            form.querySelectorAll('input[name="ids[]"]')
                .forEach(el => el.remove());

            checked.forEach(cb => {

                let input = document.createElement('input');

                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;

                form.appendChild(input);
            });

            return form;
        }

        /*
        |--------------------------------------------------------------------------
        | POPUP
        |--------------------------------------------------------------------------
        */
        function popup(title, text, icon, callback = null) {

            Swal.fire({
                title: title,
                text: text,
                icon: icon,

                showCancelButton: true,

                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',

                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#64748b',

                background: '#fff',

                customClass: {
                    popup: 'rounded-3xl shadow-2xl',
                    confirmButton: 'rounded-xl px-5 py-2',
                    cancelButton: 'rounded-xl px-5 py-2',
                }

            }).then((result) => {

                if (result.isConfirmed && callback) {
                    callback();
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE SESSION
        |--------------------------------------------------------------------------
        */
        function confirmGenerate() {

            popup(
                'Generate Sesi?',
                'Buat sesi presensi baru?',
                'question',
                () => {
                    document.getElementById('generateForm').submit();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BULK DELETE
        |--------------------------------------------------------------------------
        */
        function confirmBulkDelete() {

            let checked = checkedRows();

            if (!checked.length) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops',
                    text: 'Pilih minimal 1 data',
                    confirmButtonColor: '#f59e0b'
                });

                return;
            }

            popup(
                'Hapus Data?',
                'Data akan dihapus permanen',
                'warning',
                () => {

                    appendIds('bulkDeleteForm', checked)
                        .submit();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BULK TOGGLE
        |--------------------------------------------------------------------------
        */
        function confirmBulkToggle() {

            let checked = checkedRows();

            if (!checked.length) {

                Swal.fire({
                    icon: 'warning',
                    title: 'Oops',
                    text: 'Pilih minimal 1 data',
                    confirmButtonColor: '#f59e0b'
                });

                return;
            }

            popup(
                'Toggle Status?',
                'Open / Close sesi terpilih?',
                'question',
                () => {

                    appendIds('bulkToggleForm', checked)
                        .submit();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DELETE SINGLE
        |--------------------------------------------------------------------------
        */
        function confirmDelete(id) {

            popup(
                'Hapus Sesi?',
                'Data tidak dapat dikembalikan',
                'warning',
                () => {

                    document.getElementById(
                        'delete-form-' + id
                    ).submit();
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TOGGLE SINGLE
        |--------------------------------------------------------------------------
        */
        function confirmToggle(url, status) {

            let text =
                status === 'close' ?
                'Sesi akan di CLOSE' :
                'Sesi akan di OPEN';

            let icon =
                status === 'close' ?
                'warning' :
                'question';

            popup(
                status === 'close' ?
                'Close Session?' :
                'Open Session?',
                text,
                icon,
                () => {

                    window.location.href = url;
                }
            );
        }
    </script>

    {{-- SUCCESS --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            confirmButtonColor: '#10b981',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
            confirmButtonColor: '#ef4444'
        });
    </script>
    @endif

</x-app-layout>