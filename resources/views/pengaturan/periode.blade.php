<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Periode')
        <h2 class="font-semibold text-xl">
            Pengaturan Periode
        </h2>
    </x-slot>

    {{-- 🔥 TOAST CONTAINER --}}
    <div id="toast" class="fixed top-5 right-5 z-50 space-y-2"></div>

    <div class="p-3 space-y-4">

        {{-- NAV --}}
        <div class="bg-white shadow rounded-xl p-3">
            <div class="flex gap-2 text-sm">
                <a href="{{ url('/periode') }}"
                    class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Periode
                </a>
                <a href="{{ url('/pengaturan') }}"
                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Pengaturan
                </a>

            </div>
        </div>

        {{-- FORM --}}
        <div class="bg-white shadow rounded-xl p-4 space-y-4">

            <!-- <form action="{{ url('/periode') }}" method="post" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">

                    {{-- PERIODE --}}
                    <div>
                        <label class="text-xs text-gray-500">Periode</label>
                        <input name="periode" type="text"
                            value="{{ old('periode') }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 @error('periode') border-red-500 @enderror"
                            placeholder="2025/2026">

                        @error('periode')
                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SEMESTER --}}
                    <div>
                        <label class="text-xs text-gray-500">Semester</label>
                        <select name="semester_id"
                            class="w-full border rounded-lg px-3 py-2 text-sm @error('semester_id') border-red-500 @enderror">

                            <option value="">-- Pilih Semester --</option>

                            @foreach($semester as $s)
                            <option value="{{ $s->id }}"
                                {{ old('semester_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->ket_semester }}
                            </option>
                            @endforeach

                        </select>

                        @error('semester_id')
                        <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TANGGAL --}}
                    <div>
                        <label class="text-xs text-gray-500">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai"
                            value="{{ old('tanggal_mulai') }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm">
                    </div>

                    {{-- HIJRIYAH --}}
                    <div>
                        <label class="text-xs text-gray-500">Tahun Hijriyah</label>
                        <input type="text" name="tahun_hijriyah"
                            value="{{ old('tahun_hijriyah') }}"
                            class="w-full border rounded-lg px-3 py-2 text-sm"
                            placeholder="1446">
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Simpan
                    </button>

                    <a href="{{ url('/siswa') }}"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-sm">
                        Batal
                    </a>
                </div>
            </form> -->
            <div class="bg-white shadow rounded-xl p-4 mb-3">
                <form action="{{ url('/periode/generate') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                        Generate Periode Otomatis
                    </button>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border rounded-lg overflow-hidden">

                    <thead class="bg-gray-100 text-xs uppercase">
                        <tr>
                            <th class="p-2 border">No</th>
                            <th class="p-2 border">Periode</th>
                            <th class="p-2 border">Semester</th>

                            <th class="p-2 border">Hijriyah</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Hapus</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($periode as $list)
                        <tr class="hover:bg-gray-50">

                            <td class="border text-center">{{ $loop->iteration }}</td>

                            <td class="border text-center font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <span>{{ $list->periode }}</span>

                                    @if(strtolower($list->semester->ket_semester) == 'ganjil')
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-medium">
                                        Ganjil
                                    </span>
                                    @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                        Genap
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td class="border text-center">
                                {{ $list->semester->semester }}
                            </td>




                            <td class="border text-center">
                                {{ $list->tahun_hijriyah }}
                            </td>

                            {{-- STATUS --}}
                            <td class="border text-center">
                                @if($list->is_active)
                                <span class="px-2 py-1 bg-green-500 text-white rounded text-xs">
                                    Aktif
                                </span>
                                @else
                                <form action="{{ url('/periode/aktifkan/'.$list->id) }}" method="post">
                                    @csrf
                                    <button class="px-2 py-1 bg-gray-400 text-white rounded text-xs hover:bg-blue-500">
                                        Aktifkan
                                    </button>
                                </form>
                                @endif
                            </td>

                            {{-- HAPUS --}}
                            <td class="border px-3 py-2">
                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ url('/periode/' . $list->id) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 text-xs transition">
                                        Detail
                                    </a>

                                    @php
                                    $totalRelasi =
                                    $list->kelasmi_count +
                                    $list->asramasiswa_count +
                                    $list->lulusan_count +
                                    $list->nominasi_count;
                                    @endphp

                                    @if($totalRelasi > 0)
                                    <button disabled
                                        title="Periode sudah dipakai di data lain"
                                        class="px-3 py-1 bg-gray-400 text-white rounded-md text-xs cursor-not-allowed opacity-70">
                                        Dipakai ({{ $totalRelasi }})
                                    </button>
                                    @else
                                    <form action="{{ url('/periode/' . $list->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                    @endif

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-3 text-gray-500">
                                Belum ada data periode
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>

    {{-- 🔥 TOAST SCRIPT --}}
    @if(session('success'))
    <script>
        showToast("{{ session('success') }}", "success");
    </script>
    @endif

    @if(session('error'))
    <script>
        showToast("{{ session('error') }}", "error");
    </script>
    @endif

    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');

            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500'
            };

            const el = document.createElement('div');
            el.className = `
                ${colors[type]}
                text-white px-4 py-2 rounded-lg shadow-lg text-sm
                animate-slide-in
            `;

            el.innerText = message;

            toast.appendChild(el);

            setTimeout(() => {
                el.style.opacity = '0';
                el.style.transition = '0.5s';
                setTimeout(() => el.remove(), 500);
            }, 3000);
        }
    </script>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
    </style>

</x-app-layout>