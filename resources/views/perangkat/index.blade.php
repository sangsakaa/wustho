<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Perangkat')
        <h2 class="font-semibold text-xl text-gray-800">
            Dashboard Perangkat
        </h2>
    </x-slot>

    <div class="p-4 bg-gray-100 min-h-screen space-y-4" x-data="{ tab: 'aktif' }">

        {{-- ACTION BUTTON --}}
        <div class="bg-white shadow rounded-xl p-4 flex flex-wrap gap-2">
            <a href="/form-perangkat"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                + Tambah Data
            </a>

            <a href="/jabatan"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                + Tambah Jabatan
            </a>
        </div>

        {{-- TAB --}}
        <div class="flex gap-2">
            <button @click="tab='aktif'"
                :class="tab=='aktif' ? 'bg-blue-600 text-white' : 'bg-gray-200'"
                class="px-4 py-2 rounded-lg text-sm">
                Aktif ({{ $aktif->count() }})
            </button>

            <button @click="tab='nonaktif'"
                :class="tab=='nonaktif' ? 'bg-blue-600 text-white' : 'bg-gray-200'"
                class="px-4 py-2 rounded-lg text-sm">
                Non Aktif ({{ $nonAktif->count() }})
            </button>
        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow rounded-xl p-4">

            <div class="mb-3">
                <h3 class="font-semibold text-lg">Data Perangkat</h3>
            </div>

            <div class="overflow-x-auto">

                {{-- ================= AKTIF ================= --}}
                <div x-show="tab==='aktif'">
                    <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        @include('perangkat.table', ['data' => $aktif])
                    </table>
                </div>

                {{-- ================= NON AKTIF ================= --}}
                <div x-show="tab==='nonaktif'">
                    <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        @include('perangkat.table', ['data' => $nonAktif])
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>