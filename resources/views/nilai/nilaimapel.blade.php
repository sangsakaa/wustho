<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Nilai Mata Pelajaran')

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Nilai Mata Pelajaran
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Kelola data nilai, guru, kelas dan progress pembelajaran
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto p-4 space-y-5">

        {{-- TOAST SUCCESS --}}
        @if(session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                close: true,
                style: {
                    background: "linear-gradient(to right,#16a34a,#22c55e)",
                    borderRadius: "12px"
                }
            }).showToast();
        </script>
        @endif

        {{-- TOAST ERROR --}}
        @if(session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                close: true,
                style: {
                    background: "linear-gradient(to right,#dc2626,#ef4444)",
                    borderRadius: "12px"
                }
            }).showToast();
        </script>
        @endif

        {{-- TOAST DELETE --}}
        @if(session('delete'))
        <script>
            Toastify({
                text: "{{ session('delete') }}",
                duration: 3000,
                gravity: "top",
                position: "right",
                close: true,
                style: {
                    background: "linear-gradient(to right,#b91c1c,#ef4444)",
                    borderRadius: "12px"
                }
            }).showToast();
        </script>
        @endif


        {{-- NOTE --}}
        @if($note)
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 shadow-sm">
            <div class="flex gap-3">
                <div class="text-2xl">⚠️</div>
                <div>
                    <h3 class="font-semibold text-red-700">
                        Generate tidak dapat diproses
                    </h3>
                    <p class="text-sm text-red-600">
                        {{ $note }}
                    </p>
                </div>
            </div>
        </div>
        @endif


        {{-- FORM --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl border p-5">
            <h3 class="text-sm font-semibold uppercase tracking-wide text-blue-600 mb-4">
                Form Tambah Nilai
            </h3>

            <form action="/nilaimapel" method="POST" class="grid md:grid-cols-4 gap-4">
                @csrf

                <select name="mapel_id"
                    class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900"
                    @disabled($note)>
                    <option value="">-- Mata Pelajaran --</option>
                    @foreach($dataMapel as $mapel)
                    <option value="{{ $mapel->id }}">
                        {{ $mapel->kelas }} - {{ $mapel->mapel }} - {{ $mapel->nama_kitab }}
                    </option>
                    @endforeach
                </select>

                <select name="guru_id"
                    class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900"
                    @disabled($note)>
                    <option value="">-- Guru --</option>
                    @foreach($dataGuru as $guru)
                    <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                    @endforeach
                </select>

                <select name="kelasmi_id"
                    class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900"
                    @disabled($note)>
                    <option value="">-- Kelas --</option>
                    @foreach($dataKelas as $kelas)
                    <option value="{{ $kelas->id }}">
                        {{ $kelas->nama_kelas }} - {{ $kelas->periode }} {{ $kelas->ket_semester }}
                    </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    @disabled($note)
                    class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white rounded-xl px-4 py-2 font-medium">
                    Simpan Data
                </button>
            </form>
        </div>


        {{-- TOOLBAR --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl border p-4">
            <div class="flex flex-col xl:flex-row justify-between gap-4">

                <div class="flex flex-wrap gap-2">
                    <a href="/mapel" class="px-4 py-2 bg-red-600 text-white rounded-xl text-sm">Mata Pelajaran</a>
                    <a href="/juara-pararel" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm">Laporan Nilai</a>
                    <a href="/progress-nilai" class="px-4 py-2 bg-purple-600 text-white rounded-xl text-sm">Progress</a>
                    <a href="/Daftar-Jadwal" class="px-4 py-2 bg-orange-600 text-white rounded-xl text-sm">Jadwal</a>
                </div>

                <div class="flex flex-col md:flex-row gap-2">
                    <form action="/nilaimapel" method="GET" class="flex gap-2">
                        <input type="text"
                            name="cari"
                            value="{{ request('cari') }}"
                            placeholder="Cari..."
                            class="rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900">

                        <button class="bg-gray-800 text-white px-4 rounded-xl">
                            Cari
                        </button>
                    </form>

                    <form action="{{ url('/nilai/generate') }}" method="POST" class="form-generate">
                        @csrf
                        <button
                            type="submit"
                            @disabled($note)
                            class="bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white px-4 py-2 rounded-xl text-sm font-medium">
                            Generate
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- TABLE --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th>Periode</th>
                            <th>Semester</th>
                            <th>Input</th>
                            <th>Guru</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th>Qty</th>
                            <th>NH</th>
                            <th>NU</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($data as $nilai)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td>{{ $nilai->periode }}</td>
                            <td>{{ $nilai->ket_semester }}</td>

                            <td>
                                <a href="/nilai/{{ $nilai->id }}"
                                    class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs">
                                    Input
                                </a>
                            </td>

                            <td>{{ $nilai->nama_guru }}</td>
                            <td>{{ $nilai->nama_kelas }}</td>
                            <td>{{ $nilai->mapel }}</td>
                            <td class="text-center">{{ $nilai->jumlah_peserta_kelas }}</td>
                            <td class="text-center">{{ $nilai->jumlah_nilai_harian }}</td>
                            <td class="text-center">{{ $nilai->jumlah_nilai_ujian }}</td>

                            <td>
                                <div class="flex gap-2 justify-center">
                                    <form action="/nilaimapel/{{ $nilai->id }}" method="POST" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
                                            Hapus
                                        </button>
                                    </form>

                                    <a href="/nilaimapel/{{ $nilai->id }}/edit"
                                        class="bg-yellow-400 px-3 py-1 rounded-lg text-xs">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-8 text-red-500">
                                Data tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            {{ $data->links() }}
        </div>
    </div>
</x-app-layout>


<script>
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data tidak bisa dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });

    document.querySelectorAll('.form-generate').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Generate Nilai?',
                text: 'Generate otomatis dari jadwal pembelajaran?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, generate',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>