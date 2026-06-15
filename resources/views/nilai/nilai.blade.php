<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-white">
            Dashboard Input Nilai Kelas
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 space-y-4">

            {{-- HEADER CARD --}}
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-2xl shadow-lg text-white overflow-hidden">
                <div class="p-6">

                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

                        <div>
                            <h1 class="text-2xl font-bold">
                                Input Nilai Siswa
                            </h1>
                            <p class="text-blue-100">
                                {{$titlenilai->mapel}}
                                @role('super admin')
                                - {{$titlenilai->nama_kitab}}
                                @endrole
                            </p>
                        </div>

                        <div class="text-right">
                            <div class="text-sm text-blue-100">
                                {{$titlenilai->periode}}
                            </div>
                            <div class="font-semibold">
                                {{$titlenilai->ket_semester}}
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            {{-- INFO CARD --}}
            <div class="grid md:grid-cols-4 grid-cols-2 gap-4">

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow p-4">
                    <div class="text-gray-500 text-sm">
                        Kelas
                    </div>
                    <div class="font-bold text-lg">
                        {{$titlenilai->nama_kelas}}
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow p-4">
                    <div class="text-gray-500 text-sm">
                        Semester
                    </div>
                    <div class="font-bold text-lg">
                        {{$titlenilai->semester}}
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow p-4">
                    <div class="text-gray-500 text-sm">
                        Guru
                    </div>
                    <div class="font-bold text-lg">
                        {{$titlenilai->nama_guru}}
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-xl shadow p-4">
                    <div class="text-gray-500 text-sm">
                        Jumlah Siswa
                    </div>
                    <div class="font-bold text-lg">
                        {{ count($dataSiswa) }}
                    </div>
                </div>

            </div>

            {{-- FORM --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg overflow-hidden">

                <form action="/nilai" method="POST" id="formNilai">
                    @csrf

                    <div class="p-4 border-b">

                        <div class="flex flex-col md:flex-row justify-between gap-3">

                            <div>
                                <input
                                    type="text"
                                    id="searchSiswa"
                                    placeholder="Cari nama siswa..."
                                    class="w-full md:w-80 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="flex gap-2">

                                @role('super admin')
                                <a href="/nilaimapel"
                                    class="px-4 py-2 rounded-xl bg-gray-500 hover:bg-gray-600 text-white">
                                    Kembali
                                </a>
                                @endrole

                                @role('guru')
                                <a href="/nilaiperguru"
                                    class="px-4 py-2 rounded-xl bg-gray-500 hover:bg-gray-600 text-white">
                                    Kembali
                                </a>
                                @endrole

                                <button
                                    type="submit"
                                    id="btnSubmit"
                                    class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white flex items-center gap-2 shadow">

                                    <svg id="loadingIcon"
                                        class="hidden animate-spin h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24">

                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4">
                                        </circle>

                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8v8z">
                                        </path>

                                    </svg>

                                    <span id="btnText">
                                        Simpan Nilai
                                    </span>

                                </button>

                            </div>

                        </div>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead class="bg-slate-800 text-white sticky top-0">

                                <tr>
                                    <th class="px-3 py-3 text-center">No</th>

                                    @role('super admin')
                                    <th class="px-3 py-3 text-center">NIS</th>
                                    @endrole

                                    <th class="px-3 py-3">Nama Siswa</th>

                                    @role('super admin')
                                    <th class="px-3 py-3 text-center">KLS</th>
                                    @endrole

                                    <th class="px-3 py-3 text-center">Kelas</th>
                                    <th class="px-3 py-3 text-center">NH</th>
                                    <th class="px-3 py-3 text-center">NU</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($dataSiswa as $item)

                                <tr class="border-b hover:bg-blue-50 dark:hover:bg-slate-700 siswa-row">

                                    <td class="text-center py-2">
                                        {{$loop->iteration}}

                                        <input type="hidden" name="pesertakelas[]" value="{{$item->id}}">
                                        <input type="hidden" name="nilai_id[{{$item->id}}]" value="{{$item->nilai_id}}">
                                        <input type="hidden" name="semester_id" value="{{$item->id}}">
                                    </td>

                                    @role('super admin')
                                    <td class="text-center">
                                        {{$item->nis}}
                                    </td>
                                    @endrole

                                    <td class="capitalize px-2 nama-siswa">
                                        {{ strtolower($item->nama_siswa) }}
                                    </td>

                                    @role('super admin')
                                    <td class="text-center">
                                        {{$item->kelas}}
                                    </td>
                                    @endrole

                                    <td class="text-center">
                                        {{$item->nama_kelas}}
                                    </td>

                                    <td class="p-2">
                                        <input
                                            type="number"
                                            min="0"
                                            max="100"
                                            value="{{$item->nilai_harian}}"
                                            name="nilai_harian[{{$item->id}}]"
                                            class="nilai-input w-20 mx-auto text-center rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500">
                                    </td>

                                    <td class="p-2">
                                        <input
                                            type="number"
                                            min="0"
                                            max="100"
                                            value="{{$item->nilai_ujian}}"
                                            name="nilai_ujian[{{$item->id}}]"
                                            class="nilai-input w-20 mx-auto text-center rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500">
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    <input
                        type="hidden"
                        name="nilaimapel_id"
                        value="{{$nilaimapel->id}}">

                </form>

            </div>

        </div>
    </div>

    {{-- TOAST --}}
    <div id="toast"
        class="hidden fixed top-5 right-5 z-50 rounded-xl bg-red-600 text-white px-5 py-3 shadow-xl">
    </div>

    <script>
        const inputs = document.querySelectorAll('.nilai-input');
        const btn = document.getElementById('btnSubmit');
        const form = document.getElementById('formNilai');
        const loadingIcon = document.getElementById('loadingIcon');
        const btnText = document.getElementById('btnText');

        function showToast(message) {

            const toast = document.getElementById('toast');

            toast.innerText = message;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 2500);
        }

        function validate() {

            let valid = true;

            inputs.forEach(input => {

                const value = parseInt(input.value);

                input.classList.remove(
                    'border-red-500',
                    'bg-red-100'
                );

                if (
                    value > 100 ||
                    value < 0
                ) {

                    valid = false;

                    input.classList.add(
                        'border-red-500',
                        'bg-red-100'
                    );
                }

            });

            btn.disabled = !valid;

            btn.classList.toggle(
                'opacity-50',
                !valid
            );

            return valid;
        }

        inputs.forEach(input => {

            input.addEventListener('input', () => {

                if (!validate()) {
                    showToast('Nilai harus antara 0 - 100');
                }

            });

        });

        form.addEventListener('submit', function(e) {

            if (!validate()) {

                e.preventDefault();

                showToast(
                    'Perbaiki nilai yang salah terlebih dahulu'
                );

                return;
            }

            btn.disabled = true;

            loadingIcon.classList.remove('hidden');

            btnText.innerText = 'Menyimpan...';
        });

        document.getElementById('searchSiswa')
            .addEventListener('keyup', function() {

                let value = this.value.toLowerCase();

                document.querySelectorAll('.siswa-row')
                    .forEach(row => {

                        let nama = row
                            .querySelector('.nama-siswa')
                            .innerText
                            .toLowerCase();

                        row.style.display =
                            nama.includes(value) ?
                            '' :
                            'none';
                    });

            });
    </script>
</x-app-layout>