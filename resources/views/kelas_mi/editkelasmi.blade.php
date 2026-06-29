<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Edit Kelas Madrasah
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Perbarui informasi kelas madrasah.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white rounded-2xl shadow border border-slate-200">

                <div class="px-6 py-5 border-b">
                    <h3 class="text-lg font-semibold">
                        Form Edit Kelas
                    </h3>
                </div>

                @if($errors->any())
                <div class="m-6 rounded-xl bg-red-100 border border-red-300 p-4">
                    <ul class="list-disc ml-5 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ url('/kelas_mi/'.$kelasmi->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Nama Kelas --}}
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nama Kelas
                            </label>

                            <input
                                type="text"
                                name="nama_kelas"
                                value="{{ old('nama_kelas',$kelasmi->nama_kelas) }}"
                                class="w-full rounded-xl border px-4 py-3">
                        </div>

                        {{-- Jenjang --}}
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Jenjang
                            </label>

                            <select
                                name="jenjang"
                                class="w-full rounded-xl border px-4 py-3">

                                <option value="Ula"
                                    @selected(old('jenjang',$kelasmi->jenjang)=='Ula')>
                                    Ula
                                </option>

                                <option value="Wustho"
                                    @selected(old('jenjang',$kelasmi->jenjang)=='Wustho')>
                                    Wustho
                                </option>

                                <option value="Ulya"
                                    @selected(old('jenjang',$kelasmi->jenjang)=='Ulya')>
                                    Ulya
                                </option>

                            </select>
                        </div>

                        {{-- Tingkat --}}
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Tingkat Kelas
                            </label>

                            <select
                                name="kelas_id"
                                class="w-full rounded-xl border px-4 py-3">

                                @foreach($kelas as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('kelas_id',$kelasmi->kelas_id)==$item->id)>

                                    {{ $item->kelas }}

                                </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- Periode --}}
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Periode
                            </label>

                            <select
                                name="periode_id"
                                class="w-full rounded-xl border px-4 py-3">

                                @foreach($periode as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(old('periode_id',$kelasmi->periode_id)==$item->id)>

                                    {{ $item->periode }}

                                </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- Kuota --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-2">
                                Kuota
                            </label>

                            <input
                                type="number"
                                name="kuota"
                                value="{{ old('kuota',$kelasmi->kuota) }}"
                                class="w-full rounded-xl border px-4 py-3">
                        </div>

                    </div>

                    <div class="border-t px-6 py-5 flex justify-end gap-3">

                        <a
                            href="{{ route('kelas_mi.index') }}"
                            class="px-5 py-2.5 rounded-xl bg-slate-500 text-white hover:bg-slate-600">

                            Batal

                        </a>

                        <button
                            class="px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>