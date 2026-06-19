<x-app-layout>
  <div class="max-w-2xl mx-auto py-6">
    <form action="{{ route('kalender-pendidikan.update', $kalender->id) }}"
      method="POST"
      class="bg-white p-6 rounded-lg shadow">

      @csrf
      @method('PUT')

      {{-- Nama Kegiatan --}}
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Kegiatan</label>
        <input type="text"
          name="nama_kegiatan"
          value="{{ old('nama_kegiatan', $kalender->nama_kegiatan) }}"
          class="border rounded w-full p-2 focus:ring focus:ring-green-200">
      </div>

      {{-- Tanggal Mulai --}}
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
        <input type="date"
          name="tanggal_mulai"
          value="{{ old('tanggal_mulai', $kalender->tanggal_mulai) }}"
          class="border rounded w-full p-2">
      </div>

      {{-- Tanggal Selesai --}}
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
        <input type="date"
          name="tanggal_selesai"
          value="{{ old('tanggal_selesai', $kalender->tanggal_selesai) }}"
          class="border rounded w-full p-2">
      </div>

      {{-- Kategori --}}
      
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">
          Kategori
        </label>

        <select name="kategori" class="border rounded w-full p-2">

          <option value="Pembelajaran"
            {{ old('kategori', $kalender->kategori) == 'Pembelajaran' ? 'selected' : '' }}>
            Pembelajaran
          </option>

          <option value="Asesmen"
            {{ old('kategori', $kalender->kategori) == 'Asesmen' ? 'selected' : '' }}>
            Asesmen
          </option>

          <option value="Ujian"
            {{ old('kategori', $kalender->kategori) == 'Ujian' ? 'selected' : '' }}>
            Ujian
          </option>

          <option value="Libur"
            {{ old('kategori', $kalender->kategori) == 'Libur' ? 'selected' : '' }}>
            Libur
          </option>

          <option value="Hari Besar Nasional"
            {{ old('kategori', $kalender->kategori) == 'Hari Besar Nasional' ? 'selected' : '' }}>
            Hari Besar Nasional
          </option>

          <option value="Hari Besar Keagamaan"
            {{ old('kategori', $kalender->kategori) == 'Hari Besar Keagamaan' ? 'selected' : '' }}>
            Hari Besar Keagamaan
          </option>

          <option value="Peringatan Internasional"
            {{ old('kategori', $kalender->kategori) == 'Peringatan Internasional' ? 'selected' : '' }}>
            Peringatan Internasional
          </option>

          <option value="PPDB"
            {{ old('kategori', $kalender->kategori) == 'PPDB' ? 'selected' : '' }}>
            PPDB
          </option>

          <option value="Kelulusan"
            {{ old('kategori', $kalender->kategori) == 'Kelulusan' ? 'selected' : '' }}>
            Kelulusan
          </option>

          <option value="Kegiatan Sekolah"
            {{ old('kategori', $kalender->kategori) == 'Kegiatan Sekolah' ? 'selected' : '' }}>
            Kegiatan Sekolah
          </option>

          <option value="Ekstrakurikuler"
            {{ old('kategori', $kalender->kategori) == 'Ekstrakurikuler' ? 'selected' : '' }}>
            Ekstrakurikuler
          </option>

          <option value="Rapat"
            {{ old('kategori', $kalender->kategori) == 'Rapat' ? 'selected' : '' }}>
            Rapat
          </option>

          <option value="Lainnya"
            {{ old('kategori', $kalender->kategori) == 'Lainnya' ? 'selected' : '' }}>
            Lainnya
          </option>

        </select>
      </div>
      


      {{-- Keterangan --}}
      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Keterangan</label>
        <textarea name="keterangan"
          rows="4"
          class="border rounded w-full p-2">{{ old('keterangan', $kalender->keterangan) }}</textarea>
      </div>

      {{-- Button --}}
      <div class="flex justify-end gap-2">
        <a href="{{ route('kalender-pendidikan.index') }}"
          class="px-4 py-2 border rounded">
          Batal
        </a>

        <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
          Update
        </button>
      </div>

    </form>
  </div>
</x-app-layout>