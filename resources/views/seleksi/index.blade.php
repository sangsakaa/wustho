<x-app-layout>
    <x-slot name="header">
        @section('title',' | NOMINASI')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Manajemen Nominasi Ujian
                </h2>
                <p class="text-sm text-slate-500">
                    Kelola periode nominasi ujian siswa.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="p-4 space-y-5">

        {{-- SUCCESS --}}
        @if(session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
        @endif

        {{-- ERROR --}}
        @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
            {{ session('error') }}
        </div>
        @endif

        {{-- VALIDATION --}}
        @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 border border-red-200">
            <ul class="list-disc pl-5 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ALERT SEMESTER --}}
        @if(!$bolehNominasi)
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
            <h3 class="font-semibold text-amber-700">
                Input Ditutup
            </h3>
            <p class="text-sm text-amber-600 mt-1">
                Nominasi ujian hanya dapat dilakukan pada
                <span class="font-bold">semester genap</span>.
            </p>
        </div>
        @endif

        {{-- FORM --}}
        <div class="bg-white shadow-sm rounded-xl border overflow-hidden">
            <div class="px-5 py-4 border-b bg-slate-50">
                <h3 class="font-semibold text-slate-700">
                    Form Tambah Nominasi
                </h3>
            </div>

            <form action="/daftar-seleksi" method="POST" class="p-5">
                @csrf

                <fieldset {{ !$bolehNominasi ? 'disabled' : '' }}>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm font-medium text-slate-700">
                                Kelas
                            </label>
                            <select name="kelasmi_id"
                                class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($daftarKelas as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_kelas }} - {{ $item->periode }} {{ $item->ket_semester }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">
                                Periode Ujian
                            </label>
                            <select name="periode_id"
                                class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                                <option value="">-- Pilih Periode --</option>
                                @foreach($dataPeriode as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->periode }} {{ $item->ket_semester }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">
                                Tanggal Mulai
                            </label>
                            <input type="date" name="tanggal_mulai"
                                class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">
                                Tanggal Selesai
                            </label>
                            <input type="date" name="tanggal_selesai"
                                class="w-full mt-1 rounded-lg border-slate-300 text-sm">
                        </div>
                    </div>
                </fieldset>

                <div class="mt-5">
                    @if($bolehNominasi)
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm shadow-sm">
                        Simpan Nominasi
                    </button>
                    @else
                    <button disabled
                        class="px-5 py-2 bg-slate-400 text-white rounded-lg text-sm cursor-not-allowed">
                        Input Dinonaktifkan
                    </button>
                    @endif
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow-sm rounded-xl border overflow-hidden">
            <div class="px-5 py-4 border-b bg-slate-50">
                <h3 class="font-semibold text-slate-700">
                    Daftar Nominasi
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Tanggal Mulai</th>
                            <th class="px-4 py-3">Tanggal Selesai</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($nominasi as $item)
                        <tr class="border-t hover:bg-slate-50">
                            <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>

                            <td class="px-4 py-3 text-center">
                                <a href="/daftar-nominasi/{{ $item->id }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    {{ $item->nama_kelas }}
                                </a>
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->periode }} {{ $item->ket_semester }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('D MMMM Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('D MMMM Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="/daftar-seleksi/{{ $item->id }}" method="POST"
                                    onsubmit="return confirm('Hapus nominasi {{ $item->nama_kelas }}?')">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                Belum ada data nominasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>