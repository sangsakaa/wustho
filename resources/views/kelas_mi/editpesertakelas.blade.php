<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Edit Peserta Kelas
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Ubah penempatan kelas peserta dengan mudah
            </p>
        </div>
    </x-slot>

    <div class="py-6 px-4 space-y-6">

        <!-- FORM CARD -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-lg font-semibold text-slate-700">
                        Form Edit Peserta
                    </h3>
                </div>

                <form action="/pesertakelas/{{$pesertakelas->id}}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="siswa_id" value="{{$siswaKelas->id}}">

                    <!-- NAMA SISWA -->
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">
                            Nama Siswa
                        </label>
                        <input type="text"
                            value="{{ $siswaKelas->nama_siswa }}"
                            readonly
                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 focus:outline-none">
                    </div>

                    <!-- PILIH KELAS -->
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">
                            Pilih Kelas
                        </label>
                        <select name="kelasmi_id"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 uppercase focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($DataKelas as $kelas)
                            <option value="{{$kelas->id}}"
                                {{ $pesertakelas->kelasmi_id == $kelas->id ? 'selected' : '' }}>
                                {{ $loop->iteration }} | {{ $kelas->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BUTTON -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <button
                            class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition shadow-sm">
                            Update Kelas
                        </button>

                        <a href="/pesertakelas/{{$pesertakelas->kelasmi_id}}"
                            class="px-5 py-3 bg-slate-500 hover:bg-slate-600 text-white rounded-xl font-medium transition text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <!-- INFO CARD -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-amber-50 border border-amber-200 rounded-2xl shadow-sm p-6">
                <h3 class="text-base font-semibold text-amber-700 mb-3">
                    Keterangan
                </h3>

                <div class="space-y-3 text-sm text-amber-800">
                    <p>
                        1. Untuk penambahan <b>anggota asrama</b>,
                        peserta <span class="underline font-semibold">wajib memiliki NIS</span>
                        (Nomor Induk Siswa).
                    </p>

                    <p>
                        2. Jika siswa belum memiliki <b>NIS</b>,
                        segera konfirmasi ke bagian
                        <b>Kesiswaan</b> atau <b>Kepala Sekolah</b>.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>