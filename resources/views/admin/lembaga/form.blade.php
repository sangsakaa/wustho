<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-2xl border border-gray-100 p-8">
  <div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">
      Data Lembaga
    </h2>
    <p class="text-sm text-gray-500 mt-1">
      Kelola informasi lembaga pendidikan secara lengkap.
    </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Kode --}}
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Kode Lembaga
      </label>
      <input
        type="text"
        name="kode"
        value="{{ old('kode', $lembaga->kode ?? '') }}"
        placeholder="Contoh: WST"
        class="w-full rounded-xl border border-gray-300 px-4 py-3
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       transition duration-200 outline-none">
    </div>

    {{-- Nama --}}
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Nama Lembaga
      </label>
      <input
        type="text"
        name="nama"
        value="{{ old('nama', $lembaga->nama ?? '') }}"
        placeholder="Masukkan nama lembaga"
        class="w-full rounded-xl border border-gray-300 px-4 py-3
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       transition duration-200 outline-none">
    </div>

    {{-- Deskripsi --}}
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Deskripsi
      </label>
      <textarea
        name="deskripsi"
        rows="4"
        placeholder="Deskripsi singkat lembaga..."
        class="w-full rounded-xl border border-gray-300 px-4 py-3
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       transition duration-200 outline-none resize-none">{{ old('deskripsi', $lembaga->deskripsi ?? '') }}</textarea>
    </div>

    {{-- Upload Logo --}}
    <div class="md:col-span-2">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Logo Lembaga
      </label>

      <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 text-center hover:border-blue-400 transition">
        <input
          type="file"
          name="logo"
          accept="image/*"
          class="block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-xl file:border-0
                           file:text-sm file:font-medium
                           file:bg-blue-50 file:text-blue-700
                           hover:file:bg-blue-100">

        <p class="text-xs text-gray-400 mt-2">
          PNG, JPG, JPEG, SVG maksimal 2MB
        </p>
      </div>
    </div>

    {{-- Preview Logo --}}
    @isset($lembaga)
    @if($lembaga->logo)
    <div class="md:col-span-2 flex items-center gap-4 mt-2">
      <img
        src="{{ asset('storage/' . $lembaga->logo) }}"
        class="w-24 h-24 rounded-2xl object-cover shadow-md border">
      <div>
        <p class="font-medium text-gray-700">Logo saat ini</p>
        <p class="text-sm text-gray-500">
          Upload file baru untuk mengganti logo.
        </p>
      </div>
    </div>
    @endif
    @endisset
  </div>

  {{-- Button --}}
  <div class="flex justify-end mt-8">
    <button
      type="submit"
      class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600
                   text-white font-medium shadow-lg hover:shadow-xl
                   hover:scale-[1.02] transition duration-200">
      Simpan Data
    </button>
  </div>
</div>