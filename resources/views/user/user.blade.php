<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Profil User')

        <div class="flex flex-col gap-1">
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                Dashboard Profile User
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-300">
                Informasi lengkap data siswa
            </p>
        </div>
    </x-slot>

    <div class="p-3">

        @if(!$siswa)

        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl p-8 text-center">

            <div class="text-6xl mb-4">
                ⚠️
            </div>

            <h2 class="text-xl font-bold text-red-600 mb-2">
                Data Siswa Tidak Ditemukan
            </h2>

            <p class="text-slate-500 dark:text-slate-300">
                Akun yang sedang login belum terhubung dengan data siswa.
            </p>

        </div>

        @else

        <div class="space-y-4">

            {{-- PROFILE CARD --}}
            <div class="bg-white dark:bg-dark-bg shadow rounded-2xl overflow-hidden">

                <div class="bg-gradient-to-r from-green-600 to-emerald-500 h-28"></div>

                <div class="p-6">

                    <div class="flex flex-col lg:flex-row gap-6">

                        {{-- FOTO --}}
                        <div class="flex justify-center -mt-20">

                            <div class="bg-white rounded-full p-2 shadow-lg">

                                <img
                                    src="{{ asset('asset/images/logo.png') }}"
                                    alt="Logo"
                                    class="w-36 h-36 object-contain">

                            </div>

                        </div>

                        {{-- DATA --}}
                        <div class="flex-1">

                            <h1 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">
                                {{ $siswa->nama_siswa }}
                            </h1>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-slate-500">
                                        NIS
                                    </span>
                                    <span>
                                        {{ $siswa->nis ?? '-' }}
                                    </span>
                                </div>

                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-slate-500">
                                        Agama
                                    </span>
                                    <span>
                                        {{ $siswa->agama ?? '-' }}
                                    </span>
                                </div>

                                <div class="flex justify-between border-b pb-2 md:col-span-2">
                                    <span class="font-medium text-slate-500">
                                        Tempat, Tanggal Lahir
                                    </span>

                                    <span class="text-right">

                                        {{ $siswa->tempat_lahir ?? '-' }}

                                        @if($siswa->tanggal_lahir)
                                        ,
                                        {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}
                                        @endif

                                    </span>
                                </div>

                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-slate-500">
                                        Asal Kota
                                    </span>

                                    <span>
                                        {{ $siswa->kota_asal ?? '-' }}
                                    </span>
                                </div>

                                <div class="flex justify-between border-b pb-2">
                                    <span class="font-medium text-slate-500">
                                        Kelas
                                    </span>

                                    <span>

                                        @if($siswa->kelasTerakhir)

                                        {{ $siswa->kelasTerakhir->KelasMi->nama_kelas ?? '-' }}

                                        @else

                                        <span class="text-red-500">
                                            Belum Ada Kelas
                                        </span>

                                        @endif

                                    </span>
                                </div>

                                <div class="flex justify-between md:col-span-2">
                                    <span class="font-medium text-slate-500">
                                        Asrama
                                    </span>

                                    <span>

                                        @if($siswa->asramaTerkhir)

                                        {{ $siswa->asramaTerkhir->asramaSiswa->asrama->nama_asrama ?? '-' }}

                                        @else

                                        <span class="text-red-500">
                                            Belum Ada Asrama
                                        </span>

                                        @endif

                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ACTION CARD --}}
            <div class="bg-white dark:bg-dark-bg shadow rounded-2xl p-4">

                <div class="flex flex-col md:flex-row gap-3">

                    <a
                        href="{{ url('/siswa/'.$siswa->id.'/edit') }}"
                        class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white px-4 py-3 rounded-xl font-medium transition">

                        ✏️ Update Data Siswa

                    </a>

                    @if ($peserAsrama)

                    <a
                        href="{{ url('/pesertaasrama/'.$peserAsrama->id.'/edit') }}"
                        class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl font-medium transition">

                        🏠 Update Data Asrama

                    </a>

                    @else

                    <div
                        class="flex-1 text-center bg-red-50 text-red-600 px-4 py-3 rounded-xl font-medium">

                        Data Asrama Belum Tersedia

                    </div>

                    @endif

                </div>

            </div>

        </div>

        @endif

    </div>
</x-app-layout>