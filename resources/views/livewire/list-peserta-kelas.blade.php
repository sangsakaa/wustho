<div class="space-y-5">

    {{-- NOTIFICATION --}}
    @if (session()->has('success'))
    <div class="p-4 rounded-2xl bg-green-100 border border-green-200 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="p-4 rounded-2xl bg-red-100 border border-red-200 text-red-700">
        {{ session('error') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="p-4 rounded-2xl bg-red-100 border border-red-200 text-red-700">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    {{-- HEADER SUMMARY --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-4 rounded-2xl shadow-sm">
            <p class="text-xs opacity-80">Kelas</p>
            <h3 class="text-lg font-bold mt-1">{{ $datakelasmi->nama_kelas }}</h3>
        </div>

        <div class="bg-gradient-to-r from-emerald-500 to-green-600 text-white p-4 rounded-2xl shadow-sm">
            <p class="text-xs opacity-80">Kuota</p>
            <h3 class="text-2xl font-bold mt-1">{{ $datakelasmi->kuota }}</h3>
        </div>

        <div class="bg-gradient-to-r from-violet-500 to-purple-600 text-white p-4 rounded-2xl shadow-sm">
            <p class="text-xs opacity-80">Peserta</p>
            <h3 class="text-2xl font-bold mt-1">{{ $hitung }}</h3>
        </div>

        <div class="bg-gradient-to-r from-pink-500 to-rose-500 text-white p-4 rounded-2xl shadow-sm">
            <p class="text-xs opacity-80">Jenis Kelamin</p>
            <div class="flex justify-between mt-2 text-sm font-semibold">
                <span>Laki: {{ $lk }}</span>
                <span>Per: {{ $pr }}</span>
            </div>
        </div>
    </div>


    {{-- ACTION BAR --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
        <div class="flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">

            {{-- SEARCH --}}
            <div class="relative w-full lg:w-72">
                <input type="search"
                    wire:model.live.debounce.500ms="search"
                    placeholder="Cari nama / NIS..."
                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-slate-400 absolute left-3 top-3"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35M11 18a7 7 0 1 1 0-14 7 7 0 0 1 0 14Z" />
                </svg>
            </div>

            {{-- BUTTONS --}}
            <div class="flex flex-wrap gap-2">

                <a href="/pesertakolektif/{{ $kelasmi }}"
                    class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                    Input Kolektif
                </a>

                <a href="/kelas_mi"
                    class="px-4 py-2 rounded-xl bg-slate-500 hover:bg-slate-600 text-white text-sm font-medium transition">
                    Kembali
                </a>

                <button onclick="window.print()"
                    class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium transition">
                    <x-icons.print />
                    Print
                </button>

                @if(count($selected) > 0)
                <button
                    onclick="if(confirm('Hapus data terpilih?')) { @this.call('deleteSelected') }"
                    class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition">
                    Hapus {{ count($selected) }}
                </button>
                @endif
            </div>
        </div>
    </div>


    {{-- TABLE --}}
    <div id="print-area"
        class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto max-h-[650px]">
            <table class="w-full text-sm">

                <thead class="bg-slate-50 sticky top-0 z-10">
                    <tr class="text-slate-600 uppercase text-xs tracking-wider">
                        <th class="px-4 py-3 text-center">
                            <input type="checkbox" wire:model="selectAll"
                                class="rounded border-slate-300">
                        </th>
                        <th class="px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-center">NIS</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-center">JK</th>
                        <th class="px-4 py-3 text-center">Kelas</th>
                        <th class="px-4 py-3 text-center print:hidden">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($dataKelas as $list)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-4 py-3 text-center">
                            <input type="checkbox"
                                value="{{ $list->id }}"
                                wire:model="selected"
                                class="rounded border-slate-300">
                        </td>

                        <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-center font-medium">{{ $list->nis }}</td>

                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-700 truncate max-w-[220px]">
                                {{ ucwords(strtolower($list->nama_siswa)) }}
                            </div>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $list->jenis_kelamin == 'L'
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'bg-pink-100 text-pink-700' }}">
                                {{ $list->jenis_kelamin }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">{{ $list->nama_kelas }}</td>

                        <td class="px-4 py-3 text-center print:hidden">
                            <div class="flex justify-center gap-2">

                                <a href="/pesertakelas/{{ $list->id }}/edit"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition">
                                    <x-icons.edit />
                                </a>

                                <form action="/pesertakelas/{{ $list->id }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-100 text-red-600 hover:bg-red-200 transition">
                                        <x-icons.hapus />
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            Tidak ada data ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #print-area,
        #print-area * {
            visibility: visible;
        }

        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none !important;
            border: none !important;
        }
    }
</style>