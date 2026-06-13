{{-- =========================
    NOTIFIKASI
========================= --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: @json(session('error')),
        timer: 2500,
        showConfirmButton: false
    });
</script>
@endif


{{-- =========================
    ACTION BAR
========================= --}}
<div class="bg-white border rounded-xl shadow-sm p-3 flex flex-wrap items-center gap-2">

    <a href="/asramasiswa"
        class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
        Kembali
    </a>

    <form method="GET" class="ml-auto">
        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama, NIS, kota..."
            class="px-3 py-2 border rounded-lg text-sm focus:ring focus:ring-blue-200">
    </form>

    <a href="/kolektifasrama/{{ $asramasiswa }}"
        class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg">
        Tambah
    </a>

    <button onclick="printContent('div1')"
        class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg">
        Print
    </button>

    {{-- BULK DELETE --}}
    <form action="/pesertaasrama/bulk-delete-peserata" method="POST" id="bulkDeleteForm">
        @csrf

        <button type="button"
            onclick="confirmBulkDelete()"
            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg">
            Hapus Terpilih
        </button>
    </form>

</div>


{{-- =========================
    TABLE
========================= --}}
<div id="div1" class="bg-white border rounded-xl shadow-sm overflow-hidden">

    <div class="p-3 border-b flex items-center justify-between">
        <h2 class="font-semibold text-gray-700">
            Data Peserta Asrama
        </h2>

        <span class="text-xs text-gray-500">
            Total: {{ count($datapeserta) }}
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600">
                <tr>

                    {{-- SELECT ALL --}}
                    <th class="p-3 text-center">
                        <input type="checkbox" id="checkAll">
                    </th>

                    <th class="p-3">No</th>

                    @role('super admin')
                    <th class="p-3">NIS</th>
                    @endrole

                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-center">JK</th>
                    <th class="p-3 text-center">Asrama</th>
                    <th class="p-3 text-center">Kota</th>

                    @role('super admin')
                    <th class="p-3 text-center">Aksi</th>
                    @endrole

                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($datapeserta as $siswa)
                <tr class="hover:bg-gray-50 transition">

                    {{-- CHECKBOX --}}
                    <td class="p-3 text-center">
                        <input type="checkbox"
                            class="checkItem"
                            value="{{ $siswa->id }}">
                    </td>

                    <td class="p-3 text-center text-gray-500">
                        {{ $loop->iteration }}
                    </td>

                    {{-- NIS --}}
                    @role('super admin')
                    <td class="p-3 text-center font-mono text-xs">
                        {!! $this->highlight($siswa->nis) !!}
                    </td>
                    @endrole

                    {{-- NAMA --}}
                    <td class="p-3 font-medium capitalize">
                        {!! $this->highlight($siswa->nama_siswa) !!}
                    </td>

                    {{-- JK --}}
                    <td class="p-3 text-center">
                        <span class="px-2 py-1 text-xs rounded-full
                            {{ $siswa->jenis_kelamin == 'laki-laki'
                                ? 'bg-blue-100 text-blue-700'
                                : 'bg-pink-100 text-pink-700' }}">
                            {{ $siswa->jenis_kelamin }}
                        </span>
                    </td>

                    {{-- ASRAMA --}}
                    <td class="p-3 text-center">
                        {!! $this->highlight($siswa->nama_asrama ?? '-') !!}
                    </td>

                    {{-- KOTA --}}
                    <td class="p-3 text-center text-gray-600">
                        {!! $this->highlight($siswa->kota_asal) !!}
                    </td>

                    {{-- AKSI --}}
                    @role('super admin')
                    <td class="p-3">
                        <div class="flex justify-center gap-2">

                            {{-- DELETE --}}
                            <form action="/pesertaasrama/{{ $siswa->id }}" method="POST"
                                onsubmit="event.preventDefault();
                                Swal.fire({
                                    title: 'Yakin hapus?',
                                    text: 'Data peserta akan dihapus',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#dc2626',
                                    cancelButtonColor: '#6b7280',
                                    confirmButtonText: 'Ya, hapus',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) this.submit();
                                });">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-white border text-red-600 hover:bg-red-50 rounded-lg">
                                    🗑
                                </button>
                            </form>

                            {{-- EDIT --}}
                            <a href="/pesertaasrama/{{ $siswa->id }}/edit"
                                class="inline-flex items-center justify-center w-8 h-8 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg">
                                ✏
                            </a>

                        </div>
                    </td>
                    @endrole

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-6 text-center text-gray-500">
                        Tidak ada data peserta.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>


{{-- =========================
    SCRIPT BULK DELETE
========================= --}}
<script>
    function confirmBulkDelete() {

        let checked = document.querySelectorAll('.checkItem:checked');

        if (!checked.length) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada data dipilih'
            });
            return;
        }

        Swal.fire({
            title: 'Hapus data terpilih?',
            text: checked.length + ' data akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus'
        }).then((result) => {

            if (!result.isConfirmed) return;

            let form = document.getElementById('bulkDeleteForm');

            document.querySelectorAll('.hidden-id').forEach(e => e.remove());

            checked.forEach(cb => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                input.classList.add('hidden-id');
                form.appendChild(input);
            });

            form.submit();
        });
    }


    // SELECT ALL
    document.getElementById('checkAll')?.addEventListener('change', function() {
        document.querySelectorAll('.checkItem').forEach(cb => {
            cb.checked = this.checked;
        });
    });
</script>