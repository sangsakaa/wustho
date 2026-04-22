<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Edit Kelas Madin')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Edit Kelas Madrasah Wustho
        </h2>
    </x-slot>

    <div class="p-4">
        <div class="max-w-xl mx-auto">

            <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">

                <!-- INFO (READ ONLY) -->
                <div class="bg-gray-50 p-3 rounded text-sm text-gray-600">
                    <p><strong>Nama Kelas:</strong> {{ $kelasmi->nama_kelas }}</p>
                    <p><strong>Periode:</strong> {{ $kelasmi->periode_id }}</p>
                </div>

                <!-- ERROR -->
                @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded text-sm">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- FORM -->
                <form action="/kelas_mi/{{ $kelasmi->id }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <!-- KUOTA -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kuota Kelas
                        </label>
                        <input type="number"
                            name="kuota"
                            value="{{ old('kuota', $kelasmi->kuota) }}"
                            class="w-full border rounded-md px-3 py-2 text-sm focus:ring focus:ring-sky-200"
                            placeholder="Contoh: 40">
                    </div>

                    <!-- ACTION -->
                    <div class="flex justify-between items-center pt-2">
                        <a href="/kelas_mi"
                            class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-md">
                            ← Kembali
                        </a>

                        <button type="submit"
                            class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-sm rounded-md shadow">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>