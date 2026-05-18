<x-app-layout>
    @section('title', ' | Kurikulum')

    <x-slot name="header">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between px-2">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-900">
                    Kurikulum & Mata Pelajaran
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Kelola administrasi akademik, kitab, dan tenaga pengampu.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="/mapel/laporan/pdf" target="_blank"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                    📄 Export
                </a>

                <a href="/addmapel"
                    class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 transition">
                    ➕ Mapel Baru
                </a>

                <form action="{{ route('mapel.generate-pengampu') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-emerald-700 transition">
                        ⚡ Generate
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    @php
    $kelasList = $listmapel->pluck('kelas')->unique()->sort();
    $activeTab = request('tab', session('active_tab', $kelasList->first()));
    $filteredMapel = $listmapel->where('kelas', $activeTab);
    @endphp

    <div class="space-y-6 px-4 py-6 max-w-7xl mx-auto">

        {{-- STATS --}}
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">
            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Mapel</p>
                <h3 class="mt-3 text-3xl font-black text-blue-600">{{ $listmapel->count() }}</h3>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Total Kelas</p>
                <h3 class="mt-3 text-3xl font-black text-emerald-600">
                    {{ $listmapel->groupBy('kelas')->count() }}
                </h3>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Ganjil</p>
                <h3 class="mt-3 text-3xl font-black text-amber-600">
                    {{ $listmapel->where('ket_semester', 'Ganjil')->count() }}
                </h3>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Genap</p>
                <h3 class="mt-3 text-3xl font-black text-purple-600">
                    {{ $listmapel->where('ket_semester', 'Genap')->count() }}
                </h3>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Ada Pengampu</p>
                <h3 class="mt-3 text-3xl font-black text-green-600">
                    {{ $listmapel->where('gurus_count', '>', 0)->count() }}
                </h3>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Belum Ada</p>
                <h3 class="mt-3 text-3xl font-black text-red-600">
                    {{ $listmapel->where('gurus_count', 0)->count() }}
                </h3>
            </div>
        </div>

        {{-- NOTICE --}}
        <div id="notice-banner"
            class="rounded-3xl border border-blue-200 bg-gradient-to-r from-blue-50 to-indigo-50 shadow-sm">
            <div class="flex items-start justify-between gap-4 px-5 py-4">
                <div class="flex gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-md">
                        📘
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">Informasi Kurikulum Aktif</h3>
                        <p class="mt-1 text-sm text-slate-600">
                            Saat ini terdapat
                            <span class="font-bold text-blue-700">{{ $listmapel->count() }}</span>
                            mapel aktif pada
                            <span class="font-bold text-emerald-700">
                                {{ $listmapel->groupBy('kelas')->count() }}
                            </span> kelas.
                        </p>
                    </div>
                </div>

                <button onclick="closeNotice()" class="rounded-xl p-2 text-slate-400 hover:bg-white">
                    ✕
                </button>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">

            {{-- TAB --}}
            <div class="border-b border-slate-200 bg-slate-50 px-4 py-4">
                <div class="flex flex-wrap gap-2">
                    @foreach($kelasList as $kelas)
                    <a href="{{ route('mapel.index', ['tab' => $kelas]) }}"
                        class="rounded-xl px-4 py-2 text-sm font-semibold transition
                            {{ $activeTab == $kelas
                                ? 'bg-blue-600 text-white shadow-md'
                                : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-100' }}">
                        Kelas {{ $kelas }}
                        <span class="ml-2 rounded-lg bg-white/20 px-2 py-1 text-xs">
                            {{ $listmapel->where('kelas', $kelas)->sum('gurus_count') }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-3 text-left">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-center">Periode</th>
                            <th class="px-6 py-3 text-center">Kitab</th>
                            <th class="px-6 py-3 text-center">Pengampu</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($filteredMapel as $list)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $list->mapel }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                    {{ $list->periode }} ({{ $list->ket_semester }})
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center text-sm text-slate-600">
                                {{ $list->nama_kitab ?: '-' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($list->gurus_count > 0)
                                <span class="rounded-lg bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                    ✅ Ada ({{ $list->gurus_count }})
                                </span>
                                @else
                                <span class="rounded-lg bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                    ❌ Belum Ada
                                </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="/edit-mapel/{{ $list->id }}"
                                        class="rounded-lg bg-amber-100 px-3 py-2 text-xs font-bold text-amber-700 hover:bg-amber-200">
                                        Edit
                                    </a>

                                    <a href="/mapel/{{ $list->id }}"
                                        class="rounded-lg bg-blue-100 px-3 py-2 text-xs font-bold text-blue-700 hover:bg-blue-200">
                                        Pengampu
                                    </a>

                                    <form action="/mapel/{{ $list->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            onclick="confirmDelete(this.form, '{{ $list->mapel }}', {{ $list->gurus_count }})"
                                            class="rounded-lg bg-red-100 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-200">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                Tidak ada data mapel
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(form, nama, totalGuru) {
            let text = totalGuru > 0 ?
                `Mapel "${nama}" memiliki ${totalGuru} pengampu aktif.` :
                `Mapel "${nama}" akan dihapus permanen.`;

            Swal.fire({
                title: 'Yakin hapus data?',
                text: text,
                icon: totalGuru > 0 ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        function closeNotice() {
            document.getElementById('notice-banner').style.display = 'none';
            localStorage.setItem('hideMapelNotice', 'true');
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('hideMapelNotice') === 'true') {
                document.getElementById('notice-banner').style.display = 'none';
            }

            @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 3000
            });
            @endif

            @if(session('delete'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('delete')),
                showConfirmButton: false,
                timer: 3000
            });
            @endif

            @if(session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: @json(session('error')),
                showConfirmButton: false,
                timer: 3500
            });
            @endif
        });
    </script>
</x-app-layout>