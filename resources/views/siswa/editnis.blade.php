<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Nomor Induk Siswa')

        <div class="flex flex-col gap-1">
            <h2 class="font-semibold text-lg sm:text-xl text-slate-800">
                Update Nomor Induk Siswa
            </h2>
            <p class="text-sm text-slate-500">
                {{ $nisSiswa->nama_siswa }} - {{ $nisSiswa->nis }}
            </p>
        </div>
    </x-slot>

    <div class="p-3 sm:p-6">
        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow-sm border rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b bg-slate-50">
                    <h3 class="font-semibold text-slate-700">
                        Form Update NIS
                    </h3>
                </div>

                <div class="p-5">
                    <form action="/nis/{{ $nis->id }}" method="post" class="space-y-5">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="siswa_id" value="{{ $nis->siswa_id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- NIS --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Nomor Induk Siswa
                                </label>
                                <input
                                    type="text"
                                    name="nis"
                                    value="{{ $nis->nis }}"
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm
                                           focus:ring-2 focus:ring-blue-200 focus:outline-none">
                            </div>

                            {{-- MADRASAH --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Jenjang
                                </label>
                                <select
                                    name="madrasah_diniyah"
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm
                                           focus:ring-2 focus:ring-blue-200 focus:outline-none">
                                    <option {{ old('madrasah_diniyah',$nis->madrasah_diniyah)=="Ula" ? 'selected':'' }} value="Ula">
                                        Ula
                                    </option>
                                    <option {{ old('madrasah_diniyah',$nis->madrasah_diniyah)=="Wustho" ? 'selected':'' }} value="Wustho">
                                        Wustho
                                    </option>
                                    <option {{ old('madrasah_diniyah',$nis->madrasah_diniyah)=="Ulya" ? 'selected':'' }} value="Ulya">
                                        Ulya
                                    </option>
                                </select>
                            </div>

                            {{-- LEMBAGA --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Nama Lembaga
                                </label>
                                <select
                                    name="nama_lembaga"
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm
                                           focus:ring-2 focus:ring-blue-200 focus:outline-none">
                                    <option value="Wahidiyah">Wahidiyah</option>
                                </select>
                            </div>

                            {{-- TANGGAL MASUK --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">
                                    Tanggal Masuk
                                </label>
                                <input
                                    type="date"
                                    name="tanggal_masuk"
                                    value="{{ $nis->tanggal_masuk }}"
                                    required
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm
                                           focus:ring-2 focus:ring-blue-200 focus:outline-none">
                            </div>
                        </div>

                        {{-- BUTTON --}}
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button
                                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700
                                       text-white px-5 py-2.5 rounded-xl text-sm shadow-sm">
                                Update NIS
                            </button>

                            <a href="/nis/{{ $nis->siswa_id }}"
                                class="w-full sm:w-auto text-center bg-slate-100 hover:bg-slate-200
                                       text-slate-700 px-5 py-2.5 rounded-xl text-sm shadow-sm">
                                Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>