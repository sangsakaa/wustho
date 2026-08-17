<x-app-layout>

    <x-slot name="header">
        @section('title', ' | Reservasi Nomor Ijazah')

        <div>
            <h2 class="text-xl font-bold text-slate-800">
                Reservasi Nomor Ijazah
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Atur nomor ijazah untuk peserta lulusan
            </p>
        </div>
    </x-slot>


    <div class="p-4 md:p-6">

        <div class="max-w-3xl mx-auto">

            {{-- HEADER CARD --}}
            <div class="mb-5">

                <a
                    href="{{ url('/daftar-lulusan/' . $daftar_lulusan->lulusan_id) }}"
                    class="inline-flex items-center gap-2
                           text-sm font-medium
                           text-slate-500
                           hover:text-blue-600
                           transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="w-4 h-4">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10 19l-7-7m0 0 7-7m-7 7h18" />

                    </svg>

                    Kembali ke daftar peserta

                </a>

            </div>


            {{-- MAIN CARD --}}
            <div class="bg-white border border-slate-200
                        rounded-2xl shadow-sm overflow-hidden">


                {{-- CARD HEADER --}}
                <div class="px-6 py-5
                            border-b border-slate-100
                            bg-slate-50/70">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12
                                    rounded-xl
                                    bg-blue-50
                                    text-blue-600
                                    flex items-center
                                    justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="w-6 h-6">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 2.25h9.75L21 7.5v14.25
                                         A1.5 1.5 0 0 1 19.5 23h-13
                                         A1.5 1.5 0 0 1 5 21.75V3.75
                                         A1.5 1.5 0 0 1 6 2.25Z" />

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 2.75V8h5.25" />

                            </svg>

                        </div>


                        <div>

                            <h3 class="font-bold text-slate-800">
                                Nomor Ijazah
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                Masukkan nomor ijazah peserta di bawah ini.
                            </p>

                        </div>

                    </div>

                </div>



                {{-- PESERTA --}}
                <div class="px-6 py-5">

                    <div class="rounded-xl
                                bg-slate-50
                                border border-slate-100
                                p-4">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div>

                                <p class="text-xs font-medium
                                          uppercase tracking-wide
                                          text-slate-400">
                                    Nama Peserta
                                </p>

                                <p class="mt-1 font-semibold
                                          text-slate-800">

                                    {{ ucwords(strtolower($daftar_lulusan->nama_siswa)) }}

                                </p>

                            </div>


                            <div>

                                <p class="text-xs font-medium
                                          uppercase tracking-wide
                                          text-slate-400">
                                    NIS
                                </p>

                                <p class="mt-1 font-mono
                                          font-semibold
                                          text-slate-800">

                                    {{ $daftar_lulusan->nis }}

                                </p>

                            </div>

                        </div>

                    </div>



                    {{-- FORM --}}
                    <form
                        action="/daftar-lulusan/{{ $daftar_lulusan->id }}"
                        method="POST"
                        class="mt-6">

                        @csrf
                        @method('PATCH')

                        <input
                            type="hidden"
                            name="lulusan_id"
                            value="{{ $daftar_lulusan->id }}">


                        {{-- LABEL --}}
                        <label
                            for="nomor_ijazah"
                            class="block text-sm font-semibold
                                   text-slate-700 mb-2">
                            Nomor Ijazah
                        </label>


                        {{-- INPUT --}}
                        <div class="relative">

                            <div class="absolute inset-y-0 left-0
                                        flex items-center pl-4
                                        text-slate-400">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                    stroke="currentColor"
                                    class="w-5 h-5">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 4.5A2.5 2.5 0 0 1 8.5 2h7
                                             A2.5 2.5 0 0 1 18 4.5V21
                                             H6V4.5Z" />

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 6h6M9 10h6M9 14h4" />

                                </svg>

                            </div>


                            <input
                                id="nomor_ijazah"
                                type="text"
                                name="nomor_ijazah"
                                value="{{ old('nomor_ijazah', $daftar_lulusan->nomor_ijazah) }}"
                                placeholder="Masukkan nomor ijazah"
                                autocomplete="off"
                                class="w-full
                                       pl-12 pr-4 py-3.5
                                       rounded-xl
                                       border border-slate-200
                                       bg-white
                                       text-slate-800
                                       placeholder:text-slate-400
                                       focus:border-blue-500
                                       focus:ring-4
                                       focus:ring-blue-100
                                       outline-none
                                       transition">

                        </div>


                        @error('nomor_ijazah')

                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>

                        @enderror


                        <p class="mt-2 text-xs text-slate-400">
                            Pastikan nomor ijazah sudah sesuai dengan dokumen resmi.
                        </p>



                        {{-- ACTION --}}
                        <div class="flex flex-col-reverse
                                    sm:flex-row
                                    sm:justify-end
                                    gap-3 mt-7
                                    pt-5
                                    border-t border-slate-100">

                            <a
                                href="'/daftar-lulusan/' . $daftar_lulusan->lulusan_id"
                                class="inline-flex items-center
                                       justify-center
                                       gap-2
                                       px-5 py-2.5
                                       rounded-xl
                                       border border-slate-200
                                       bg-white
                                       text-slate-600
                                       text-sm font-semibold
                                       hover:bg-slate-50
                                       transition">

                                Batal

                            </a>


                            <button
                                type="submit"
                                class="inline-flex items-center
                                       justify-center
                                       gap-2
                                       px-5 py-2.5
                                       rounded-xl
                                       bg-blue-600
                                       text-white
                                       text-sm font-semibold
                                       shadow-sm
                                       hover:bg-blue-700
                                       hover:shadow
                                       transition">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    class="w-4 h-4">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7" />

                                </svg>

                                Simpan Nomor Ijazah

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>