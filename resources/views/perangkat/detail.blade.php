<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Jabatan') }}
        </h2>
    </x-slot>
    <div class="px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                    <div class=" grid grid-cols-2 py-6 px-4">
                        <div>Nama</div>
                        <div> : {{ strlen($perangkat->nama_perangkat) > 14 ? substr($perangkat->nama_perangkat, 0, 14) . '..' : $perangkat->nama_perangkat ?? '-' }}
                        </div>
                        <div>Jabatan</div>
                        <div> :
                            @if($perangkat->Jabatan == null)
                            -
                            @else
                            @foreach($perangkat->Jabatan->titleJab as $lits)
                            {{ $lits->nama_jabatan ?? '-' }}
                            @endforeach
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 py-2">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/siswa">
                        <!-- <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> siswa</button> -->
                    </a>
                    <div class=" grid grid-cols-1 py-6 px-4">
                        <form action="" method="post">
                            @csrf
                            <input type="text" name="jabatan_id" value="{{$perangkat->id}}" class=" hidden py-1 w-1/2">
                            <select name="jabatan_id" id="" class="py-1 w-1/2">
                                @foreach($jabatan as $jab)
                                <option value="{{$jab->id}}" {{ optional($perangkat['jabatan'])->jabatan_id == $jab->id ? 'selected' : '' }}>
                                    {{$jab->nama_jabatan}}
                                </option>
                                @endforeach
                            </select>

                            <button class=" bg-blue-500 text-white px-2 py-1">simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>