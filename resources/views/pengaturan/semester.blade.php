<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Dashboard Pengaturan') }}
        </h2>
    </x-slot>

    <style>
        .page-break {
            page-break-after: always;
        }
    </style>

    <script>
        function printContent(el) {
            let restorePage = document.body.innerHTML;
            let printContent = document.getElementById(el).innerHTML;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = restorePage;

            location.reload();
        }
    </script>

    <div class="p-4 space-y-4">

        {{-- Toolbar --}}
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                <div class="flex flex-wrap gap-2">
                    <a href="/cardlogin"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                        User Account
                    </a>

                    <button
                        onclick="printContent('div1')"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 transition">

                        <x-icons.print class="w-4 h-4" />
                        Cetak Kartu Akun
                    </button>
                </div>

                <form action="/semester" method="GET" class="flex gap-2">
                    <input
                        type="text"
                        name="cari"
                        value="{{ request('cari') }}"
                        placeholder="Cari nama siswa..."
                        autofocus
                        class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    <button
                        type="submit"
                        class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Cari
                    </button>
                </form>

            </div>
        </div>

        {{-- Data --}}
        <div id="div1">

            <div class="bg-white rounded-lg shadow-sm border">

                <div class="p-6">

                    <div class="mb-6 text-center">
                        <h3 class="text-lg font-bold uppercase text-gray-800">
                            Akun SMEDI Siswa
                        </h3>
                        <p class="text-sm text-gray-500">
                            Daftar akun login siswa
                        </p>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="min-w-full border border-gray-300">

                            <thead>
                                <tr class="bg-gray-100 text-xs uppercase tracking-wide text-gray-700">
                                    <th class="px-3 py-2 border text-center w-16">No</th>
                                    <th class="px-3 py-2 border text-left">Nama Siswa</th>
                                    <th class="px-3 py-2 border text-center">Kelas</th>
                                    <th class="px-3 py-2 border text-center">Username</th>
                                    <th class="px-3 py-2 border text-center">Password</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($peserta as $user)
                                <tr class="hover:bg-gray-50 even:bg-gray-50 text-sm">

                                    <td class="px-3 py-2 border text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-3 py-2 border capitalize">
                                        {{ strtolower($user->nama_siswa) }}
                                    </td>

                                    <td class="px-3 py-2 border text-center">
                                        {{ $user->nama_kelas }}
                                    </td>

                                    <td class="px-3 py-2 border text-center font-medium">
                                        {{ $user->nis }}
                                    </td>

                                    <td class="px-3 py-2 border text-center font-medium">
                                        {{ $user->nis }}
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                        Data siswa tidak ditemukan.
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    @if(method_exists($peserta, 'links'))
                    <div class="mt-4">
                        {{ $peserta->links() }}
                    </div>
                    @endif

                </div>

            </div>

        </div>

    </div>
</x-app-layout>