<x-app-layout>

    <x-slot name="header">
        @section('title', ' | Update Daftar Jadwal')

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
                {{ __('Update Jadwal') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-4 space-y-6">

        {{-- ================= FORM ================= --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm p-6">

            <form action="/edit-jadwal/{{$daftar_Jadwal->id}}" method="POST" class="grid sm:grid-cols-2 gap-5">

                @csrf
                @method('PATCH')

                <input type="hidden" name="jadwal_id" value="{{ $daftar_Jadwal->jadwal_id }}">

                {{-- GURU --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih Pengajar
                    </label>

                    <select name="guru_id"
                        class="w-full border rounded-xl px-3 py-2 dark:bg-gray-800 dark:text-white">

                        @foreach ($dataGuru as $item)
                        <option value="{{ $item->id }}"
                            @selected($item->id == $daftar_Jadwal->guru_id)>
                            {{ $item->nama_guru }}
                        </option>
                        @endforeach

                    </select>
                </div>

                {{-- MAPEL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pilih Mata Pelajaran
                    </label>

                    <select name="mapel_id"
                        class="w-full border rounded-xl px-3 py-2 dark:bg-gray-800 dark:text-white">

                        <option value="">Pilih Mata Pelajaran</option>

                        @foreach($daftarMapel as $item)
                        <option value="{{ $item->id }}" class="capitalize"
                            @selected($item->id == $daftar_Jadwal->mapel_id)>
                            {{ ucwords($item->mapel) }}
                        </option>
                        @endforeach

                    </select>
                </div>

                {{-- ACTION --}}
                <div class="sm:col-span-2 flex justify-end gap-3 pt-3">

                    <a href="/jadwal-guru/{{$daftar_Jadwal->jadwal_id}}"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm">
                        Kembali
                    </a>

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">
                        Update
                    </button>

                </div>

            </form>

        </div>

        {{-- ================= INFO ================= --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm p-5 space-y-3">

            {{-- ERROR --}}
            @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                {{ session('error') }}
            </div>
            @endif

            {{-- HARI --}}
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Hari</span>
                <span class="font-semibold text-gray-800 capitalize">
                    {{ $jadwal->hari ?? '-' }}
                </span>
            </div>

        </div>

    </div>

</x-app-layout>