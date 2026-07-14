<div class="space-y-6">

    {{-- ================= SWEET ALERT ================= --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- ================= SESSION ALERT ================= --}}
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#2563eb'
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626'
        });
    </script>
    @endif

    @if (session('info'))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: "{{ session('info') }}",
            confirmButtonColor: '#0ea5e9'
        });
    </script>
    @endif

    {{-- ================= DELETE CONFIRM ================= --}}
    <script>
        function confirmDelete(form) {

            Swal.fire({
                title: 'Yakin hapus data?',
                text: 'Data tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    {{-- ================= HEADER ================= --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="p-6 border-b border-slate-100">

            <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

                {{-- TITLE --}}
                <div>

                    <h2 class="text-3xl font-bold tracking-tight text-slate-800">
                        Dashboard Kelas MI
                    </h2>

                    <p class="text-sm text-slate-500 mt-2">
                        Monitoring kuota, jumlah siswa, dan proses generate kenaikan kelas.
                    </p>

                </div>

                {{-- ACTION --}}
                <div class="flex flex-wrap items-center gap-3">

                    <a href="/addkelas_mi"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-sm font-medium shadow transition">

                        <span>➕</span>
                        <span>Tambah Kelas</span>

                    </a>
                    @if(session('periode_pdf'))
                    <a
                        href="{{ route('kelas.generate.pdf', session('periode_pdf')) }}"
                        target="_blank"
                        class="btn btn-danger">
                        Download PDF Ploting
                    </a>
                    @endif

                    <form action="{{ route('kelasmi.generatePeriode') }}"
                        method="POST">

                        @csrf

                        <input type="hidden"
                            name="mode"
                            value="auto">

                        <button type="submit"
                            onclick="return confirm('Yakin generate naik kelas? Semua data akan diproses otomatis!')"
                            class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-sm font-medium shadow transition">

                            <span>🔄</span>
                            <span>Generate Naik Kelas</span>

                        </button>

                    </form>
                    <form
                        action="{{ route('kelasmi.generate-kelas-satu') }}"
                        method="POST"
                        onsubmit="return confirm('Generate kelas 1 untuk periode berikutnya?')">

                        @csrf

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                            Generate Kelas 1
                        </button>
                    </form>

                </div>

            </div>

        </div>

        {{-- ================= FLOW INFO ================= --}}
        <div class="p-4 bg-gradient-to-r from-slate-50 via-white to-blue-50 border-b border-slate-200">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- FLOW GENERATE --}}
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5">

                    <div class="flex items-center gap-3 mb-4">

                        <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">

                            {{-- HEROICON --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z" />

                            </svg>

                        </div>

                        <div>
                            <h3 class="text-base font-bold text-slate-800">
                                Alur Generate
                            </h3>

                            <p class="text-xs text-slate-500">
                                Proses kenaikan kelas otomatis
                            </p>
                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-3">

                        <div class="flex gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">

                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center shrink-0">
                                1
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-700">
                                    Ambil Data
                                </p>

                                <p class="text-xs text-slate-500">
                                    Periode aktif dibaca otomatis
                                </p>
                            </div>

                        </div>

                        <div class="flex gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">

                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center shrink-0">
                                2
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-700">
                                    Naik Tingkat
                                </p>

                                <p class="text-xs text-slate-500">
                                    Kelas 1 → 2 → 3
                                </p>
                            </div>

                        </div>

                        <div class="flex gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">

                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center shrink-0">
                                3
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-700">
                                    Rombel Tetap
                                </p>

                                <p class="text-xs text-slate-500">
                                    A / B / C tidak berubah
                                </p>
                            </div>

                        </div>

                        <div class="flex gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">

                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center shrink-0">
                                4
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-700">
                                    Kelas Akhir
                                </p>

                                <p class="text-xs text-slate-500">
                                    Otomatis dinyatakan lulus
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- WARNING --}}
                <div class="bg-white border border-amber-200 rounded-2xl shadow-sm p-5">

                    <div class="flex items-center gap-3 mb-4">

                        <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center">

                            {{-- HEROICON --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-amber-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />

                            </svg>

                        </div>

                        <div>
                            <h3 class="text-base font-bold text-slate-800">
                                Perhatian
                            </h3>

                            <p class="text-xs text-slate-500">
                                Pastikan data sudah valid
                            </p>
                        </div>

                    </div>

                    <div class="space-y-3">

                        <div class="flex items-start gap-3 text-sm text-slate-600">

                            <div class="w-2 h-2 rounded-full bg-red-500 mt-2"></div>

                            <p>
                                Generate hanya dilakukan <span class="font-semibold">1x per periode</span>.
                            </p>

                        </div>

                        <div class="flex items-start gap-3 text-sm text-slate-600">

                            <div class="w-2 h-2 rounded-full bg-red-500 mt-2"></div>

                            <p>
                                Pastikan kuota kelas sudah benar sebelum proses dimulai.
                            </p>

                        </div>

                        <div class="flex items-start gap-3 text-sm text-slate-600">

                            <div class="w-2 h-2 rounded-full bg-red-500 mt-2"></div>

                            <p>
                                Data lama tetap aman dan tidak akan terhapus.
                            </p>

                        </div>

                        <div class="flex items-start gap-3 text-sm text-slate-600">

                            <div class="w-2 h-2 rounded-full bg-red-500 mt-2"></div>

                            <p>
                                Disarankan backup database sebelum generate.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ================= STATISTIC ================= --}}
        <div class="p-6 grid grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-blue-600 text-white rounded-3xl p-5 shadow-sm">

                <p class="text-sm opacity-80">
                    Total Kelas
                </p>

                <h3 class="text-3xl font-bold mt-2">
                    {{ $listkelas->count() }}
                </h3>

            </div>

            <div class="bg-emerald-600 text-white rounded-3xl p-5 shadow-sm">

                <p class="text-sm opacity-80">
                    Total Kuota
                </p>

                <h3 class="text-3xl font-bold mt-2">
                    {{ $listkelas->sum('kuota') }}
                </h3>

            </div>

            <div class="bg-amber-500 text-white rounded-3xl p-5 shadow-sm">

                <p class="text-sm opacity-80">
                    Total Terisi
                </p>

                <h3 class="text-3xl font-bold mt-2">
                    {{ $listkelas->sum('jumlah_nilai_ujian') }}
                </h3>

            </div>

            <div class="bg-purple-600 text-white rounded-3xl p-5 shadow-sm">

                <p class="text-sm opacity-80">
                    Sisa Kuota
                </p>

                <h3 class="text-3xl font-bold mt-2">
                    {{ $listkelas->sum('kuota') - $listkelas->sum('jumlah_nilai_ujian') }}
                </h3>

            </div>

        </div>

        {{-- ================= SEARCH ================= --}}
        <div class="px-6 pb-6">

            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">

                <div class="relative max-w-md ml-auto">

                    <input type="search"
                        wire:model.live="search"
                        placeholder="Cari nama kelas..."
                        class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

                </div>

            </div>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="overflow-x-auto border-t border-slate-100">

            <table class="min-w-full text-sm">

                {{-- TABLE HEAD --}}
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs">

                    <tr>

                        <th class="px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-center">Periode</th>
                        <th class="px-4 py-3 text-center">Tingkat</th>
                        <th class="px-4 py-3 text-center">Jenjang</th>
                        <th class="px-4 py-3 text-left">Nama Kelas</th>
                        <th class="px-4 py-3 text-center">Kuota</th>
                        <th class="px-4 py-3 text-center">Terisi</th>
                        <th class="px-4 py-3 text-center">Progress</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>

                    </tr>

                </thead>

                {{-- TABLE BODY --}}
                <tbody class="divide-y divide-slate-100 overflow-auto">

                    @forelse ($listkelas as $item)

                    @php
                    $progress = $item->kuota > 0
                    ? ($item->jumlah_nilai_ujian / $item->kuota) * 100
                    : 0;
                    @endphp

                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-4 py-2 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-2 text-center text-slate-600">
                            {{ $item->periode }} {{ $item->ket_semester }}
                        </td>

                        <td class="px-4 py-2 text-center">

                            <a href="/pesertakelas/{{$item->id}}"
                                class="font-medium text-blue-600 hover:underline">

                                {{ $item->kelas }}

                            </a>

                        </td>

                        <td class="px-4 py-2 text-center text-slate-600">
                            {{ $item->jenjang }}
                        </td>

                        <td class="px-4 py-2">

                            <div class="font-semibold text-slate-700">
                                {{ $item->nama_kelas }}
                            </div>

                            @if($item->kelas_id == 3)

                            <span class="inline-flex mt-2 px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-600">
                                Lulus
                            </span>

                            @endif

                        </td>

                        <td class="px-4 py-2 text-center font-medium">
                            {{ $item->kuota }}
                        </td>

                        <td class="px-4 py-2 text-center font-medium">
                            {{ $item->jumlah_nilai_ujian }}
                        </td>

                        {{-- PROGRESS --}}
                        <td class="px-4 py-2">

                            <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">

                                <div class="bg-blue-500 h-3 rounded-full"
                                    style="width: {{ min($progress, 100) }}%">
                                </div>

                            </div>

                            <p class="text-xs text-slate-500 mt-1 text-center">
                                {{ round($progress) }}%
                            </p>

                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-2 text-center">

                            @if($item->jumlah_nilai_ujian == $item->kuota)

                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                Full
                            </span>

                            @elseif($item->jumlah_nilai_ujian > $item->kuota)

                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">
                                Overload
                            </span>

                            @else

                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                                Tersedia
                            </span>

                            @endif

                        </td>

                        {{-- ACTION --}}
                        <td class="px-4 py-2">

                            <div class="flex items-center justify-center gap-2">

                                <a href="/kelas_mi/{{$item->id}}/edit"
                                    class="w-10 h-10 rounded-xl bg-yellow-100 hover:bg-yellow-200 flex items-center justify-center transition">

                                    ✏️

                                </a>

                                <a href="/pesertakelas/{{$item->id}}"
                                    class="w-10 h-10 rounded-xl bg-sky-100 hover:bg-sky-200 flex items-center justify-center transition">

                                    👁

                                </a>

                                <form action="/kelas_mi/{{$item->id}}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        onclick="confirmDelete(this.form)"
                                        class="w-10 h-10 rounded-xl bg-red-100 hover:bg-red-200 flex items-center justify-center transition">

                                        🗑

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10"
                            class="text-center py-12 text-slate-400">

                            Data kelas tidak ditemukan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>