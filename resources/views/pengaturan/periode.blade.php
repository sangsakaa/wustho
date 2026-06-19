<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Periode')

        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                Pengaturan Periode
            </h2>

            <p class="text-sm text-slate-500 dark:text-slate-400">
                Manajemen periode akademik dan semester sistem
            </p>
        </div>
    </x-slot>

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="p-4 space-y-5">

        {{-- TOP NAV --}}


        {{-- MAIN --}}
        <div class="bg-white dark:bg-dark-eval-1 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    {{-- LEFT --}}
                    <div>

                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                            Data Periode Akademik
                        </h3>

                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Kelola periode aktif, generate otomatis, dan status semester.
                        </p>

                    </div>

                    {{-- RIGHT --}}
                    <form id="generateForm"
                        action="{{ url('/periode/generate') }}"
                        method="POST">

                        @csrf

                        <button
                            type="button"
                            onclick="confirmGenerate()"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium shadow-sm transition">

                            <span>+</span>

                            <span>Generate Periode</span>

                        </button>

                    </form>

                </div>

            </div>

            {{-- INFO --}}
            @php
            $last = $periode->first();
            @endphp

            @if($last)

            <div class="px-6 pt-5">

                <div class="rounded-2xl border border-amber-200 bg-amber-50 dark:bg-amber-500/10 dark:border-amber-500/20 p-4">

                    <div class="flex items-start gap-3">

                        <div class="text-xl">
                            ⚠️
                        </div>

                        <div class="space-y-1">

                            <h4 class="font-semibold text-amber-800 dark:text-amber-300">
                                Informasi Generate
                            </h4>

                            <p class="text-sm text-amber-700 dark:text-amber-200">
                                Urutan generate:
                                <span class="font-semibold">
                                    Ganjil → Genap → Tahun Baru
                                </span>
                            </p>

                            <p class="text-sm text-amber-700 dark:text-amber-200">
                                Periode terakhir:
                                <span class="font-semibold">
                                    {{ $last->periode }}
                                    -
                                    {{ $last->semester->ket_semester }}
                                </span>
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            @endif

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50 dark:bg-slate-800/50">

                        <tr class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">

                            <th class="px-4 py-4 text-center">
                                Periode
                            </th>



                            <th class="px-4 py-4 text-center">
                                Hijriyah
                            </th>

                            <th class="px-4 py-4 text-center">
                                Status
                            </th>

                            <th class="px-4 py-4 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">

                        @forelse($periode as $list)

                        @php
                        $semester = strtolower($list->semester->ket_semester ?? '');

                        $badge = match($semester) {
                        'ganjil' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                        'genap' => 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300',
                        'pendek' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
                        default => 'bg-slate-100 text-slate-700',
                        };

                        $totalRelasi =
                        $list->kelasmi_count +
                        $list->asramasiswa_count +
                        $list->lulusan_count +
                        $list->nominasi_count;
                        @endphp

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">

                            {{-- PERIODE --}}
                            <td class="px-6 py-2">

                                <div class="flex items-center gap-3">

                                    <div>

                                        <div class="font-semibold text-slate-800 dark:text-white">
                                            {{ $list->periode }}
                                        </div>
                                        <div class="mt-1">

                                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                                {{ $list->semester->ket_semester }} | {{ $list->semester->semester }}
                                            </span>


                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- SEMESTER --}}
                            {{-- HIJRIYAH --}}
                            <td class="px-6 py-4 text-center">

                                <span class="text-slate-700 dark:text-slate-200">
                                    {{ $list->tahun_hijriyah }}
                                </span>

                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4 text-center">

                                @if($list->is_active)

                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300 text-xs font-semibold">

                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>

                                    Aktif

                                </span>

                                @else

                                <form
                                    id="aktifForm{{ $list->id }}"
                                    action="{{ url('/periode/aktifkan/'.$list->id) }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="button"
                                        onclick="confirmAktif({{ $list->id }})"
                                        class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-blue-500 hover:text-white text-slate-700 text-xs font-medium transition">

                                        Aktifkan

                                    </button>

                                </form>

                                @endif

                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2 flex-wrap">

                                    <a href="{{ url('/periode/' . $list->id) }}"
                                        class="px-3 py-1.5 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium transition">

                                        Detail

                                    </a>

                                    @if($totalRelasi > 0)

                                    <span
                                        class="px-3 py-1.5 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium">

                                        Dipakai ({{ $totalRelasi }})

                                    </span>

                                    @else

                                    <form
                                        id="deleteForm{{ $list->id }}"
                                        action="{{ url('/periode/' . $list->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="confirmDelete({{ $list->id }})"
                                            class="px-3 py-1.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-xs font-medium transition">

                                            Hapus

                                        </button>

                                    </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="py-14 text-center">

                                <div class="space-y-2">

                                    <div class="text-5xl">
                                        📚
                                    </div>

                                    <div class="font-medium text-slate-700 dark:text-slate-200">
                                        Belum ada data periode
                                    </div>

                                    <div class="text-sm text-slate-500">
                                        Silakan generate periode terlebih dahulu
                                    </div>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- SWEET ALERT --}}
    <script>
        function swalConfirm(config, callback) {

            Swal.fire({
                ...config,
                showCancelButton: true,
                reverseButtons: true,
                buttonsStyling: false,

                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-medium mr-2',
                    cancelButton: 'bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-xl font-medium'
                }

            }).then((result) => {

                if (result.isConfirmed) {
                    callback();
                }

            });
        }

        function confirmGenerate() {

            swalConfirm({
                title: 'Generate Periode?',
                text: 'Periode baru akan dibuat otomatis.',
                icon: 'question',
                confirmButtonText: 'Ya, Generate',
                cancelButtonText: 'Batal',
            }, () => {

                document.getElementById('generateForm').submit();

            });

        }

        function confirmDelete(id) {

            swalConfirm({
                title: 'Hapus Periode?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }, () => {

                document.getElementById('deleteForm' + id).submit();

            });

        }

        function confirmAktif(id) {

            swalConfirm({
                title: 'Aktifkan Periode?',
                text: 'Periode sistem akan diganti.',
                icon: 'question',
                confirmButtonText: 'Ya, Aktifkan',
                cancelButtonText: 'Batal',
            }, () => {

                document.getElementById('aktifForm' + id).submit();

            });

        }
    </script>

    {{-- SUCCESS --}}
    @if(session('success'))

    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session("success") }}',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true
        });
    </script>

    @endif

    {{-- ERROR --}}
    @if(session('error'))

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session("error") }}',
            confirmButtonText: 'Tutup',

            buttonsStyling: false,

            customClass: {
                popup: 'rounded-3xl',
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-medium'
            }
        });
    </script>

    @endif

</x-app-layout>