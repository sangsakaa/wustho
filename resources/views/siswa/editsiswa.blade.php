<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Dashboard Update Data Siswa
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white shadow-md rounded-xl p-6">

                {{-- Toast --}}
                @if (session('update'))
                <script>
                    Toastify({
                        text: "Data berhasil diupdate",
                        className: "success",
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        }
                    }).showToast();
                </script>
                @endif

                <form action="{{ url('/siswa/'.$siswa->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_siswa"
                            value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-sky-200">
                        @error('nama_siswa')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grid 2 --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-sky-200">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Agama</label>
                            <select name="agama"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-sky-200">
                                <option value="Islam" {{ old('agama', $siswa->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            </select>
                        </div>
                    </div>

                    {{-- Grid 2 --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium">Kota Asal</label>
                            <input type="text" name="kota_asal"
                                value="{{ old('kota_asal', $siswa->kota_asal) }}"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-sky-200">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Status Pengamal</label>
                            <select name="status_pengamal"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-sky-200">
                                <option value="Pengamal" {{ old('status_pengamal', $status_pengamal->status_pengamal ?? 'Pengamal') == 'Pengamal' ? 'selected' : '' }}>Pengamal</option>
                                <option value="Simpatisan" {{ old('status_pengamal', $status_pengamal->status_pengamal ?? '') == 'Simpatisan' ? 'selected' : '' }}>Simpatisan</option>
                            </select>
                        </div>
                    </div>

                    {{-- TTL --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-sky-200">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}"
                                class="mt-1 w-full rounded-lg border-gray-300 focus:ring focus:ring-sky-200">
                        </div>
                    </div>

                    {{-- Status Anak --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-medium">Status Anak</label>
                            <select name="status_anak"
                                class="mt-1 w-full rounded-lg border-gray-300">
                                <option value="kandung" {{ old('status_anak', $statusAnak->status_anak ?? '') == 'kandung' ? 'selected' : '' }}>Kandung</option>
                                <option value="tiri" {{ old('status_anak', $statusAnak->status_anak ?? '') == 'tiri' ? 'selected' : '' }}>Tiri</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium">Anak Ke</label>
                            <input type="number" name="anak_ke"
                                value="{{ old('anak_ke', $statusAnak->anak_ke ?? '') }}"
                                class="mt-1 w-full rounded-lg border-gray-300">
                        </div>

                        <div>
                            <label class="text-sm font-medium">Jumlah Saudara</label>
                            <input type="number" name="jumlah_saudara"
                                value="{{ old('jumlah_saudara', $statusAnak->jumlah_saudara ?? '') }}"
                                class="mt-1 w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    {{-- Orang Tua --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Ayah --}}
                        <div class="space-y-2">
                            <h3 class="font-semibold text-gray-700">Data Ayah</h3>
                            <input type="text" name="nama_ayah" placeholder="Nama Ayah"
                                value="{{ old('nama_ayah', $statusAnak->nama_ayah ?? '') }}"
                                class="w-full rounded-lg border-gray-300">
                            <input type="text" name="pekerjaan_ayah" placeholder="Pekerjaan"
                                value="{{ old('pekerjaan_ayah', $statusAnak->pekerjaan_ayah ?? '') }}"
                                class="w-full rounded-lg border-gray-300">
                            <input type="text" name="nomor_hp_ayah" placeholder="No HP"
                                value="{{ old('nomor_hp_ayah', $statusAnak->nomor_hp_ayah ?? '') }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>

                        {{-- Ibu --}}
                        <div class="space-y-2">
                            <h3 class="font-semibold text-gray-700">Data Ibu</h3>
                            <input type="text" name="nama_ibu" placeholder="Nama Ibu"
                                value="{{ old('nama_ibu', $statusAnak->nama_ibu ?? '') }}"
                                class="w-full rounded-lg border-gray-300">
                            <input type="text" name="pekerjaan_ibu" placeholder="Pekerjaan"
                                value="{{ old('pekerjaan_ibu', $statusAnak->pekerjaan_ibu ?? '') }}"
                                class="w-full rounded-lg border-gray-300">
                            <input type="text" name="nomor_hp_ibu" placeholder="No HP"
                                value="{{ old('nomor_hp_ibu', $statusAnak->nomor_hp_ibu ?? '') }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2 pt-4">
                        <button type="submit"
                            class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg">
                            Update
                        </button>

                        @role('super admin')
                        <a href="/siswa"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                            Batal
                        </a>
                        @endrole

                        @role('siswa')
                        <a href="/user"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                            Batal
                        </a>
                        @endrole
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>