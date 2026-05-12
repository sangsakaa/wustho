<div
    x-data="{
        selected: @entangle('selected').live ?? [],

        toggleAll(event) {
            const checked = event.target.checked;

            this.selected = checked
                ? Array.from(document.querySelectorAll('.checkItem')).map(el => el.value)
                : [];

            document.querySelectorAll('.checkItem').forEach(cb => cb.checked = checked);
        },

        toggleItem(id, el) {
            id = id.toString();

            if (el.checked) {
                if (!this.selected.includes(id)) this.selected.push(id);
            } else {
                this.selected = this.selected.filter(i => i !== id);
            }
        },

        toast(message, type = 'success') {
            const bg = type === 'success' ? 'bg-green-600' : 'bg-red-600';

            const el = document.createElement('div');
            el.className = `${bg} fixed top-5 right-5 text-white px-4 py-2 rounded-lg shadow z-50`;
            el.innerText = message;

            document.body.appendChild(el);
            setTimeout(() => el.remove(), 2000);
        }
    }"
    class="space-y-4">

    {{-- 🔥 ACTION BAR --}}
    <div class="bg-white border rounded-xl shadow-sm p-3 flex flex-wrap items-center gap-2">

        <a href="/asramasiswa"
            class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
            ⬅ Kembali
        </a>

        <a href="/kolektifasrama/{{ $asramasiswa }}"
            class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-lg transition">
            + Tambah
        </a>

        <button onclick="printContent('div1')"
            class="px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition">
            🖨 Print
        </button>

        <input type="search"
            wire:model.debounce.500ms="search"
            class="border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200"
            placeholder="Cari nama siswa...">

        <button wire:click="deleteSelected"
            class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition">
            🗑 Hapus
        </button>

    </div>

    {{-- 📊 TABLE --}}
    <div id="div1" class="bg-white border rounded-xl shadow-sm overflow-hidden">

        <div class="p-3 border-b flex items-center justify-between">
            <h2 class="font-semibold text-gray-700">Data Peserta Asrama</h2>

            <span class="text-xs text-gray-500">
                Total: {{ count($datapeserta) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-3">
                            <input type="checkbox" @change="toggleAll($event)">
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

                    @foreach($datapeserta as $siswa)

                    @php
                    $asrama = strtolower($siswa->nama_asrama ?? '');
                    $jk = strtolower($siswa->jenis_kelamin);

                    $salahAsrama =
                    (str_contains($asrama, 'putra') && $jk == 'perempuan') ||
                    (str_contains($asrama, 'putri') && $jk == 'laki-laki');
                    @endphp

                    <tr
                        class="hover:bg-gray-50 transition"
                        :class="selected.includes('{{ (string) $siswa->id }}') ? 'bg-blue-50' : ''">

                        <td class="p-3 text-center">
                            <input type="checkbox"
                                class="checkItem"
                                value="{{ $siswa->id }}"
                                @change="toggleItem('{{ $siswa->id }}', $event.target)">
                        </td>

                        <td class="p-3 text-center text-gray-500">
                            {{ $loop->iteration }}
                        </td>

                        @role('super admin')
                        <td class="p-3 text-center font-mono text-xs">
                            {{ $siswa->nis }}
                        </td>
                        @endrole

                        <td class="p-3 font-medium capitalize">
                            {{ strtolower($siswa->nama_siswa) }}
                        </td>

                        <td class="p-3 text-center">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $siswa->jenis_kelamin == 'laki-laki' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ $siswa->jenis_kelamin }}
                            </span>
                        </td>

                        <td class="p-3 text-center">
                            <span class="text-sm">
                                {{ $siswa->nama_asrama ?? '-' }}
                            </span>
                        </td>

                        <td class="p-3 text-center text-gray-600">
                            {{ $siswa->kota_asal }}
                        </td>

                        @role('super admin')
                        <td class="p-3">
                            <div class="flex justify-center gap-2">

                                <form action="/pesertaasrama/{{$siswa->id}}" method="POST"
                                    onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-2 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs">
                                        ❌
                                    </button>
                                </form>

                                <a href="/pesertaasrama/{{$siswa->id}}/edit"
                                    class="px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-xs">
                                    ✏
                                </a>

                            </div>
                        </td>
                        @endrole

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

</div>