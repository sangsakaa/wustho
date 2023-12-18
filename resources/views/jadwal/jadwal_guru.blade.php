<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Daftar Jadwal' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <form action="/jadwal-guru/{{$jadwal->id}}" method="post">
        <div class=" bg-white grid sm:grid-cols-2 grid-cols-1 px-2 py-2 gap-2">
            @csrf
            <input type="hidden" name="jadwal_id" value="{{$jadwal->id}}">
            <label for="hari">Pilih Pengajar </label>
            <select id="hari" name="guru_id" class=" py-1">
                <option value="">Pilih Pengajar</option>
                @foreach ($daftarGuru as $item)
                <option value="{{$item->id}}" @if($item->id == $jadwal->guru_id) selected @endif>
                    {{$item->nama_guru}}
                </option>
                @endforeach
            </select>
            <label for="hari">Pilih Mata Pelajaran </label>
            <select id="hari" name="mapel_id" class=" py-1">
                <option value="">Pilih Mata Pelajaran</option>
                @foreach($daftarMapel as $item)
                <option value="{{$item->id}}" @if($item->id == $jadwal->mapel_id) selected @endif>
                    {{$item->kelas}} - {{$item->mapel}} {{$item->periode}} {{$item->ket_semester}}
                </option>
                @endforeach
            </select>
            <div></div>
            <div class="  gap-2 justify-end flex ">
                <a href="/Daftar-Jadwal" class=" bg-red-600 px-1 py-1 text-white">Kembali</a><button class=" bg-red-600 px-1 py-1 text-white">Simpan</button>
            </div>
        </div>
    </form>

    <div class=" mt-2 bg-white grid sm:grid-cols-1 grid-cols-1 px-2 py-2 gap-2">
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class=" grid grid-cols-2">
            <div>Hari</div>
            <div class=" capitalize"> : {{$jadwal->hari}}</div>
        </div>

        <table class=" w-full">
            <thead>
                <tr>
                    <th class=" border text-center">No</th>

                    <th class=" border text-center">Daftar Pendidik</th>
                    <th class=" border text-center">Nama Kitab</th>
                    <th class=" border text-center">ACT</th>

                </tr>
            </thead>
            <tbody>
                @foreach($daftarJadwal as $list)
                <tr class=" even:bg-gray-100">
                    <th class=" border text-center">{{$loop->iteration}}</th>

                    <td class=" border text-center">{{$list->nama_guru}}</td>
                    <td class=" border text-center">{{$list->nama_kitab}}</td>
                    <td class=" border text-center">

                        <form action="/jadwal-guru/{{$list->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button class=" bg-red-600 px-1 py-1 text-white">
                                Delete
                            </button>
                            <a class=" bg-yellow-400 px-1 py-1 text-black" href="/edit-jadwal/{{$list->id}}">Edit</a>
                        </form>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>
    </div>

</x-app-layout>