<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Validasi Data')

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                    Dashboard Validasi Data
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Monitoring dan validasi data siswa
                </p>
            </div>
        </div>
    </x-slot>

    <script>
        function printContent(el) {
            let fullbody = document.body.innerHTML;
            let printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = fullbody;
        }
    </script>

    <div class="p-4 sm:p-6 space-y-5">

        {{-- ACTION BAR --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                {{-- SEARCH --}}
                <form action="/validasi-data" method="GET"
                    class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">

                    <div class="relative w-full sm:w-72">
                        <input type="text"
                            name="cari"
                            value="{{ request('cari') }}"
                            placeholder="Cari nama siswa..."
                            autofocus
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white pl-4 pr-10 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-blue-600">
                            <x-icons.cari />
                        </button>
                    </div>
                </form>

                {{-- BUTTON PRINT --}}
                <button onclick="printContent('printArea')"
                    class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl text-sm font-medium shadow-sm transition">

                    <x-icons.print />
                    Print Data
                </button>
                <a href="/validasi-data/pdf"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                    Export PDF
                </a>
            </div>
        </div>

        {{-- TABLE CARD --}}
        <div id="printArea"
            class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

            {{-- HEADER TABLE --}}
            <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-semibold text-gray-800 dark:text-white uppercase">
                    Data Validasi
                </h3>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="min-w-full text-sm text-left">

                    <thead class="bg-gray-50 dark:bg-gray-800 sticky top-0 z-10">
                        <tr class="text-xs uppercase text-gray-600 dark:text-gray-300">

                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">JK</th>
                            <th class="px-4 py-3">TTL</th>
                            <th class="px-4 py-3">Kelas</th>
                            <th class="px-4 py-3">Nama Ayah</th>
                            <!-- <th class="px-4 py-3">Pekerjaan Ayah</th>
                            <th class="px-4 py-3">No HP Ayah</th> -->
                            <!-- <th class="px-4 py-3">Nama Ibu</th>
                            <th class="px-4 py-3">Pekerjaan Ibu</th>
                            <th class="px-4 py-3">No HP Ibu</th>
                            <th class="px-4 py-3">Status Anak</th>
                            <th class="px-4 py-3">Jumlah Saudara</th>
                            <th class="px-4 py-3">Anak Ke</th>
                            <th class="px-4 py-3">Pengamal</th> -->

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @forelse($data as $item)
                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-800 text-sm">

                            <td class="px-4 py-3 text-center font-medium">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 min-w-[220px] font-medium capitalize">
                                {{ strtolower($item->nama_siswa) }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->jenis_kelamin }}
                            </td>

                            <td class="px-4 py-3 min-w-[220px]">
                                {{ strtolower($item->tempat_lahir) }},
                                {{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('DD MMMM Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->nama_kelas }}
                            </td>

                            <td class="px-4 py-3 min-w-[180px]">
                                {{ $item->nama_ayah }}
                            </td>

                            <!-- <td class="px-4 py-3">
                                {{ $item->pekerjaan_ayah }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->nomor_hp_ayah }}
                            </td>

                            <td class="px-4 py-3 min-w-[180px]">
                                {{ $item->nama_ibu }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->pekerjaan_ibu }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->nomor_hp_ibu }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->status_anak }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->jumlah_saudara }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                {{ $item->anak_ke }}
                            </td> -->

                            <!-- <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $item->status_pengamal == 'Aktif'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-gray-100 text-gray-700' }}">
                                    {{ $item->status_pengamal }}
                                </span>
                            </td> -->

                        </tr>
                        @empty
                        <tr>
                            <td colspan="15"
                                class="text-center py-8 text-gray-500">
                                Data tidak ditemukan
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- INFO --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
            <h4 class="font-semibold text-blue-700 mb-2">
                Informasi
            </h4>

            <ul class="text-sm text-gray-700 space-y-1">
                <li>• Gunakan pencarian untuk memfilter data siswa</li>
                <li>• Tombol print hanya mencetak area tabel</li>
                <li>• Pastikan data siswa lengkap sebelum validasi</li>
            </ul>
        </div>
    </div>
</x-app-layout>