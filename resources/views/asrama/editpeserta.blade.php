<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Asrama Peserta Asrama
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="mx-auto max-w-2xl">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Flash Message --}}
                @if(session('success'))
                <div class="mb-3 p-2 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <form action="/pesertaasrama/{{$pesertaasrama->id}}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 gap-4">

                        {{-- Hidden siswa_id --}}
                        <input type="hidden" name="siswa_id" value="{{ $anggota->id }}">

                        {{-- Nama siswa --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                            <input type="text"
                                value="{{ $anggota->nama_siswa }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100"
                                readonly>

                            {{-- Info tambahan --}}
                            <p class="text-sm text-gray-500 mt-1">
                                Jenis Kelamin:
                                <span class="font-semibold">
                                    {{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </p>
                        </div>

                        {{-- Select Asrama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pilih Asrama</label>

                            <select name="asramasiswa_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm uppercase"
                                required>

                                @forelse($dataasrama as $asrama)
                                <option value="{{ $asrama->id }}"
                                    {{ $pesertaasrama->asramasiswa_id == $asrama->id ? 'selected' : '' }}>
                                    {{ $loop->iteration }} | {{ $asrama->nama_asrama }}
                                </option>
                                @empty
                                <option disabled selected>
                                    Tidak ada asrama tersedia
                                </option>
                                @endforelse

                            </select>

                            {{-- Error --}}
                            @error('asramasiswa_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Button --}}
                        <div class="flex gap-2 mt-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2">
                                Update Asrama
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Keterangan --}}
    <div class="px-4 py-2">
        <div class="mx-auto max-w-2xl">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-4 bg-blue-100 border-b border-gray-200">

                    <span class="font-semibold">Keterangan:</span>

                    <div class="px-2 mt-2 text-sm text-gray-700">
                        <p>1. Untuk penambahan <b>anggota asrama</b> <u>wajib</u> memiliki <b>NIS (Nomor Induk Siswa)</b>.</p>
                        <p>2. Jika tidak memiliki NIS, harap konfirmasi ke pihak <b>kesiswaan</b> atau <b>kepala sekolah</b>.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>