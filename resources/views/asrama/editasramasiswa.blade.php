<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-800">
            Dashboard Asrama Siswa
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        <!-- ACTION BAR -->
        <div class="bg-white shadow-sm rounded-lg p-3 flex justify-between items-center">
            <h3 class="text-sm font-semibold text-gray-700">
                Edit Data Asrama Siswa
            </h3>

            <a href="/addasramasiswa">
                <button class="flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-sm transition">
                    +
                    <span class="hidden sm:inline">Tambah</span>
                </button>
            </a>
        </div>

        <!-- FORM -->
        <div class="bg-white shadow-sm rounded-lg p-4">
            <form action="/asramasiswa/{{$asramasiswa->id}}" method="post" class="space-y-3">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                    <!-- SELECT ASRAMA -->
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-600 mb-1">Pilih Asrama</label>
                        <select name="asrama_id" class="border rounded px-2 py-1 text-sm uppercase focus:ring focus:ring-blue-200">
                            @foreach($dataasrama as $asrama)
                            <option value="{{$asrama->id}}"
                                {{ $asramasiswa->asrama_id == $asrama->id ? "selected" : "" }}>
                                {{$loop->iteration}}. {{$asrama->nama_asrama}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- KUOTA -->
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-600 mb-1">Kuota</label>
                        <input type="number" name="kuota"
                            value="{{$asramasiswa->kuota}}"
                            class="border rounded px-2 py-1 text-sm focus:ring focus:ring-blue-200"
                            placeholder="Contoh: 40">
                    </div>

                    <!-- BUTTON -->
                    <div class="flex items-end gap-2">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm transition">
                            Update
                        </button>

                        <a href="/asramasiswa"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded text-sm transition text-center">
                            Kembali
                        </a>
                    </div>

                </div>
            </form>
        </div>

        <!-- INFO BOX -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
            <p class="font-semibold text-blue-700 mb-2">Keterangan:</p>
            <ul class="list-decimal ml-4 space-y-1 text-gray-700">
                <li>
                    Penambahan anggota asrama <b>wajib memiliki NIS</b>
                </li>
                <li>
                    Jika belum memiliki NIS, konfirmasi ke bagian
                    <b>kesiswaan atau kepala sekolah</b>
                </li>
            </ul>
        </div>

    </div>
</x-app-layout>