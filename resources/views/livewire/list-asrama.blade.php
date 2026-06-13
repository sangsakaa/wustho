<div class="space-y-6">

    {{-- ================= MAIN CARD ================= --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">

        {{-- ================= HEADER ================= --}}
        <div class="p-5 border-b border-gray-100 dark:border-gray-800">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                {{-- TITLE --}}
                <div>

                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Dashboard Asrama
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Monitoring kuota dan penghuni asrama
                    </p>

                </div>

                {{-- ACTION BUTTON --}}
                <div class="flex flex-wrap gap-3">

                    <a href="/addasramasiswa"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">

                        + Asrama Siswa

                    </a>

                    <a href="/asrama"
                        class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">

                        Data Asrama

                    </a>

                    <form id="generateForm"
                        action="/generate-asrama-periode"
                        method="POST">

                        @csrf

                        <button type="button"
                            onclick="confirmGenerate()"
                            class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">

                            Generate Periode

                        </button>

                    </form>

                </div>

            </div>

        </div>

        {{-- ================= INFORMASI GENERATE ================= --}}
        <div class="px-5 pt-5">

            <div class="rounded-2xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 overflow-hidden">

                {{-- HEADER --}}
                <div class="flex items-center gap-3 px-5 py-4 border-b border-amber-200 dark:border-amber-800">

                    <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-800 flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-amber-600 dark:text-amber-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                        </svg>

                    </div>

                    <div>

                        <h3 class="text-sm font-bold text-amber-800 dark:text-amber-200">
                            Aturan Generate Periode
                        </h3>

                        <p class="text-xs text-amber-700 dark:text-amber-300 mt-1">
                            Harap membaca informasi berikut sebelum melakukan generate periode baru.
                        </p>

                    </div>

                </div>

                {{-- CONTENT --}}
                <div class="p-5 grid md:grid-cols-2 gap-4">

                    {{-- LEFT --}}
                    <div class="space-y-3">

                        <div class="flex items-start gap-3">

                            <div class="mt-1 w-2 h-2 rounded-full bg-amber-500"></div>

                            <p class="text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                                Generate periode akan membuat data periode asrama baru secara otomatis.
                            </p>

                        </div>

                        <div class="flex items-start gap-3">

                            <div class="mt-1 w-2 h-2 rounded-full bg-amber-500"></div>

                            <p class="text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                                Data periode sebelumnya tidak akan terhapus dari sistem.
                            </p>

                        </div>

                        <div class="flex items-start gap-3">

                            <div class="mt-1 w-2 h-2 rounded-full bg-amber-500"></div>

                            <p class="text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                                Sistem akan menyalin konfigurasi asrama dan kuota dari data aktif saat ini.
                            </p>

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="space-y-3">

                        <div class="flex items-start gap-3">

                            <div class="mt-1 w-2 h-2 rounded-full bg-red-500"></div>

                            <p class="text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                                Jangan melakukan generate lebih dari satu kali untuk periode yang sama.
                            </p>

                        </div>

                        <div class="flex items-start gap-3">

                            <div class="mt-1 w-2 h-2 rounded-full bg-red-500"></div>

                            <p class="text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                                Pastikan data asrama dan kuota sudah benar sebelum generate dilakukan.
                            </p>

                        </div>

                        <div class="flex items-start gap-3">

                            <div class="mt-1 w-2 h-2 rounded-full bg-red-500"></div>

                            <p class="text-sm text-amber-800 dark:text-amber-200 leading-relaxed">
                                Setelah generate selesai, data periode baru akan langsung aktif digunakan.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- ================= STATISTIC ================= --}}
        <div class="p-5 grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-blue-50 dark:bg-gray-800 rounded-2xl p-4">

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Total Asrama
                </p>

                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $data->count() }}
                </p>

            </div>

            <div class="bg-emerald-50 dark:bg-gray-800 rounded-2xl p-4">

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Total Kuota
                </p>

                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $data->sum('kuota') }}
                </p>

            </div>

            <div class="bg-amber-50 dark:bg-gray-800 rounded-2xl p-4">

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Terisi
                </p>

                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $data->sum('jumlah_nilai_ujian') }}
                </p>

            </div>

            <div class="bg-purple-50 dark:bg-gray-800 rounded-2xl p-4">

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Sisa
                </p>

                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $data->sum('kuota') - $data->sum('jumlah_nilai_ujian') }}
                </p>

            </div>

        </div>

        {{-- ================= SEARCH + ACTION ================= --}}
        <div class="px-5 pb-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <input type="search"
                placeholder="Cari asrama..."
                class="w-full md:w-80 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 dark:text-white rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">

            <button type="button"
                onclick="confirmBulkDelete()"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">

                Delete Selected

            </button>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="overflow-x-auto">

            <form id="bulkDeleteForm"
                method="POST"
                action="{{ route('bulk.delete.asrama') }}">

                @csrf
                @method('DELETE')

                <table class="min-w-full text-sm">

                    {{-- TABLE HEAD --}}
                    <thead class="bg-gray-50 dark:bg-gray-800 text-xs uppercase text-gray-600 dark:text-gray-300">

                        <tr>

                            <th class="px-4 py-3 text-left w-10">

                                <input type="checkbox"
                                    onclick="toggleAll(this)">

                            </th>

                            <th class="px-4 py-3 text-left">No</th>

                            <th class="px-4 py-3 text-left">Asrama</th>

                            <th class="px-4 py-3 text-center">Tipe</th>

                            <th class="px-4 py-3 text-center">Kuota</th>

                            <th class="px-4 py-3 text-center">Terisi</th>

                            <th class="px-4 py-3 text-center">Status</th>

                            <th class="px-4 py-3 text-center">Aksi</th>

                        </tr>

                    </thead>

                    {{-- TABLE BODY --}}
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse ($data as $item)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                            <td class="px-4 py-3">

                                <input type="checkbox"
                                    class="rowCheckbox"
                                    value="{{ $item->id }}">

                            </td>

                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                {{ $item->asrama->nama_asrama }}
                            </td>

                            <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-300">
                                {{ ucfirst($item->asrama->type_asrama) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->kuota }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->pesertaasrama_count }}
                            </td>

                            <td class="px-4 py-3 text-center">

                                @if($item->jumlah_nilai_ujian >= $item->kuota)

                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                                    Penuh
                                </span>

                                @else

                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                    Tersedia
                                </span>

                                @endif

                            </td>

                            <td class="px-4 py-3 text-center">

                                <div class="flex items-center justify-center gap-3">

                                    <a href="/asramasiswa/{{ $item->id }}/edit"
                                        class="text-blue-600 hover:underline">

                                        Edit

                                    </a>

                                    <a href="/pesertaasrama/{{ $item->id }}"
                                        class="text-emerald-600 hover:underline">

                                        Detail

                                    </a>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-10 text-gray-500 dark:text-gray-400">

                                Data tidak ditemukan

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </form>

        </div>

    </div>

