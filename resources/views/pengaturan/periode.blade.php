<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Periode')

        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-800">
                    Pengaturan Periode
                </h2>
                <p class="text-sm text-slate-500">
                    Manajemen periode akademik dan semester
                </p>
            </div>
        </div>
    </x-slot>

    {{-- SWEET ALERT CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="p-4 space-y-4">

        {{-- NAVIGATION --}}
        <div class="bg-white shadow-sm border border-slate-200 rounded-2xl p-4">
            <div class="flex gap-2 text-sm">
                <a href="{{ url('/periode') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                    Periode
                </a>

                <a href="{{ url('/pengaturan') }}"
                    class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition">
                    Pengaturan
                </a>
            </div>
        </div>

        {{-- MAIN CARD --}}
        <div class="bg-white shadow-sm border border-slate-200 rounded-2xl p-5 space-y-5">

            @php
            $last = $periode->first();
            @endphp

            {{-- INFO --}}
            @if($last)
            <div class="rounded-xl border border-amber-300 bg-amber-50 p-4">
                <div class="flex gap-3">
                    <div class="text-xl">⚠️</div>
                    <div>
                        <h3 class="font-semibold text-amber-800">
                            Informasi Generate Periode
                        </h3>

                        <p class="text-sm text-amber-700 mt-1">
                            Generate dilakukan berurutan:
                            <span class="font-semibold">Ganjil → Genap → Tahun Baru</span>
                        </p>

                        <p class="text-sm text-amber-700 mt-1">
                            Periode terakhir:
                            <span class="font-semibold">
                                {{ $last->periode }}
                                ({{ $last->semester->ket_semester }})
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            {{-- BUTTON GENERATE --}}
            <div class="bg-slate-50 rounded-xl border p-4">
                <form id="generateForm" action="{{ url('/periode/generate') }}" method="POST">
                    @csrf

                    <button type="button"
                        onclick="confirmGenerate()"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 text-sm font-medium shadow">
                        + Generate Periode Otomatis
                    </button>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-slate-200 rounded-xl overflow-hidden">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-xs">
                        <tr>
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Periode</th>
                            <th class="p-3 border">Semester</th>
                            <th class="p-3 border">Hijriyah</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($periode as $list)
                        <tr class="hover:bg-slate-50">

                            <td class="border text-center">{{ $loop->iteration }}</td>

                            <td class="border text-center font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <span>{{ $list->periode }}</span>

                                    @if(strtolower($list->semester->ket_semester) == 'ganjil')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-medium">
                                        Ganjil
                                    </span>
                                    @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                        Genap
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td class="border text-center">
                                {{ $list->semester->semester }}
                            </td>

                            <td class="border text-center">
                                {{ $list->tahun_hijriyah }}
                            </td>

                            {{-- STATUS --}}
                            <td class="border text-center">
                                @if($list->is_active)
                                <span class="px-3 py-1 bg-green-500 text-white rounded-lg text-xs">
                                    Aktif
                                </span>
                                @else
                                <form action="{{ url('/periode/aktifkan/'.$list->id) }}" method="POST">
                                    @csrf
                                    <button
                                        class="px-3 py-1 bg-slate-400 text-white rounded-lg text-xs hover:bg-blue-500 transition">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="border px-3 py-2">
                                <div class="flex justify-center gap-2 flex-wrap">

                                    <a href="{{ url('/periode/' . $list->id) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 text-xs transition">
                                        Detail
                                    </a>

                                    @php
                                    $totalRelasi =
                                    $list->kelasmi_count +
                                    $list->asramasiswa_count +
                                    $list->lulusan_count +
                                    $list->nominasi_count;
                                    @endphp

                                    @if($totalRelasi > 0)
                                    <button disabled
                                        class="px-3 py-1 bg-slate-400 text-white rounded-lg text-xs cursor-not-allowed opacity-70">
                                        Dipakai ({{ $totalRelasi }})
                                    </button>
                                    @else
                                    <form id="deleteForm{{ $list->id }}"
                                        action="{{ url('/periode/' . $list->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            onclick="confirmDelete({{ $list->id }})"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-slate-500">
                                Belum ada data periode
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmGenerate() {
            Swal.fire({
                title: 'Generate Periode?',
                text: 'Periode baru akan dibuat sesuai urutan semester.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Generate',
                cancelButtonText: 'Batal',

                buttonsStyling: false,

                customClass: {
                    confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2 rounded-lg mr-2',
                    cancelButton: 'bg-slate-500 hover:bg-slate-600 text-white font-medium px-4 py-2 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('generateForm').submit();
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Periode?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',

                buttonsStyling: false,

                customClass: {
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg mr-2',
                    cancelButton: 'bg-slate-500 hover:bg-slate-600 text-white font-medium px-4 py-2 rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + id).submit();
                }
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
            timer: 4000,
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

            buttonsStyling: false,

            customClass: {
                popup: 'rounded-2xl shadow-xl',
                title: 'text-red-600 text-xl font-bold',
                htmlContainer: 'text-slate-600',
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg'
            },

            confirmButtonText: 'Tutup'
        });
    </script>
    @endif
</x-app-layout>