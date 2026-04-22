<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Tambah Kelas
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="max-w-xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <!-- TITLE -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Tambah Data Kelas
                    </h3>
                    <p class="text-sm text-gray-500">
                        Silakan isi data kelas dengan benar
                    </p>
                </div>

                <!-- ERROR -->
                @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                    <ul class="text-sm list-disc ml-4">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- FORM -->
                <form action="/kelas" method="POST" class="space-y-4">
                    @csrf

                    <!-- INPUT KELAS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama / Tingkat Kelas
                        </label>
                        <input type="text"
                            name="kelas"
                            value="{{ old('kelas') }}"
                            placeholder="Contoh: 1 / 2 / 3"
                            class="w-full border rounded-md px-3 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none">
                    </div>

                    <!-- ACTION BUTTON -->
                    <div class="flex justify-between items-center pt-2">

                        <a href="/kelas"
                            class="text-sm px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded-md">
                            ← Kembali
                        </a>

                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md shadow">
                            Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>