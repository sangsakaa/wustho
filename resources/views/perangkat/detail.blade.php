<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Jabatan') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- DETAIL CARD -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Perangkat</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                    <div class="font-medium text-gray-600">Nama</div>
                    <div class="text-gray-800">
                        {{ strlen($perangkat->nama_perangkat) > 20 
                            ? substr($perangkat->nama_perangkat, 0, 20) . '...' 
                            : $perangkat->nama_perangkat ?? '-' }}
                    </div>

                    <div class="font-medium text-gray-600">Jabatan</div>
                    <div class="text-gray-800">
                        @if(empty($perangkat->Jabatan) || empty($perangkat->Jabatan->titleJab))
                        -
                        @else
                        @foreach($perangkat->Jabatan->titleJab as $list)
                        <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs mr-1">
                            {{ $list->nama_jabatan }}
                        </span>
                        @endforeach
                        @endif
                    </div>

                </div>
            </div>

            <!-- FORM CARD -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Update Jabatan</h3>

                <form action="" method="post" class="flex flex-col md:flex-row gap-4 items-start md:items-center">
                    @csrf

                    <!-- SELECT JABATAN -->
                    <select name="jabatan_id"
                        class="w-full md:w-1/2 px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $jab)
                        <option value="{{$jab->id}}"
                            {{ optional($perangkat->jabatan)->jabatan_id == $jab->id ? 'selected' : '' }}>
                            {{$jab->nama_jabatan}}
                        </option>
                        @endforeach
                    </select>

                    <!-- BUTTON -->
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>