</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>
    const swalBase = {
        background: 'rgb(17 24 39)',
        color: '#fff'
    };

    function toggleAll(source) {

        document.querySelectorAll('.rowCheckbox').forEach((checkbox) => {
            checkbox.checked = source.checked;
        });
    }

    function getSelectedIds() {

        return [...document.querySelectorAll('.rowCheckbox:checked')]
            .map((checkbox) => checkbox.value);
    }

    function confirmBulkDelete() {

        const ids = getSelectedIds();

        if (ids.length === 0) {

            Swal.fire({
                ...swalBase,
                icon: 'warning',
                title: 'Pilih data terlebih dahulu'
            });

            return;
        }

        Swal.fire({
            ...swalBase,
            title: 'Hapus Data?',
            text: `${ids.length} data akan dihapus`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (!result.isConfirmed) return;

            const form = document.getElementById('bulkDeleteForm');

            form.querySelectorAll('.dynamic-id').forEach((el) => {
                el.remove();
            });

            ids.forEach((id) => {

                const input = document.createElement('input');

                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                input.classList.add('dynamic-id');

                form.appendChild(input);
            });

            form.submit();
        });
    }

    function confirmGenerate() {

        Swal.fire({
            ...swalBase,
            title: 'Generate periode baru?',
            text: 'Pastikan data asrama dan kuota sudah benar.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Generate',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                document.getElementById('generateForm').submit();
            }
        });
    }
</script>