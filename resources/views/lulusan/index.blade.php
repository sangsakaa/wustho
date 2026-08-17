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

        </div>
    </x-slot>


    <div class="p-4 lg:p-6 space-y-6">
        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Total Lulusan --}}
            <div class="rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-6 text-white shadow-sm">
                <p class="text-sm font-medium text-blue-100">
                    Total Lulusan
                </p>
                <h2 class="mt-2 text-4xl font-bold">
                    {{ $totalLulusan }}
                </h2>
            </div>

            {{-- Total Kelas --}}
            <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 text-white shadow-sm">
                <p class="text-sm font-medium text-emerald-100">
                    Total Kelas
                </p>
                <h2 class="mt-2 text-4xl font-bold">
                    {{ $totalKelas }}
                </h2>
            </div>

            {{-- Status Kelulusan --}}
            <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Status Input Kelulusan
                </p>

                <div class="flex items-center gap-2 mt-3">
                    <span class="w-3 h-3 rounded-full
                {{ $bolehLulus ? 'bg-emerald-500' : 'bg-red-500' }}">
                    </span>

                    <h2 class="text-xl font-bold
                {{ $bolehLulus ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $bolehLulus ? 'Aktif' : 'Nonaktif' }}
                    </h2>
                </div>

                <p class="text-xs text-slate-400 mt-2">
                    {{ count($dataLulusan) }} data telah tercatat
                </p>
            </div>

        </div>


        {{-- ALERT --}}
        @if(!$bolehLulus)
        <div class="flex items-start gap-3 rounded-xl border border-amber-200
                bg-amber-50 p-4 text-amber-700 shadow-sm">

            <span class="text-lg">⚠️</span>

            <div>
                <p class="font-semibold">
                    Input Kelulusan Ditutup
                </p>

                <p class="text-sm mt-1 text-amber-600">
                    Data kelulusan hanya dapat diinput pada
                    <span class="font-semibold">
                        kelas 3 semester genap
                    </span>.
                </p>
            </div>

        </div>
        @endif


        {{-- SUCCESS --}}
        @if(session('success'))
        <div class="rounded-xl border border-emerald-200
                bg-emerald-50 px-4 py-3 text-sm
                text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
        @endif


        {{-- ERROR --}}
        @if($errors->any())
        <div class="rounded-xl border border-red-200
                bg-red-50 p-4 text-red-700 shadow-sm">

            <p class="font-semibold text-sm mb-2">
                Terjadi kesalahan:
            </p>

            <ul class="list-disc pl-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
        @endif

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
                                <form action="/lulusan/{{ $list->id }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        onclick="openDeleteModal('{{ $list->id }}')"
                                        title="Hapus data"
                                        class="inline-flex items-center justify-center
                   w-9 h-9 rounded-xl
                   bg-red-50 text-red-500
                   border border-red-100
                   hover:bg-red-500 hover:text-white
                   hover:border-red-500
                   hover:scale-105
                   transition-all duration-200">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="w-4 h-4">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 7h12M9 7V4h6v3m-8 0
                         1 13h8l1-13M10 11v6m4-6v6" />
                                        </svg>
                                    </button>
                                </form>
                            </td>


                            {{-- MODAL KONFIRMASI HAPUS --}}
                            <div id="deleteModal"
                                class="fixed inset-0 z-50 hidden">

                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
                                    onclick="closeDeleteModal()"></div>

                                {{-- Modal --}}
                                <div class="relative flex min-h-full items-center justify-center p-4">

                                    <div id="deleteModalContent"
                                        class="w-full max-w-md rounded-2xl bg-white
                    shadow-2xl border border-slate-200
                    transform scale-95 opacity-0
                    transition-all duration-200">

                                        <div class="p-6">

                                            {{-- Icon --}}
                                            <div class="flex justify-center mb-4">
                                                <div class="flex items-center justify-center
                                w-14 h-14 rounded-2xl
                                bg-red-50 text-red-500">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.8"
                                                        stroke="currentColor"
                                                        class="w-7 h-7">

                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 9v4m0 4h.01M10.3 4.2
                                     2.8 14.8A2 2 0 0 0 15 17h6
                                     a2 2 0 0 0 1.7-2.2L17.7 4.2
                                     A2 2 0 0 0 15.8 3H12.2
                                     a2 2 0 0 0-1.9 1.2Z" />
                                                    </svg>
                                                </div>
                                            </div>

                                            {{-- Judul --}}
                                            <h3 class="text-lg font-bold text-center text-slate-800">
                                                Hapus Data Lulusan?
                                            </h3>

                                            {{-- Deskripsi --}}
                                            <p class="mt-2 text-sm text-center text-slate-500 leading-relaxed">
                                                Data lulusan yang dihapus tidak dapat dikembalikan.
                                                Apakah Anda yakin ingin melanjutkan?
                                            </p>

                                            {{-- Tombol --}}
                                            <div class="flex gap-3 mt-6">

                                                <button
                                                    type="button"
                                                    onclick="closeDeleteModal()"
                                                    class="flex-1 px-4 py-2.5 rounded-xl
                               border border-slate-200
                               bg-white text-slate-600
                               font-medium text-sm
                               hover:bg-slate-50
                               transition">
                                                    Batal
                                                </button>

                                                <button
                                                    type="button"
                                                    onclick="confirmDelete()"
                                                    class="flex-1 px-4 py-2.5 rounded-xl
                               bg-red-500 text-white
                               font-medium text-sm
                               hover:bg-red-600
                               shadow-sm
                               transition">
                                                    Ya, Hapus
                                                </button>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <script>
                                let deleteForm = null;

                                function openDeleteModal(id) {

                                    deleteForm = document.querySelector(
                                        `form[action$="/lulusan/${id}"]`
                                    );

                                    const modal = document.getElementById('deleteModal');
                                    const content = document.getElementById('deleteModalContent');

                                    modal.classList.remove('hidden');

                                    requestAnimationFrame(() => {
                                        content.classList.remove('scale-95', 'opacity-0');
                                        content.classList.add('scale-100', 'opacity-100');
                                    });
                                }

                                function closeDeleteModal() {

                                    const modal = document.getElementById('deleteModal');
                                    const content = document.getElementById('deleteModalContent');

                                    content.classList.remove('scale-100', 'opacity-100');
                                    content.classList.add('scale-95', 'opacity-0');

                                    setTimeout(() => {
                                        modal.classList.add('hidden');
                                        deleteForm = null;
                                    }, 200);
                                }

                                function confirmDelete() {

                                    if (deleteForm) {
                                        deleteForm.submit();
                                    }
                                }

                                // Tutup dengan tombol ESC
                                document.addEventListener('keydown', function(e) {
                                    if (e.key === 'Escape') {
                                        closeDeleteModal();
                                    }
                                });
                            </script>
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