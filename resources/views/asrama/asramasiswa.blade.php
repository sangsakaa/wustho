<x-app-layout>

    <x-slot name="header">
        @section('title', ' | Asrama Siswa')

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @role('pengurus')
            Asrama Santri
            @endrole

            @role('super admin')
            Asrama Siswa
            @endrole
        </h2>
    </x-slot>

    <div class="p-4 space-y-4">

        {{-- HEADER ACTION --}}
        <div class="bg-white rounded-xl shadow p-4 flex justify-between items-center">

            <div>
                <h3 class="font-semibold text-gray-800">
                    Manajemen Asrama
                </h3>

                <p class="text-sm text-gray-500">
                    Transfer data asrama dari periode sebelumnya ke periode aktif.
                </p>
            </div>

            <button
                onclick="openTransferModal()"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                <i class="fas fa-exchange-alt mr-1"></i>
                Transfer Data
            </button>

        </div>

        {{-- LIVEWIRE --}}
        <div class="bg-white rounded-xl shadow">
            <livewire:list-asrama />
        </div>

    </div>

    {{-- MODAL TRANSFER --}}
    <div id="transferModal"
        class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">

            <div class="flex items-center gap-3 mb-4">

                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7h8m-8 5h8m-8 5h5" />
                    </svg>
                </div>

                <div>
                    <h3 class="font-bold text-lg text-gray-800">
                        Konfirmasi Transfer
                    </h3>

                    <p class="text-sm text-gray-500">
                        Transfer data asrama ke periode aktif.
                    </p>
                </div>

            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm text-yellow-700">

                <strong>Perhatian:</strong>

                <ul class="list-disc ml-5 mt-1">
                    <li>Data akan diambil dari periode sebelumnya.</li>
                    <li>Data yang sudah ada tidak akan ditambahkan lagi.</li>
                    <li>Tidak akan terjadi duplikasi data.</li>
                </ul>

            </div>

            <form action="{{ route('asrama.transfer') }}"
                method="POST"
                class="mt-5">

                @csrf

                <div class="flex justify-end gap-2">

                    <button
                        type="button"
                        onclick="closeTransferModal()"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Ya, Transfer
                    </button>

                </div>

            </form>

        </div>

    </div>

    {{-- SWEET ALERT --}}
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            confirmButtonColor: '#16a34a'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: @json(session('error')),
            confirmButtonColor: '#dc2626'
        });
    </script>
    @endif

    <script>
        function openTransferModal() {
            document.getElementById('transferModal').classList.remove('hidden');
        }

        function closeTransferModal() {
            document.getElementById('transferModal').classList.add('hidden');
        }
    </script>

</x-app-layout>