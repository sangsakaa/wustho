<x-app-layout>

    <x-slot name="header">
        @section('title', ' | Data Peserta Lulusan')

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">
                    Data Peserta Lulusan
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data peserta yang telah dinyatakan lulus
                </p>
            </div>
        </div>
    </x-slot>


    <div
        class="p-4 md:p-6 space-y-5"
        x-data="{
            open: false,
            deleteId: null,
            deleteName: '',
            
            confirmDelete(id, name) {
                this.deleteId = id;
                this.deleteName = name;
                this.open = true;
            },

            closeModal() {
                this.open = false;
            }
        }">

        {{-- ========================================================= --}}
        {{-- ACTION BAR --}}
        {{-- ========================================================= --}}

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <div>
                <h3 class="text-lg font-bold text-slate-800">
                    Daftar Peserta
                </h3>

                <p class="text-sm text-slate-500">
                    Kelola nomor ijazah dan data lulusan
                </p>
            </div>


            <div class="flex flex-wrap gap-2">

                {{-- Tambah --}}
                <a
                    href="/kolektif-lulusan/{{ $lulusan->id }}"
                    class="inline-flex items-center gap-2
                           px-4 py-2.5
                           rounded-xl
                           bg-blue-600
                           text-white
                           text-sm font-medium
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
                            d="M12 4v16m8-8H4" />

                    </svg>

                    Tambah Peserta
                </a>


                {{-- Cetak --}}
                <a
                    href="/blangko-ijazah/{{ $lulusan->id }}"
                    class="inline-flex items-center gap-2
                           px-4 py-2.5
                           rounded-xl
                           bg-emerald-600
                           text-white
                           text-sm font-medium
                           shadow-sm
                           hover:bg-emerald-700
                           hover:shadow
                           transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="w-4 h-4">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 9V3h12v6M6 18H4a2 2 0 0 1-2-2v-5
                                 a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5
                                 a2 2 0 0 1-2 2h-2M6 14h12v7H6v-7Z" />

                    </svg>

                    Cetak Ijazah
                </a>


                {{-- Kembali --}}
                <a
                    href="/lulusan"
                    class="inline-flex items-center gap-2
                           px-4 py-2.5
                           rounded-xl
                           bg-white
                           text-slate-600
                           border border-slate-200
                           text-sm font-medium
                           hover:bg-slate-50
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

                    Kembali
                </a>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- TOAST SUCCESS --}}
        {{-- ========================================================= --}}

        @if(session('success'))

        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3500)"
            class="fixed top-5 right-5 z-[60]
                       flex items-start gap-3
                       w-[calc(100%-2rem)] sm:w-auto
                       max-w-sm
                       rounded-2xl
                       border border-emerald-200
                       bg-white
                       p-4
                       shadow-xl">

            <div class="flex items-center justify-center
                            w-9 h-9 rounded-xl
                            bg-emerald-100 text-emerald-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="w-5 h-5">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />

                </svg>

            </div>

            <div class="flex-1">

                <p class="font-semibold text-slate-800 text-sm">
                    Berhasil
                </p>

                <p class="text-xs text-slate-500 mt-1">
                    {{ session('success') }}
                </p>

            </div>

        </div>

        @endif



        {{-- ========================================================= --}}
        {{-- TOAST ERROR --}}
        {{-- ========================================================= --}}

        @if(session('error'))

        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3500)"
            class="fixed top-5 right-5 z-[60]
                       flex items-start gap-3
                       w-[calc(100%-2rem)] sm:w-auto
                       max-w-sm
                       rounded-2xl
                       border border-red-200
                       bg-white
                       p-4
                       shadow-xl">

            <div class="flex items-center justify-center
                            w-9 h-9 rounded-xl
                            bg-red-100 text-red-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="w-5 h-5">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />

                </svg>

            </div>

            <div>

                <p class="font-semibold text-slate-800 text-sm">
                    Terjadi Kesalahan
                </p>

                <p class="text-xs text-slate-500 mt-1">
                    {{ session('error') }}
                </p>

            </div>

        </div>

        @endif



        {{-- ========================================================= --}}
        {{-- SUMMARY --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- Total --}}
            <div class="bg-white border border-slate-200
                        rounded-2xl p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-slate-500">
                            Total Peserta
                        </p>

                        <h3 class="text-3xl font-bold
                                   text-slate-800 mt-1">
                            {{ $daftarLulusan->count() }}
                        </h3>

                    </div>

                    <div class="w-11 h-11
                                rounded-xl
                                bg-blue-50
                                text-blue-600
                                flex items-center justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="w-5 h-5">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19a3 3 0 0 0-6 0m9-9a3 3 0 1 1-6 0
                                     3 3 0 0 1 6 0Zm3 9a3 3 0 0 0-3-3m-9 3
                                     a3 3 0 0 0-3-3m15-6a3 3 0 1 1-6 0" />

                        </svg>

                    </div>

                </div>

            </div>


            {{-- Nomor Ijazah --}}
            <div class="bg-white border border-slate-200
                        rounded-2xl p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Nomor Ijazah
                </p>

                <h3 class="text-3xl font-bold
                           text-emerald-600 mt-1">

                    {{ $daftarLulusan->whereNotNull('nomor_ijazah')->count() }}

                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    Sudah memiliki nomor
                </p>

            </div>


            {{-- Belum --}}
            <div class="bg-white border border-slate-200
                        rounded-2xl p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Belum Ada Nomor
                </p>

                <h3 class="text-3xl font-bold
                           text-amber-500 mt-1">

                    {{ $daftarLulusan->whereNull('nomor_ijazah')->count() }}

                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    Perlu dilengkapi
                </p>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- TABLE --}}
        {{-- ========================================================= --}}

        <div class="bg-white border border-slate-200
                    rounded-2xl shadow-sm overflow-hidden">

            {{-- TABLE HEADER --}}
            <div class="px-5 py-2 border-b border-slate-100
                        flex flex-col sm:flex-row
                        sm:items-center sm:justify-between gap-2">

                <div>

                    <h3 class="font-bold text-slate-800">
                        Daftar Peserta Lulusan
                    </h3>

                    <p class="text-xs text-slate-500 mt-1">
                        Data peserta yang terdaftar sebagai lulusan
                    </p>

                </div>

                <span class="inline-flex items-center
                             px-3 py-1 rounded-full
                             bg-blue-50 text-blue-600
                             text-xs font-semibold">

                    {{ $daftarLulusan->count() }} Peserta

                </span>

            </div>


            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr class="text-xs uppercase tracking-wide
                                   text-slate-500">

                            <th class="px-5 py-3 text-center w-14">
                                No
                            </th>

                            <th class="px-5 py-3 text-left">
                                Nomor Ijazah
                            </th>

                            <th class="px-5 py-3 text-left">
                                NIS
                            </th>

                            <th class="px-5 py-3 text-left">
                                Nama Peserta
                            </th>

                            <th class="px-5 py-3 text-center">
                                Kelas
                            </th>

                            <th class="px-5 py-3 text-center w-32">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($daftarLulusan as $item)

                        <tr class="hover:bg-slate-50/80 transition-colors">

                            {{-- NO --}}
                            <td class="px-5 py-2 text-center">

                                <span class="text-xs
                                                 font-semibold
                                                 text-slate-400">

                                    {{ $loop->iteration }}

                                </span>

                            </td>


                            {{-- IJAZAH --}}
                            <td class="px-5 py-2">

                                @if($item->nomor_ijazah)

                                <span class="inline-flex
                                                     items-center
                                                     px-2.5 py-1
                                                     rounded-lg
                                                     bg-emerald-50
                                                     text-emerald-700
                                                     text-xs
                                                     font-semibold">

                                    {{ $item->nomor_ijazah }}

                                </span>

                                @else

                                <span class="inline-flex
                                                     items-center
                                                     px-2.5 py-1
                                                     rounded-lg
                                                     bg-amber-50
                                                     text-amber-600
                                                     text-xs
                                                     font-medium">

                                    Belum diatur

                                </span>

                                @endif

                            </td>


                            {{-- NIS --}}
                            <td class="px-5 py-2">

                                <span class="font-mono
                                                 text-xs
                                                 text-slate-600">

                                    {{ $item->nis }}

                                </span>

                            </td>


                            {{-- NAMA --}}
                            <td class="px-5 py-2">

                                <div class="font-semibold
                                                text-slate-800">

                                    {{ ucwords(strtolower($item->nama_siswa)) }}

                                </div>

                            </td>


                            {{-- KELAS --}}
                            <td class="px-5 py-2 text-center">

                                <span class="inline-flex
                                                 px-2.5 py-1
                                                 rounded-lg
                                                 bg-slate-100
                                                 text-slate-600
                                                 text-xs
                                                 font-semibold">

                                    {{ strtoupper($item->nama_kelas) }}

                                </span>

                            </td>


                            {{-- AKSI --}}
                            <td class="px-5 py-2">

                                <div class="flex items-center
                                                justify-center gap-2">

                                    {{-- NOMOR --}}
                                    <a
                                        href="/reservasi-ijazah/{{ $item->id }}"
                                        title="Atur nomor ijazah"
                                        class="inline-flex items-center
                                                   justify-center
                                                   w-9 h-9
                                                   rounded-xl
                                                   bg-amber-50
                                                   text-amber-600
                                                   border border-amber-100
                                                   hover:bg-amber-500
                                                   hover:text-white
                                                   transition
                                                   hover:scale-105">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="w-4 h-4">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.232 5.232l3.536 3.536
                                                         M16.5 4.5a2.121 2.121 0 0 1
                                                         3 3L7 20H4v-3L16.5 4.5Z" />

                                        </svg>

                                    </a>


                                    {{-- DELETE --}}
                                    <button
                                        type="button"
                                        title="Hapus peserta"
                                        @click="confirmDelete(
                                                {{ $item->id }},
                                                @js($item->nama_siswa)
                                            )"
                                        class="inline-flex items-center
                                                   justify-center
                                                   w-9 h-9
                                                   rounded-xl
                                                   bg-red-50
                                                   text-red-500
                                                   border border-red-100
                                                   hover:bg-red-500
                                                   hover:text-white
                                                   transition
                                                   hover:scale-105">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="w-4 h-4">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 7h12M9 7V4h6v3
                                                         m-8 0 1 13h8l1-13
                                                         M10 11v6m4-6v6" />

                                        </svg>

                                    </button>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6"
                                class="px-5 py-12 text-center">

                                <div class="flex flex-col
                                                items-center">

                                    <div class="w-14 h-14
                                                    rounded-2xl
                                                    bg-slate-100
                                                    flex items-center
                                                    justify-center
                                                    text-slate-400">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-7 h-7">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 19a3 3 0 0 0-6 0
                                                         m9-9a3 3 0 1 1-6 0
                                                         3 3 0 0 1 6 0ZM4 19
                                                         a3 3 0 0 1 3-3h10
                                                         a3 3 0 0 1 3 3" />

                                        </svg>

                                    </div>

                                    <p class="mt-3 font-semibold
                                                  text-slate-700">

                                        Belum ada data peserta

                                    </p>

                                    <p class="text-sm
                                                  text-slate-400 mt-1">

                                        Data peserta lulusan belum tersedia.

                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- DELETE MODAL --}}
        {{-- ========================================================= --}}

        <div
            x-show="open"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[70]
                   flex items-center justify-center
                   p-4">

            {{-- BACKDROP --}}
            <div
                class="absolute inset-0
                       bg-slate-900/60
                       backdrop-blur-sm"
                @click="closeModal()"></div>


            {{-- MODAL --}}
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md
                       bg-white
                       rounded-3xl
                       shadow-2xl
                       overflow-hidden">

                <div class="p-6">

                    {{-- ICON --}}
                    <div class="flex justify-center">

                        <div class="w-16 h-16
                                    rounded-2xl
                                    bg-red-50
                                    text-red-500
                                    flex items-center
                                    justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.7"
                                stroke="currentColor"
                                class="w-8 h-8">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3h.008v.008H12V15.75ZM4.5
                                         19.5h15a1.5 1.5 0 0 0 1.3-2.25l-7.5-13
                                         a1.5 1.5 0 0 0-2.6 0l-7.5 13a1.5
                                         1.5 0 0 0 1.3 2.25Z" />

                            </svg>

                        </div>

                    </div>


                    {{-- TITLE --}}
                    <div class="text-center mt-5">

                        <h3 class="text-xl font-bold
                                   text-slate-800">

                            Hapus Peserta?

                        </h3>

                        <p class="text-sm text-slate-500
                                  mt-2 leading-relaxed">

                            Anda akan menghapus data peserta

                            <span
                                class="font-bold text-slate-800"
                                x-text="deleteName"></span>.

                            <br>

                            Data yang sudah dihapus
                            <span class="font-semibold text-red-500">
                                tidak dapat dikembalikan.
                            </span>

                        </p>

                    </div>


                    {{-- BUTTON --}}
                    <div class="grid grid-cols-2 gap-3 mt-6">

                        <button
                            type="button"
                            @click="closeModal()"
                            class="px-4 py-3
                                   rounded-xl
                                   border border-slate-200
                                   bg-white
                                   text-slate-600
                                   text-sm font-semibold
                                   hover:bg-slate-50
                                   transition">
                            Batal
                        </button>


                        <form
                            :action="'/daftar-lulusan/' + deleteId"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="w-full
                                       px-4 py-3
                                       rounded-xl
                                       bg-red-500
                                       text-white
                                       text-sm font-semibold
                                       shadow-sm
                                       hover:bg-red-600
                                       hover:shadow
                                       transition">
                                Ya, Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>