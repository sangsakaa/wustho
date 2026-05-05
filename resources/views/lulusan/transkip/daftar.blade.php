<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Nilai Transkip')
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Dashboard Nilai Transkip
            </h2>
            <p class="text-sm text-gray-500">
                Input dan pengelolaan nilai akhir peserta lulusan
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- NAVIGATION --}}
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 flex flex-wrap gap-3">
            <a href="/periode"
                class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
                Periode
            </a>

            <a href="/pengaturan"
                class="px-4 py-2 bg-slate-600 text-white rounded-xl hover:bg-slate-700 transition font-medium">
                Pengaturan
            </a>

            <a href="/daftar-transkip"
                class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition font-medium">
                Daftar Transkip
            </a>
        </div>

        {{-- INFO CARD --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Mata Pelajaran</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1">
                    {{ $dataTranskip->mapel }}
                </h3>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Jenis Ujian</p>
                <h3 class="text-xl font-bold text-gray-800 mt-1">
                    {{ $dataTranskip->nama_ujian }}
                </h3>
            </div>
        </div>

        {{-- ALERT --}}
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4">
            <div class="flex gap-3">
                <span class="text-xl">📌</span>
                <div>
                    <h4 class="font-semibold text-amber-800">
                        Ketentuan Input Nilai
                    </h4>
                    <p class="text-sm text-amber-700 mt-1">
                        Nilai hanya diperbolehkan pada rentang
                        <span class="font-bold">50 - 100</span>.
                        Nilai di luar rentang akan ditolak sistem.
                    </p>
                </div>
            </div>
        </div>

        {{-- ERROR / SUCCESS --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4">
            <ul class="list-disc ml-5 text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- FORM --}}
        <form action="/nilai_transkip/{{ $transkip->id }}" method="POST">
            @csrf
            <input type="hidden" name="transkip_id" value="{{ $transkip->id }}">

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                <div class="px-5 py-4 border-b flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">
                        Input Nilai Peserta
                    </h3>

                    <div class="flex gap-2">
                        <a href="/daftar-transkip"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-medium">
                            Kembali
                        </a>

                        <button type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 font-medium shadow-sm">
                            Simpan Nilai
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-1 text-center">No</th>
                                <th class="px-4 py-1 text-left">Nama Peserta</th>
                                <th class="px-4 py-1 text-center">Kelas</th>
                                <th class="px-4 py-1 text-center">Nilai Akhir</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($dataLulusan as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-1 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-1">
                                    <input type="hidden" name="daftar_lulusan_id[]" value="{{ $item->id }}">
                                    <input type="hidden"
                                        name="nilai_transkip_id[{{ $item->id }}]"
                                        value="{{ $item->nilai_transkip_id }}">

                                    <span class="capitalize font-medium text-gray-700">
                                        {{ strtolower($item->nama_siswa) }}
                                    </span>
                                </td>

                                <td class="px-4 py-1 text-center">
                                    {{ $item->nama_kelas }}
                                </td>

                                <td class="px-4 py-1">
                                    <input
                                        type="number"
                                        name="nilai_akhir[{{ $item->id }}]"
                                        value="{{ old('nilai_akhir.' . $item->id, $item->nilai_akhir) }}"
                                        min="50"
                                        max="100"
                                        placeholder="50 - 100"
                                        class="w-28 mx-auto block rounded-xl border-gray-300 text-center
                                        focus:border-blue-500 focus:ring-blue-500
                                        @error('nilai_akhir.' . $item->id) border-red-500 @enderror">

                                    @error('nilai_akhir.' . $item->id)
                                    <p class="text-xs text-red-500 text-center mt-1">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400">
                                    Belum ada data peserta lulusan
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>