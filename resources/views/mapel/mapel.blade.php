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
                    class="flex items-center justify-center gap-2 rounded-xl bg-white border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-all active:scale-95">
                    📄 Export
                </a>
                <a href="/addmapel"
                    class="flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 transition-all active:scale-95">
                    ➕ Mapel Baru
                </a>
                <form action="{{ route('mapel.generate-pengampu') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-emerald-700 transition-all active:scale-95">
                        ⚡ Generate
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 px-4 py-6 max-w-7xl mx-auto">

        {{-- ALERTS: Menggunakan Animate Pulse untuk perhatian --}}
        @foreach(['success' => 'green', 'delete' => 'red', 'update' => 'blue'] as $key => $color)
        @if(session($key))
        <div class="flex items-center gap-3 rounded-2xl border border-{{ $color }}-200 bg-{{ $color }}-50 px-4 py-3 text-sm text-{{ $color }}-700 shadow-sm animate-in fade-in slide-in-from-top-2">
            <span class="flex-shrink-0 text-lg">🔔</span>
            <p class="font-medium">{{ session($key) }}</p>
        </div>
        @endif
        @endforeach

        {{-- STATS GRID --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @php
            $stats = [
            ['label' => 'Total Mapel', 'val' => $listmapel->count(), 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
            ['label' => 'Total Kelas', 'val' => $listmapel->groupBy('kelas')->count(), 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-50'],
            ['label' => 'Ganjil', 'val' => $listmapel->where('ket_semester', 'Ganjil')->count(), 'color' => 'text-amber-600', 'bg' => 'bg-amber-50'],
            ['label' => 'Genap', 'val' => $listmapel->where('ket_semester', 'Genap')->count(), 'color' => 'text-purple-600', 'bg' => 'bg-purple-50'],
            ];
            @endphp
            @foreach($stats as $stat)
            <div class="rounded-3xl bg-white p-5 border border-slate-100 shadow-sm transition-hover hover:shadow-md">
                <p class="text-xs md:text-sm font-medium text-slate-500 uppercase tracking-wider">{{ $stat['label'] }}</p>
                <h3 class="mt-2 text-2xl md:text-3xl font-black {{ $stat['color'] }}">{{ $stat['val'] }}</h3>
            </div>
            @endforeach
        </div>

        {{-- MAIN CONTENT --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-5">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    🗂️ Manajemen Kurikulum
                </h3>
            </div>

            {{-- MOBILE VIEW: Card Layout (Hidden on Desktop) --}}
            <div class="block lg:hidden divide-y divide-slate-100">
                @forelse($listmapel as $list)
                <div class="p-5 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-block px-2 py-1 rounded-lg bg-slate-100 text-[10px] font-bold text-slate-600 uppercase mb-1">
                                {{ $list->periode }} | {{ $list->ket_semester }}
                            </span>
                            <h4 class="text-lg font-bold text-slate-900">{{ $list->mapel }}</h4>
                            <p class="text-sm text-slate-500 italic">{{ $list->nama_kitab ?: 'Tanpa Kitab' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            Kls {{ $list->kelas }}
                        </span>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <a href="/edit-mapel/{{ $list->id }}" class="flex-1 text-center py-2 bg-amber-50 text-amber-700 rounded-xl text-xs font-bold">Edit</a>
                        <a href="/mapel/{{ $list->id }}" class="flex-1 text-center py-2 bg-blue-50 text-blue-700 rounded-xl text-xs font-bold">Pengampu</a>
                        <form action="/mapel/{{ $list->id }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Hapus?')" class="w-full py-2 bg-red-50 text-red-600 rounded-xl text-xs font-bold">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400">Data tidak ditemukan.</div>
                @endforelse
            </div>

            {{-- DESKTOP VIEW: Table Layout (Hidden on Mobile) --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/80 text-[11px] uppercase tracking-widest text-slate-500 font-bold">
                        <tr>
                            <th class="px-6 py-4">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-center">Periode</th>
                            <th class="px-6 py-4 text-center">Kelas</th>
                            <th class="px-6 py-4 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($listmapel as $list)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $list->mapel }}</div>
                                <div class="text-xs text-slate-400">{{ $list->nama_kitab ?: '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold">
                                    {{ $list->periode }} ({{ $list->ket_semester }})
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-xs font-bold">
                                    {{ $list->kelas }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="/edit-mapel/{{ $list->id }}" class="p-2 bg-amber-100 text-amber-700 rounded-lg hover:bg-amber-200 transition">
                                        ✏️
                                    </a>
                                    <a href="/mapel/{{ $list->id }}" class="px-3 py-2 bg-blue-100 text-blue-700 rounded-lg text-xs font-bold hover:bg-blue-200 transition">
                                        Pengampu
                                    </a>
                                    <form action="/mapel/{{ $list->id }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Hapus?')" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>