<div x-data="{
    selected: [],
    toggleAll(event) {
        let checked = event.target.checked;
        this.selected = checked ? [...document.querySelectorAll('.checkItem')].map(el => el.value) : [];
        document.querySelectorAll('.checkItem').forEach(cb => cb.checked = checked);
    },
    toggleItem(id, el) {
        if (el.checked) {
            this.selected.push(id);
        } else {
            this.selected = this.selected.filter(i => i != id);
        }
    },
    deleteSelected() {
        if (this.selected.length === 0) {
            this.toast('Pilih data dulu!', 'error');
            return;
        }

        if (!confirm('Yakin hapus data terpilih?')) return;

        fetch('/pesertaasrama/delete-selected', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: this.selected })
        })
        .then(res => res.json())
        .then(res => {
            this.toast(res.message, 'success');
            setTimeout(() => location.reload(), 1000);
        })
        .catch(() => {
            this.toast('Terjadi kesalahan!', 'error');
        });
    },
    toast(message, type='success') {
        let bg = type === 'success' ? 'bg-green-500' : 'bg-red-500';

        let el = document.createElement('div');
        el.className = `${bg} fixed top-5 right-5 text-white px-4 py-2 rounded shadow-lg z-50`;
        el.innerText = message;

        document.body.appendChild(el);
        setTimeout(() => el.remove(), 2000);
    }
}">

    <!-- 🔹 ACTION BAR -->
    <div class="flex flex-wrap items-center gap-2 mb-3">
        <a href="/asramasiswa" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md">⬅ Kembali</a>

        <a href="/kolektifasrama/{{ $asramasiswa }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-md">
            + Tambah
        </a>

        <button onclick="printContent('div1')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md">
            🖨 Print
        </button>

        <input type="search" wire:model.debounce.500ms="search"
            class="border rounded px-2 py-1 text-sm"
            placeholder="Cari nama siswa...">

        <button @click="deleteSelected"
            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md">
            🗑 Hapus
        </button>
    </div>

    <!-- 🔹 TABLE -->
    <div id="div1" class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-1">
                        <input type="checkbox" @change="toggleAll">
                    </th>
                    <th class="border p-1">No</th>

                    @role('super admin')
                    <th class="border p-1">NIS</th>
                    @endrole

                    <th class="border p-1 text-left">Nama</th>
                    <th class="border p-1 text-center">JK</th>
                    <th class="border p-1 text-center">Asrama</th>
                    <th class="border p-1 text-center">Kota</th>

                    @role('super admin')
                    <th class="border p-1 text-center">Aksi</th>
                    @endrole
                </tr>
            </thead>

            <tbody>
                @foreach($datapeserta as $siswa)
                <tr class="hover:bg-gray-50 transition"
                    :class="selected.includes('{{ $siswa->id }}') ? 'bg-red-50' : ''">

                    <td class="border text-center">
                        <input type="checkbox"
                            class="checkItem"
                            value="{{ $siswa->id }}"
                            @change="toggleItem('{{ $siswa->id }}', $event.target)">
                    </td>

                    <td class="border text-center">{{ $loop->iteration }}</td>

                    @role('super admin')
                    <td class="border text-center">{{ $siswa->nis }}</td>
                    @endrole

                    <td class="border px-2 capitalize">
                        {{ strtolower($siswa->nama_siswa) }}
                    </td>

                    <td class="border text-center">{{ $siswa->jenis_kelamin }}</td>
                    <td class="border text-center">{{ $siswa->nama_asrama ??'nama Asrama tidak ditemukan' }}</td>
                    <td class="border text-center">{{ $siswa->kota_asal }}</td>

                    @role('super admin')
                    <td class="border text-center">
                        <div class="flex justify-center gap-2">

                            <!-- DELETE -->
                            <form action="/pesertaasrama/{{$siswa->id}}" method="POST"
                                onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="  bg-yellow-300 hover:bg-red-200 text-white px-2 py-1 rounded">
                                    ❌
                                </button>
                            </form>

                            <!-- EDIT -->
                            <a href="/pesertaasrama/{{$siswa->id}}/edit"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded">
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