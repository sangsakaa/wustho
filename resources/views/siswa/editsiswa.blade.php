<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Update Data Siswa') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" bg-white border-b border-gray-200">
                    <div class=" p-6 grid grid-cols-1">
                        @if (session('update'))
                        <script>
                            Toastify({
                                text: "data berhasil di di update",
                                className: "update",
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                }
                            }).showToast();
                        </script>
                        @endif
                        <form action="/siswa/{{$siswa->id}}" method="post">
                            @csrf
                            @method('patch')
                            <label for="">Nama Lengkap</label>
                            <input value="{{$siswa->nama_siswa}}" name="nama_siswa" type="text" class=" w-full py-1 rounded-md @error('nama') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            @error('nama')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <label for="">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="" class=" w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{old('jenis_kelamin',$siswa->jenis_kelamin)=="L"? 'selected':''}} value="L">
                                    Laki-Laki</option>
                                <option {{old('jenis_kelamin',$siswa->jenis_kelamin)=="P"? 'selected':''}} value="P">
                                    Perempuan</option>
                            </select>
                            <div class=" grid grid-cols-1 gap-2 sm:grid-cols-2">
                                <div>
                                    <label for="">Tempat Lahir</label>
                                    <input value="{{$siswa->tempat_lahir}}" name="tempat_lahir" type="text" class=" w-full py-1 rounded-md @error('tempat_lahir') is-invalid @enderror" placeholder=" masukan nama lengkap">
                                </div>
                                <div>
                                    <label for="">Tanggal Lahir</label>
                                    <input value="{{$siswa->tanggal_lahir}}" name="tanggal_lahir" type="date" class=" w-full py-1 rounded-md @error('nama') is-invalid @enderror" placeholder=" masukan nama lengkap">
                                </div>
                            </div>
                            <label for="">Agama</label>
                            <select name="agama" id="" class=" w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{old('agama',$siswa->agama)=="Islam"? 'selected':''}} value="Islam">
                                    Islam</option>
                            </select>
                            <label for="">Kota Asal</label>
                            <input value="{{$siswa->kota_asal}}" name="kota_asal" type="text" class=" w-full py-1 rounded-md @error('kota_asal') is-invalid @enderror" placeholder=" masukan nama lengkap">
                            <input type="hidden" name="siswa_id" value="{{$siswa->id}}">
                            <label for="">Status Pengamal</label>
                            <select name="status_pengamal" id="" class="w-full py-1 rounded-md" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option {{ old('status_pengamal', $status_pengamal->status_pengamal ?? 'Pengamal') == 'Pengamal' ? 'selected' : '' }} value="Pengamal">
                                    Pengamal</option>
                                <option {{ old('status_pengamal', $status_pengamal->status_pengamal ?? 'Pengamal') == 'Simpatisan' ? 'selected' : '' }} value="Simpatisan">
                                    Simpatisan</option>
                            </select>
                            <div class=" grid grid-cols-3 gap-2">
                                <div class=" grid grid-cols-1">
                                    <label for="status_anak">Status Anak</label>


                                    <select name="status_anak" id="" class=" w-full py-1 rounded-md" required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option {{old('status_anak',$statusAnak->status_anak)=="kandung"? 'selected':''}} value="kandung">
                                            Kandung</option>
                                        <option {{old('status_anak',$statusAnak->status_anak)=="tiri"? 'selected':''}} value="tiri">
                                            Tiri</option>
                                    </select>
                                </div>
                                <div class=" grid grid-cols-1">
                                    <label for="anak_ke">Anak Ke-</label>
                                    <input class="py-1" type="text" name="anak_ke" id="anak_ke" value="{{ isset($statusAnak->anak_ke) ? $statusAnak->anak_ke : '' }}">
                                </div>
                                <input class="py-1" type="hidden" name="siswa_id" id="siswa_id" value="{{ isset($statusAnak->siswa_id) ? $statusAnak->siswa_id : '' }}">
                                <div class=" grid grid-cols-1">
                                    <label for="jumlah_saudara">Jumlah Saudara</label>
                                    <input class="py-1" type="text" name="jumlah_saudara" id="jumlah_saudara" value="{{ isset($statusAnak->jumlah_saudara) ? $statusAnak->jumlah_saudara : '' }}">
                                </div>
                            </div>
                            <div class=" grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                                <div class=" grid grid-cols-1">
                                    <label for="nama_ayah">Nama Ayah</label>
                                    <input class="py-1" type="text" name="nama_ayah" id="nama_ayah" value="{{ isset($statusAnak->nama_ayah) ? $statusAnak->nama_ayah : '' }}">
                                    <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                    <input class="py-1" type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ isset($statusAnak->pekerjaan_ayah) ? $statusAnak->pekerjaan_ayah : '' }}">
                                    <label for="nomor_hp_ayah">Nomor HP Ayah</label>
                                    <input class="py-1" type="text" name="nomor_hp_ayah" id="nomor_hp_ayah" value="{{ isset($statusAnak->nomor_hp_ayah) ? $statusAnak->nomor_hp_ayah : '' }}">
                                </div>
                                <div class=" grid grid-cols-1">
                                    <label for="nama_ibu">Nama Ibu</label>
                                    <input class="py-1" type="text" name="nama_ibu" id="nama_ibu" value="{{ isset($statusAnak->nama_ibu) ? $statusAnak->nama_ibu : '' }}">
                                    <label for="nomor_hp_ibu">Nomor HP Ibu</label>
                                    <input class="py-1" type="text" name="nomor_hp_ibu" id="nomor_hp_ibu" value="{{ isset($statusAnak->nomor_hp_ibu) ? $statusAnak->nomor_hp_ibu : '' }}">
                                    <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                    <input class="py-1" type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ isset($statusAnak->pekerjaan_ibu) ? $statusAnak->pekerjaan_ibu : '' }}">
                                </div>

                            </div>
                            <button type="submit" class=" px-2 py-1 bg-sky-600 text-white rounded-md mt-1">Update</button>
                            @role('super admin')
                            <a href="/siswa" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                Batal
                            </a>
                            @endrole
                            @role('siswa')
                            <a href="/user" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                Batal
                            </a>
                            @endrole
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>