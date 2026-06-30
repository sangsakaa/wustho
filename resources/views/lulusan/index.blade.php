<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Lulusan')

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Manajemen Data Lulusan
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola periode kelulusan, tanggal sidang, dan administrasi lulusan siswa.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">



            </div>
        </div>
    </x-slot>


    <div class="p-4 lg:p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow">
                <p class="text-sm opacity-80">
                    Total Lulusan
                </p>

                <h1 class="text-4xl font-bold mt-2">
                    {{ $totalLulusan }}
                </h1>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white shadow">
                <p class="text-sm opacity-80">
                    Total Kelas
                </p>

                <h1 class="text-4xl font-bold mt-2">
                    {{ $totalKelas }}
                </h1>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow">
                <p class="text-sm opacity-80">
                    Data Kelulusan
                </p>

                <h1 class="text-4xl font-bold mt-2">
                    {{ count($dataLulusan) }}
                </h1>
            </div>


        </div>



        {{-- SUCCESS --}}
        @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-700 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 shadow-sm">
            <h3 class="font-semibold text-red-700 mb-2">
                Terjadi kesalahan:
            </h3>
            <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ALERT SEMESTER --}}
        @if(!$bolehLulus)
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 shadow-sm">
            <div class="flex gap-3">
                <div class="text-xl">⚠️</div>
                <div>
                    <h3 class="font-semibold text-amber-700">
                        Input Ditutup
                    </h3>
                    <p class="text-sm text-amber-600 mt-1">
                        Data kelulusan hanya dapat diinput pada
                        <span class="font-semibold">kelas 3 semester genap</span>.
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border shadow-sm p-5">
                <p class="text-sm text-slate-500">Total Data Lulusan</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-2">
                    {{ count($dataLulusan) }}
                </h3>
            </div>

            <div class="bg-white rounded-xl border shadow-sm p-5">
                <p class="text-sm text-slate-500">Status Input</p>
                <h3 class="text-xl font-bold mt-2 {{ $bolehLulus ? 'text-green-600' : 'text-red-600' }}">
                    {{ $bolehLulus ? 'Aktif' : 'Nonaktif' }}
                </h3>
            </div>

            <div class="bg-white rounded-xl border shadow-sm p-5">
                <p class="text-sm text-slate-500">Periode Aktif</p>
                <h3 class="text-xl font-bold text-slate-700 mt-2">
                    {{ session('periode_id') }}
                </h3>
            </div>
        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b bg-slate-50">
                <h3 class="font-semibold text-slate-700">
                    Form Input Data Lulusan
                </h3>
            </div>

            <form action="/lulusan" method="POST" class="p-6">
                @csrf

                <fieldset {{ !$bolehLulus ? 'disabled' : '' }}>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Periode Lulusan
                            </label>
                            <select name="periode_id"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                @foreach($dataPeriode as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->periode }} {{ $item->ket_semester }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Kelas
                            </label>
                            <select name="kelasmi_id"
                                class="w-full rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                                @foreach($kelasMi as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_kelas }} - {{ $item->periode }} {{ $item->ket_semester }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Mulai
                            </label>
                            <input type="date" name="tanggal_mulai"
                                class="w-full rounded-lg border-slate-300 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Selesai
                            </label>
                            <input type="date" name="tanggal_selesai"
                                class="w-full rounded-lg border-slate-300 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Kelulusan
                            </label>
                            <input type="date" name="tanggal_kelulusan"
                                class="w-full rounded-lg border-slate-300 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Tanggal Hijriyah
                            </label>
                            <input type="text"
                                name="tanggal_lulus_hijriyah"
                                placeholder="12 Rabi'ul Awwal 1444 H"
                                class="w-full rounded-lg border-slate-300 text-sm">
                        </div>
                    </div>
                </fieldset>

                <div class="mt-5 flex items-center justify-between flex-wrap gap-3">
                    <p class="text-xs text-slate-500">
                        Data bersumber dari bagian kurikulum sekolah.
                    </p>

                    @if($bolehLulus)
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm text-sm font-medium transition">
                        Simpan Data
                    </button>
                    @else
                    <button disabled
                        class="px-5 py-2.5 bg-slate-400 text-white rounded-lg cursor-not-allowed text-sm font-medium">
                        Input Dinonaktifkan
                    </button>
                    @endif
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between px-6 py-4 border-b bg-slate-50">

                <div>
                    <h3 class="text-lg font-semibold text-slate-800">
                        Daftar Data Lulusan
                    </h3>
                    <p class="text-sm text-slate-500">
                        Kelola data lulusan dan transkrip siswa.
                    </p>
                </div>

                <a href="/daftar-transkip"
                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-emerald-700 hover:shadow-md">

                    <x-heroicon-o-document-text class="w-5 h-5" />

                    <span>Daftar Transkrip</span>
                </a>

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 border">No</th>
                            <th class="px-4 py-3 border">Periode</th>
                            <th class="px-4 py-3 border">Kelas</th>
                            <th class="px-4 py-3 border">Mulai</th>
                            <th class="px-4 py-3 border">Selesai</th>
                            <th class="px-4 py-3 border">Kelulusan</th>
                            <th class="px-4 py-3 border">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @forelse($dataLulusan as $list)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>

                            <td class="px-4 py-3 text-center">
                                <a href="/daftar-lulusan/{{ $list->id }}"
                                    class="text-blue-600 font-medium hover:underline">
                                    {{ $list->periode }} {{ $list->ket_semester }}
                                </a>
                            </td>

                            <td class="px-4 py-3 text-center">{{ $list->nama_kelas }}
                                {{$list->jumlah_lulusan}}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ \Carbon\Carbon::parse($list->tanggal_mulai)->isoFormat('D MMM Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ \Carbon\Carbon::parse($list->tanggal_selesai)->isoFormat('D MMM Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div>
                                    {{ \Carbon\Carbon::parse($list->tanggal_kelulusan)->isoFormat('D MMMM Y') }}
                                </div>
                                <small class="text-slate-500">
                                    {{ $list->tanggal_lulus_hijriyah }}
                                </small>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="/lulusan/{{ $list->id }}" method="POST"
                                    onsubmit="return confirm('Hapus data lulusan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs shadow-sm transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-400">
                                Belum ada data lulusan tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>