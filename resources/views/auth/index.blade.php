<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    Manajemen Registrasi Siswa
                </h2>
                <p class="text-sm text-slate-500">
                    Kelola akun siswa
                </p>
            </div>
        </div>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div
        x-data="{
            tab: '{{ session('active_tab', 'belum') }}',
            showAccountModal: {{ session('generated_password') ? 'true' : 'false' }},
            showDeleteModal: false,
            deleteUrl: ''
        }"
        class="py-6 bg-slate-100 min-h-screen">

        <div class="max-w-7xl mx-auto px-4 space-y-6">

            {{-- MODAL AKUN --}}
            <div
                x-show="showAccountModal"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

                <div
                    @click.away="showAccountModal=false"
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">

                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-lg font-bold text-slate-800">
                            Akun Berhasil Dibuat
                        </h3>

                        <button
                            @click="showAccountModal=false"
                            class="text-slate-400 hover:text-red-500 text-xl">
                            ✕
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-500">
                                EMAIL
                            </label>

                            <div class="flex gap-2 mt-1">
                                <input
                                    id="generatedEmail"
                                    readonly
                                    value="{{ session('generated_email') }}"
                                    class="w-full border rounded-xl px-3 py-2 bg-slate-50">
                                <button
                                    type="button"
                                    onclick="copyText('generatedEmail')"
                                    class="px-3 py-2 bg-blue-600 text-white rounded-xl text-xs">
                                    Copy
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-500">
                                PASSWORD
                            </label>

                            <div class="flex gap-2 mt-1">
                                <input
                                    id="generatedPassword"
                                    readonly
                                    value="{{ session('generated_password') }}"
                                    class="w-full border rounded-xl px-3 py-2 bg-slate-50">
                                <button
                                    type="button"
                                    onclick="copyText('generatedPassword')"
                                    class="px-3 py-2 bg-emerald-600 text-white rounded-xl text-xs">
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>

                    <button
                        @click="showAccountModal=false"
                        class="mt-6 w-full py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl">
                        Tutup
                    </button>
                </div>
            </div>

            {{-- MODAL DELETE --}}
            <div
                x-show="showDeleteModal"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">

                <div
                    @click.away="showDeleteModal=false"
                    class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">

                    <h3 class="text-lg font-bold text-slate-800 mb-2">
                        Konfirmasi Hapus
                    </h3>

                    <p class="text-sm text-slate-500 mb-6">
                        Apakah yakin ingin menghapus user ini?
                    </p>

                    <div class="flex justify-end gap-3">
                        <button
                            @click="showDeleteModal=false"
                            class="px-4 py-2 border rounded-xl">
                            Batal
                        </button>

                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl">
                                Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- SEARCH + ACTION --}}
            <div class="bg-white p-5 rounded-2xl shadow-sm border">
                <div class="flex flex-col lg:flex-row lg:justify-between gap-4">
                    <form method="GET" action="{{ route('register.index') }}" class="flex gap-2">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama siswa..."
                            class="w-full md:w-96 rounded-xl border-slate-300 shadow-sm">

                        <button
                            class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl">
                            Cari
                        </button>
                    </form>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm">
                            Tambah User
                        </a>

                        <a href="{{ route('admin.roles.index') }}"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm">
                            Role
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-sm">
                            Users
                        </a>

                        <a href="{{ url('/admin/user-permissions') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm">
                            Permissions
                        </a>
                    </div>
                </div>
            </div>

            {{-- TAB --}}
            <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

                <div class="flex border-b bg-slate-50">
                    <button
                        @click="tab='belum'"
                        :class="tab==='belum'
                            ? 'border-indigo-500 text-indigo-600 bg-white'
                            : 'text-slate-500'"
                        class="px-6 py-4 border-b-2 font-medium">
                        Belum Punya Akun
                    </button>

                    <button
                        @click="tab='sudah'"
                        :class="tab==='sudah'
                            ? 'border-indigo-500 text-indigo-600 bg-white'
                            : 'text-slate-500'"
                        class="px-6 py-4 border-b-2 font-medium">
                        Sudah Punya Akun
                    </button>
                </div>

                {{-- TAB BELUM --}}
                <div x-show="tab==='belum'" x-transition class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-600">
                            <tr>
                                <th class="px-6 py-3 text-center">No</th>
                                <th class="px-6 py-3 text-left">Nama Siswa</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($belumPunyaAkun as $item)
                            <tr class="border-t hover:bg-slate-50">
                                <td class="px-6 py-4 text-center">
                                    {{ $belumPunyaAkun->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">{{ $item->nama_siswa }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form
                                        action="{{ route('register.quick', $item->id) }}"
                                        method="POST"
                                        class="inline-block">
                                        @csrf
                                        <button
                                            class="px-3 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs">
                                            Buat Akun
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-slate-500">
                                    Semua siswa sudah punya akun
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $belumPunyaAkun->links() }}
                    </div>
                </div>

                {{-- TAB SUDAH --}}
                <div x-show="tab==='sudah'" x-transition class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-600">
                            <tr>
                                <th class="px-6 py-3 text-center">No</th>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sudahPunyaAkun as $user)
                            <tr class="border-t hover:bg-slate-50">
                                <td class="px-6 py-4 text-center">
                                    {{ $sudahPunyaAkun->firstItem() + $loop->index }}
                                </td>
                                <td class="px-6 py-4">{{ $user->siswa?->nama_siswa }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button
                                        @click="
                                            showDeleteModal=true;
                                            deleteUrl='{{ route('users.destroy', $user->id) }}'
                                        "
                                        class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">
                                    Belum ada akun siswa
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $sudahPunyaAkun->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyText(id) {
            let text = document.getElementById(id);
            navigator.clipboard.writeText(text.value);

            const toast = document.createElement('div');
            toast.innerHTML = 'Berhasil dicopy';
            toast.className =
                'fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded-xl shadow-lg z-50';

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        }
    </script>
</x-app-layout>