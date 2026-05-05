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

    <div class="p-3 space-y-4">

        {{-- PROFILE CARD --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl overflow-hidden">
            <div class="p-6 flex flex-col lg:flex-row gap-6 items-center">

                {{-- LOGO / AVATAR --}}
                <div class="flex-shrink-0">
                    <img src="{{ asset('asset/images/logo.png') }}"
                        alt="Logo"
                        class="w-36 h-36 object-contain mx-auto">
                </div>

                {{-- DATA SISWA --}}
                <div class="w-full">
                    <h1 class="text-xl font-bold text-slate-800 dark:text-white mb-4">
                        {{ $siswa->nama_siswa }}
                    </h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">

                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-slate-600 dark:text-slate-300">NIS</span>
                            <span>{{ $siswa->nis }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Agama</span>
                            <span>{{ $siswa->agama }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2 sm:col-span-2">
                            <span class="font-medium text-slate-600 dark:text-slate-300">TTL</span>
                            <span class="text-right capitalize">
                                {{ strtolower($siswa->tempat_lahir) }},
                                {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Asal Kota</span>
                            <span class="capitalize">{{ $siswa->kota_asal }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Kelas</span>
                            <span class="capitalize">
                                @if($siswa->kelasTerakhir)
                                {{ $siswa->kelasTerakhir->KelasMi->nama_kelas }}
                                @else
                                <span class="text-red-500 font-semibold">
                                    Belum ada kelas
                                </span>
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between pb-2 sm:col-span-2">
                            <span class="font-medium text-slate-600 dark:text-slate-300">Asrama</span>
                            <span class="capitalize text-right">
                                @if($siswa->asramaTerkhir)
                                {{ $siswa->asramaTerkhir->asramaSiswa->asrama->nama_asrama }}
                                @else
                                <span class="text-red-500 font-semibold">
                                    Belum ada asrama
                                </span>
                                @endif
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTON --}}
        <div class="bg-white dark:bg-dark-bg shadow rounded-2xl p-4">
            <div class="flex flex-col sm:flex-row gap-3">

                <a href="/siswa/{{ $siswa->id }}/edit"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-3 rounded-xl text-center font-medium transition">
                    Update Data Siswa
                </a>

                @if ($peserAsrama)
                <a href="/pesertaasrama/{{ $peserAsrama->id }}/edit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-xl text-center font-medium transition">
                    Update Asrama
                </a>
                @else
                <div class="bg-red-50 text-red-600 px-4 py-3 rounded-xl text-center font-medium">
                    Asrama information not available
                </div>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>