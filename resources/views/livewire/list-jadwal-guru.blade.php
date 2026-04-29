<div class="space-y-5">

    {{-- TOAST NOTIFICATION --}}
    @if(session('update'))
    <script>
        Toastify({
            text: "{{ session('update') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            close: true,
            style: {
                background: "linear-gradient(to right, #2563eb, #3b82f6)",
                borderRadius: "12px"
            }
        }).showToast();
    </script>
    @endif

    @if(session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            close: true,
            style: {
                background: "linear-gradient(to right, #16a34a, #22c55e)",
                borderRadius: "12px"
            }
        }).showToast();
    </script>
    @endif

    @if(session('delete'))
    <script>
        Toastify({
            text: "{{ session('delete') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            close: true,
            style: {
                background: "linear-gradient(to right, #dc2626, #ef4444)",
                borderRadius: "12px"
            }
        }).showToast();
    </script>
    @endif

    @if(session('error'))
    <script>
        Toastify({
            text: "{{ session('error') }}",
            duration: 4000,
            gravity: "top",
            position: "right",
            close: true,
            style: {
                background: "linear-gradient(to right, #991b1b, #ef4444)",
                borderRadius: "12px"
            }
        }).showToast();
    </script>
    @endif


    {{-- TOOLBAR --}}
    <div class="bg-white shadow-sm border rounded-2xl p-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- MENU --}}
            <div class="flex flex-wrap gap-2">
                <a href="/cetak-jadwal-1"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-medium transition">
                    Jadwal
                </a>

                <a href="/laporan-poling-guru"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition">
                    Laporan
                </a>

                <a href="/laporan-poling-guru-kelas"
                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-sm font-medium transition">
                    Ploting
                </a>

                <a href="/cetak-jadwal-kolektif"
                    class="btn-generate px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-medium transition">
                    Buat Jadwal
                </a>
            </div>

            {{-- FILTER --}}
            <div class="flex flex-col sm:flex-row gap-2">
                <input
                    type="search"
                    wire:model.live="search"
                    placeholder="Cari nama kelas..."
                    class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">

                <select
                    wire:model.live="perPage"
                    class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="6">6</option>
                    <option value="12">12</option>
                    <option value="18">18</option>
                    <option value="24">24</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>


    {{-- TABLE --}}
    <div class="bg-white shadow-sm border rounded-2xl overflow-hidden">

        {{-- HEADER --}}
        <div class="px-4 py-3 border-b bg-gray-50">
            <h3 class="font-semibold text-gray-800">
                Daftar Jadwal Guru
            </h3>
            <p class="text-sm text-gray-500">
                Data jadwal aktif guru dan mata pelajaran
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-center">No</th>
                        <th class="px-4 py-3 text-center">Hari</th>
                        <th class="px-4 py-3 text-center">Periode</th>
                        <th class="px-4 py-3 text-center">Kelas</th>
                        <th class="px-4 py-3 text-center">Mapel</th>
                        <th class="px-4 py-3">Guru</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($daftarJadwal as $jadwal)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3 text-center font-medium">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 text-center capitalize">
                            {{ $jadwal->hari }}
                        </td>

                        <td class="px-4 py-3 text-center text-sm">
                            {{ $jadwal->periode }} {{ $jadwal->ket_semester }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <a href="/jadwal-guru/{{ $jadwal->id }}"
                                class="text-blue-600 hover:text-blue-800 font-medium hover:underline">
                                {{ $jadwal->nama_kelas }}
                            </a>
                        </td>

                        <td class="px-4 py-3 text-center capitalize">
                            {{ $jadwal->mapel ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            @if($jadwal->nama_guru)
                            <span class="text-gray-800">
                                {{ $jadwal->jenis_kelamin == 'L' ? 'Bapak' : 'Ibu' }}
                                {{ $jadwal->nama_guru }}
                            </span>
                            @else
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                Belum terjadwal
                            </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            <form
                                action="/Daftar-Jadwal/{{ $jadwal->id }}"
                                method="post"
                                class="form-delete">
                                @csrf
                                @method('delete')

                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-500">
                            Tidak ada data jadwal ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-4 py-3 border-t bg-gray-50">
            {{ $daftarJadwal->links() }}
        </div>
    </div>
</div>
<script>
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Jadwal?',
                text: 'Data jadwal yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-2xl',
                    title: 'text-lg font-bold text-gray-800',
                    htmlContainer: 'text-sm text-gray-600',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-xl mx-2 transition',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-xl mx-2 transition'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // DELETE
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Hapus Jadwal?',
                    text: 'Data jadwal yang dihapus tidak bisa dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    buttonsStyling: false,
                    customClass: {
                        popup: 'rounded-2xl',
                        title: 'text-lg font-bold text-gray-800',
                        htmlContainer: 'text-sm text-gray-600',
                        confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-xl mx-2 transition',
                        cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-xl mx-2 transition'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });


        // GENERATE JADWAL
        document.querySelectorAll('.btn-generate').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                let url = this.getAttribute('href');

                Swal.fire({
                    title: 'Generate Jadwal?',
                    text: 'Sistem akan membuat jadwal kolektif berdasarkan periode aktif.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Generate',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    buttonsStyling: false,
                    customClass: {
                        popup: 'rounded-2xl',
                        title: 'text-lg font-bold text-gray-800',
                        htmlContainer: 'text-sm text-gray-600',
                        confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-xl mx-2 transition',
                        cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium px-4 py-2 rounded-xl mx-2 transition'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });

    });
</script>