<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Edit Data Guru
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Perbarui informasi data guru dengan lengkap dan benar.
                </p>
            </div>

            <a href="/guru"
                class="hidden sm:inline-flex items-center gap-2 px-4 py-2
                       bg-white border border-gray-200 rounded-xl
                       text-sm font-medium text-gray-700
                       hover:bg-gray-50 hover:border-gray-300
                       transition shadow-sm">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>

                Kembali
            </a>
        </div>
    </x-slot>


    {{-- CONTENT --}}
    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/70">

                    <div class="flex items-center gap-4">

                        {{-- ICON --}}
                        <div class="flex items-center justify-center
                                    w-12 h-12 rounded-xl
                                    bg-sky-100 text-sky-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0z
                                       M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>

                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Informasi Guru
                            </h3>

                            <p class="text-sm text-gray-500">
                                Data identitas dan informasi kepegawaian
                            </p>
                        </div>

                    </div>

                </div>


                {{-- FORM --}}
                <form action="/guru/{{ $guru->id }}"
                    method="POST"
                    class="p-6">

                    @csrf
                    @method('PATCH')


                    {{-- ERROR VALIDATION --}}
                    @if ($errors->any())

                    <div class="mb-6 p-4 rounded-xl
                                    bg-red-50 border border-red-200">

                        <div class="flex gap-3">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-red-500 flex-shrink-0"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01
                                           M10.29 3.86l-8.82 15a1 1 0 00.86 1.5h19.34a1 1 0 00.86-1.5l-8.82-15a1 1 0 00-1.72 0z" />
                            </svg>

                            <div>
                                <p class="text-sm font-semibold text-red-700">
                                    Terdapat kesalahan pada data
                                </p>

                                <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>

                    </div>

                    @endif


                    {{-- FORM GRID --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        {{-- NAMA --}}
                        <div class="md:col-span-2">

                            <label for="nama_guru"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Nama Lengkap
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="text"
                                id="nama_guru"
                                name="nama_guru"
                                value="{{ old('nama_guru', $guru->nama_guru) }}"
                                placeholder="Contoh: M. Izul Ula"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       placeholder-gray-400
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                            @error('nama_guru')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- JENIS KELAMIN --}}
                        <div>

                            <label for="jenis_kelamin"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Jenis Kelamin

                            </label>

                            <select id="jenis_kelamin"
                                name="jenis_kelamin"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="L"
                                    {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-Laki
                                </option>

                                <option value="P"
                                    {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>

                            </select>

                            @error('jenis_kelamin')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- AGAMA --}}
                        <div>

                            <label for="agama"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Agama

                            </label>

                            <select id="agama"
                                name="agama"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                                <option value="">
                                    -- Pilih Agama --
                                </option>

                                <option value="Islam"
                                    {{ old('agama', $guru->agama) == 'Islam' ? 'selected' : '' }}>
                                    Islam
                                </option>

                            </select>

                            @error('agama')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- TEMPAT LAHIR --}}
                        <div>

                            <label for="tempat_lahir"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Tempat Lahir
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="text"
                                id="tempat_lahir"
                                name="tempat_lahir"
                                value="{{ old('tempat_lahir', $guru->tempat_lahir) }}"
                                placeholder="Contoh: Malang"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       placeholder-gray-400
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                            @error('tempat_lahir')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- TANGGAL LAHIR --}}
                        <div>

                            <label for="tanggal_lahir"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Tanggal Lahir
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="date"
                                id="tanggal_lahir"
                                name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $guru->tanggal_lahir) }}"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                            @error('tanggal_lahir')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- TANGGAL MASUK --}}
                        <div>

                            <label for="tanggal_masuk"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Tanggal Masuk
                                <span class="text-red-500">*</span>

                            </label>

                            <input type="date"
                                id="tanggal_masuk"
                                name="tanggal_masuk"
                                value="{{ old('tanggal_masuk', $guru->tanggal_masuk) }}"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                            @error('tanggal_masuk')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- STATUS --}}
                        <div>

                            <label for="status"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Status

                            </label>

                            <select id="status"
                                name="status"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                                <option value="">
                                    -- Pilih Status --
                                </option>

                                <option value="Aktif"
                                    {{ old('status', $guru->status) == 'Aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="Non Aktif"
                                    {{ old('status', $guru->status) == 'Non Aktif' ? 'selected' : '' }}>
                                    Non Aktif
                                </option>

                                <option value="Cuti"
                                    {{ old('status', $guru->status) == 'Cuti' ? 'selected' : '' }}>
                                    Cuti
                                </option>

                            </select>

                            @error('status')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>


                        {{-- JENJANG --}}
                        <div>

                            <label for="jenjang"
                                class="block text-sm font-semibold text-gray-700 mb-2">

                                Jenjang

                            </label>

                            <select id="jenjang"
                                name="jenjang"
                                class="w-full px-4 py-3
                                       bg-gray-50 border border-gray-200
                                       rounded-xl text-sm text-gray-800
                                       focus:bg-white
                                       focus:border-sky-500
                                       focus:ring-4 focus:ring-sky-100
                                       transition">

                                <option value="">
                                    -- Pilih Jenjang --
                                </option>

                                <option value="Ula"
                                    {{ old('jenjang', $guru->jenjang) == 'Ula' ? 'selected' : '' }}>
                                    Ula
                                </option>

                                <option value="Wustho"
                                    {{ old('jenjang', $guru->jenjang) == 'Wustho' ? 'selected' : '' }}>
                                    Wustho
                                </option>

                                <option value="Ulya"
                                    {{ old('jenjang', $guru->jenjang) == 'Ulya' ? 'selected' : '' }}>
                                    Ulya
                                </option>

                            </select>

                            @error('jenjang')
                            <p class="mt-1.5 text-xs text-red-500">
                                {{ $message }}
                            </p>
                            @enderror

                        </div>

                    </div>


                    {{-- FOOTER --}}
                    <div class="mt-8 pt-6 border-t border-gray-100
                                flex flex-col-reverse sm:flex-row
                                sm:items-center sm:justify-between gap-3">

                        {{-- BACK MOBILE --}}
                        <a href="/guru"
                            class="inline-flex items-center justify-center gap-2
                                   px-5 py-3
                                   border border-gray-200
                                   bg-white
                                   text-gray-700
                                   text-sm font-semibold
                                   rounded-xl
                                   hover:bg-gray-50
                                   transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />

                            </svg>

                            Kembali

                        </a>


                        {{-- UPDATE --}}
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2
                                   px-6 py-3
                                   bg-sky-600
                                   text-white
                                   text-sm font-semibold
                                   rounded-xl
                                   shadow-sm
                                   hover:bg-sky-700
                                   hover:shadow
                                   focus:outline-none
                                   focus:ring-4 focus:ring-sky-200
                                   transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>