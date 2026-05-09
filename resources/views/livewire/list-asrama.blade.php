<div class="space-y-5">

    {{-- MAIN CARD --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">

        {{-- HEADER --}}
        <div class="p-4 sm:p-5 border-b border-gray-100 dark:border-gray-800">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                {{-- TITLE --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                        Dashboard Asrama
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Monitoring kuota dan penghuni asrama
                    </p>
                </div>

                {{-- ACTION --}}
                <div class="flex flex-col sm:flex-row gap-2">

                    <a href="/addasramasiswa"
                        class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-sm transition">

                        <span>+</span>
                        <span>Asrama Siswa</span>

                    </a>

                    <a href="/asrama"
                        class="inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-sm transition">

                        <span>📋</span>
                        <span>Data Asrama</span>

                    </a>

                </div>

            </div>

        </div>

        {{-- STATISTIC --}}
        <div class="p-4 sm:p-5">

            <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

                {{-- TOTAL --}}
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">

                    <p class="text-sm text-blue-600 font-medium">
                        Total Asrama
                    </p>

                    <h3 class="text-2xl font-bold text-blue-700 mt-1">
                        {{ $data->count() }}
                    </h3>

                </div>

                {{-- KUOTA --}}
                <div class="bg-green-50 border border-green-100 rounded-2xl p-4">

                    <p class="text-sm text-green-600 font-medium">
                        Total Kuota
                    </p>

                    <h3 class="text-2xl font-bold text-green-700 mt-1">
                        {{ $data->sum('kuota') }}
                    </h3>

                </div>

                {{-- TERISI --}}
                <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-4">

                    <p class="text-sm text-yellow-600 font-medium">
                        Total Terisi
                    </p>

                    <h3 class="text-2xl font-bold text-yellow-700 mt-1">
                        {{ $data->sum('pesertaasrama_count') }}
                    </h3>

                </div>

                {{-- SISA --}}
                <div class="bg-purple-50 border border-purple-100 rounded-2xl p-4">

                    <p class="text-sm text-purple-600 font-medium">
                        Sisa Kuota
                    </p>

                    <h3 class="text-2xl font-bold text-purple-700 mt-1">
                        {{ $data->sum('kuota') - $data->sum('pesertaasrama_count') }}
                    </h3>

                </div>

            </div>

        </div>

        {{-- SEARCH --}}
        <div class="px-4 sm:px-5 pb-4">

            <div class="flex justify-end">

                <input type="search"
                    wire:model.live="search"
                    placeholder="Cari nama asrama..."
                    class="w-full sm:w-72 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

            </div>

        </div>

        {{-- TOAST --}}
        @if (session('update'))
        <script>
            Toastify({
                text: "Data berhasil di update",
                duration: 3000,
                gravity: "top",
                position: "right",
                close: true,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                }
            }).showToast();
        </script>
        @endif

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="min-w-[1100px] w-full text-sm">

                {{-- TABLE HEAD --}}
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-xs">

                    <tr>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            No
                        </th>

                        @role('super admin')
                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Periode
                        </th>
                        @endrole

                        <th class="px-4 py-3 text-left whitespace-nowrap">
                            Asrama
                        </th>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Tipe
                        </th>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Kuota
                        </th>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Terisi
                        </th>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Progress
                        </th>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Status
                        </th>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Keterangan
                        </th>

                        <th class="px-4 py-3 text-center whitespace-nowrap">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- TABLE BODY --}}
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                    @forelse ($data as $item)

                    @php
                    $persen = $item->kuota > 0
                    ? ($item->pesertaasrama_count / $item->kuota) * 100
                    : 0;
                    @endphp

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">

                        {{-- NO --}}
                        <td class="px-4 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        {{-- PERIODE --}}
                        @role('super admin')
                        <td class="px-4 py-4 text-center whitespace-nowrap">

                            <a href="pesertaasrama/{{$item->id}}"
                                class="text-blue-600 hover:underline">

                                {{ $item->periode->periode }}

                            </a>

                        </td>
                        @endrole

                        {{-- ASRAMA --}}
                        <td class="px-4 py-4 whitespace-nowrap">

                            <a href="pesertaasrama/{{$item->id}}"
                                class="font-semibold hover:underline
                                    {{ optional($item->asrama)->type_asrama == 'Putra'
                                        ? 'text-blue-600'
                                        : 'text-pink-600' }}">

                                {{ optional($item->asrama)->nama_asrama ?? 'Asrama tidak ditemukan' }}

                            </a>

                        </td>

                        {{-- TYPE --}}
                        <td class="px-4 py-4 text-center">

                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ optional($item->asrama)->type_asrama == 'Putra'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-pink-100 text-pink-700' }}">

                                {{ optional($item->asrama)->type_asrama ?? '-' }}

                            </span>

                        </td>

                        {{-- KUOTA --}}
                        <td class="px-4 py-4 text-center font-medium">
                            {{ $item->kuota }}
                        </td>

                        {{-- TERISI --}}
                        <td class="px-4 py-4 text-center font-medium">
                            {{ $item->pesertaasrama_count }}
                        </td>

                        {{-- PROGRESS --}}
                        <td class="px-4 py-4 min-w-[180px]">

                            <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">

                                <div class="h-2.5 rounded-full
                                    {{ $persen >= 100 ? 'bg-red-500' : 'bg-blue-500' }}"
                                    style="width: {{ $persen }}%">

                                </div>

                            </div>

                            <p class="text-xs text-gray-500 mt-1 text-center">
                                {{ $item->pesertaasrama_count }} / {{ $item->kuota }}
                            </p>

                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-4 text-center">

                            @if($item->pesertaasrama_count >= $item->kuota)

                            <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700 font-medium">
                                Penuh
                            </span>

                            @else

                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700 font-medium">
                                Tersedia
                            </span>

                            @endif

                        </td>

                        {{-- KETERANGAN --}}
                        <td class="px-4 py-4 text-center text-xs">

                            @if($item->pesertaasrama_count >= $item->kuota)

                            <span class="text-red-600 font-medium">
                                Kuota penuh
                            </span>

                            @else

                            <span class="text-green-600 font-medium">
                                Sisa {{ $item->kuota - $item->pesertaasrama_count }}
                            </span>

                            @endif

                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-4">

                            <div class="flex justify-center gap-2">

                                @role('super admin')
                                <form action="/asramasiswa/{{$item->id}}"
                                    method="post">

                                    @csrf
                                    @method('delete')

                                    <button
                                        onclick="return confirm('Yakin hapus data ini?')"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs transition">

                                        Hapus

                                    </button>

                                </form>
                                @endrole

                                <a href="asramasiswa/{{$item->id}}/edit"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs transition">

                                    Edit

                                </a>

                                <a href="pesertaasrama/{{$item->id}}"
                                    class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-1.5 rounded-lg text-xs transition">

                                    Detail

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="10"
                            class="text-center py-10 text-gray-500">

                            Data tidak ditemukan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- INFO --}}
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5">

        <h4 class="font-semibold text-blue-700 mb-3">
            Keterangan
        </h4>

        <ol class="list-decimal ml-5 space-y-2 text-sm text-gray-700">

            <li>
                Penambahan anggota asrama wajib memiliki
                <b>NIM</b>
            </li>

            <li>
                Jika belum memiliki NIM, silakan konfirmasi ke bagian
                <b>kesiswaan / kepala sekolah</b>
            </li>

        </ol>

    </div>

</div>