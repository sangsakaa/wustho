<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard Input Nilai Kelas') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <!-- HEADER -->
        <div class="bg-white dark:bg-purple-600 shadow-sm">
            <div class="py-1">
                <span class="sm:text-2xl text-sm px-2 text-blue-400">Input Nilai</span>
            </div>
            <hr>
            <div class="grid sm:grid-cols-4 grid-cols-2 sm:px-4 px-2 py-2">
                <div>Kelas / Semester</div>
                <div>: {{$titlenilai->nama_kelas}} / {{$titlenilai->semester}}</div>

                <div>Mata Pelajaran</div>
                <div>
                    : {{$titlenilai->mapel}}
                    @role('super admin')/{{$titlenilai->nama_kitab}}@endrole
                </div>

                <div>Guru</div>
                <div>: {{$titlenilai->nama_guru}}</div>

                <div>Periode</div>
                <div>: {{$titlenilai->periode}} {{$titlenilai->ket_semester}}</div>
            </div>
        </div>

        <!-- FORM -->
        <div class="bg-white dark:bg-dark-bg shadow-sm mt-2 p-2">
            <form action="/nilai" method="post" id="formNilai">
                @csrf

                <!-- BUTTON -->
                <div class="flex justify-end mb-2">
                    <div class="grid grid-cols-2 gap-2">
                        @role('super admin')
                        <button id="btnSubmit"
                            class="bg-red-600 hover:bg-red-700 py-1 rounded-md text-white px-4 transition">
                            simpan nilai
                        </button>
                        <a href="/nilaimapel"
                            class="bg-gray-500 hover:bg-gray-600 py-1 rounded-md text-white px-4 text-center">
                            Kembali
                        </a>
                        @endrole

                        @role('guru')
                        <button id="btnSubmit"
                            class="bg-red-600 hover:bg-red-700 py-1 rounded-md text-white px-4 transition">
                            simpan nilai
                        </button>
                        <a href="/nilaiperguru"
                            class="bg-gray-500 hover:bg-gray-600 py-1 rounded-md text-white px-4 text-center">
                            Kembali
                        </a>
                        @endrole
                    </div>
                </div>

                <!-- TABLE -->
                <div class="overflow-auto">
                    <table class="mt-2 w-full border">
                        <thead>
                            <tr class="border bg-gray-100">
                                <th class="border px-1">NO</th>
                                @role('super admin')
                                <th class="border px-1">NIS</th>
                                @endrole
                                <th class="border px-1">NAMA</th>
                                @role('super admin')
                                <th class="border px-1">KLS</th>
                                @endrole
                                <th class="border px-1">KELAS</th>
                                <th class="border px-1">NH</th>
                                <th class="border px-1">NU</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($dataSiswa as $item)
                            <tr class="border siswa-row">
                                <td class="text-center border">
                                    {{$loop->iteration}}
                                    <input type="hidden" name="pesertakelas[]" value="{{$item->id}}">
                                    <input type="hidden" name="nilai_id[{{$item->id}}]" value="{{$item->nilai_id}}">
                                    <input type="hidden" name="semester_id" value="{{$item->id}}">
                                </td>

                                @role('super admin')
                                <td class="border text-center">{{$item->nis}}</td>
                                @endrole

                                <td class="border capitalize">
                                    {{strtolower($item->nama_siswa)}}
                                </td>

                                @role('super admin')
                                <td class="border text-center">{{$item->kelas}}</td>
                                @endrole

                                <td class="border text-center">{{$item->nama_kelas}}</td>

                                <!-- NH -->
                                <td class="border">
                                    <input type="number"
                                        value="{{$item->nilai_harian}}"
                                        name="nilai_harian[{{$item->id}}]"
                                        class="nilai-input w-full text-center border rounded"
                                        min="0" max="100">
                                </td>

                                <!-- NU -->
                                <td class="border">
                                    <input type="number"
                                        value="{{$item->nilai_ujian}}"
                                        name="nilai_ujian[{{$item->id}}]"
                                        class="nilai-input w-full text-center border rounded"
                                        min="0" max="100">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <input type="hidden" name="nilaimapel_id" value="{{$nilaimapel->id}}">
            </form>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast"
        class="hidden fixed top-5 right-5 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50">
    </div>

    <!-- SCRIPT -->
    <script>
        const inputs = document.querySelectorAll('.nilai-input');
        const btn = document.getElementById('btnSubmit');

        function showToast(msg) {
            const toast = document.getElementById('toast');
            toast.innerText = msg;
            toast.classList.remove('hidden');

            setTimeout(() => toast.classList.add('hidden'), 2000);
        }

        function validate() {
            let valid = true;

            inputs.forEach(input => {
                const value = parseInt(input.value);
                const row = input.closest('.siswa-row');

                input.classList.remove('border-red-500', 'bg-red-100');
                row.classList.remove('bg-red-100');

                if (value > 100 || value < 0) {
                    valid = false;

                    input.classList.add('border-red-500', 'bg-red-100');
                    row.classList.add('bg-red-100');
                }
            });

            btn.disabled = !valid;
            btn.classList.toggle('opacity-50', !valid);

            return valid;
        }

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                if (!validate()) {
                    showToast("Nilai harus 0 - 100");
                }
            });
        });

        document.getElementById('formNilai').addEventListener('submit', function(e) {
            if (!validate()) {
                e.preventDefault();
                showToast("Perbaiki nilai yang salah!");
            }
        });
    </script>

</x-app-layout>