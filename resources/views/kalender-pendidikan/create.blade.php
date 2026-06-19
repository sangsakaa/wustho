<x-app-layout>
  <div class="max-w-6xl mx-auto py-6 px-4">

    @if(isset($periodeAktif))
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-lg">
      Periode Aktif:
      <strong>{{ $periodeAktif->nama ?? '-' }}</strong>
    </div>
    @endif

    <form action="{{ route('kalender-pendidikan.store') }}"
      method="POST"
      class="bg-white p-6 rounded-xl shadow">

      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Kolom Kiri --}}
        <div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Nama Kegiatan
            </label>
            <input type="text"
              name="nama_kegiatan"
              value="{{ old('nama_kegiatan') }}"
              class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-200">
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Tanggal Mulai
            </label>
            <input type="date"
              name="tanggal_mulai"
              value="{{ old('tanggal_mulai') }}"
              class="w-full border rounded-lg p-2">
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Tanggal Selesai
            </label>
            <input type="date"
              name="tanggal_selesai"
              value="{{ old('tanggal_selesai') }}"
              class="w-full border rounded-lg p-2">
          </div>

        </div>

        {{-- Kolom Kanan --}}
        <div>

          
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Kategori
            </label>

            <select name="kategori"
              class="w-full border rounded-lg p-2">

              <option value="Pembelajaran">Pembelajaran</option>
              <option value="Ujian">Ujian</option>
              <option value="Asesmen">Asesmen</option>

              <option value="Libur">Libur</option>

              <option value="Hari Besar Nasional">
                Hari Besar Nasional
              </option>

              <option value="Hari Besar Keagamaan">
                Hari Besar Keagamaan
              </option>

              <option value="Peringatan Internasional">
                Peringatan Internasional
              </option>

              <option value="Rapat">Rapat</option>

              <option value="Kegiatan Sekolah">
                Kegiatan Sekolah
              </option>

              <option value="Ekstrakurikuler">
                Ekstrakurikuler
              </option>

              <option value="PPDB">
                PPDB
              </option>

              <option value="Kelulusan">
                Kelulusan
              </option>

              <option value="Lainnya">
                Lainnya
              </option>

            </select>
          </div>
          


          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
              Keterangan
            </label>

            <textarea
              name="keterangan"
              rows="7"
              class="w-full border rounded-lg p-2">{{ old('keterangan') }}</textarea>
          </div>

        </div>

      </div>

      <div class="flex justify-end gap-2 border-t pt-4 mt-4">

        <a href="{{ route('kalender-pendidikan.index') }}"
          class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
          Kembali
        </a>

        <button type="submit"
          class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
          Simpan Data
        </button>

      </div>

    </form>

  </div>
</x-app-layout>