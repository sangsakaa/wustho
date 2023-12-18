<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Update Daftar Jadwal' )
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Update Jadwal') }}
            </h2>

        </div>
    </x-slot>
    <form action="/edit-jadwal/{{$daftar_Jadwal->id}}/edit" method="post">
        <div class=" bg-white grid sm:grid-cols-2 grid-cols-1 px-2 py-2 gap-2">
            @csrf
            @method('patch')
            <input type="hidden" name="jadwal_id" value="{{$daftar_Jadwal->jadwal_id}}">
            <label for="hari">Pilih Pengajar </label>
            <select id="hari" name="guru_id" class=" py-1">
                @foreach ($dataGuru as $item)
                <option value="{{$item->id}}" @if($item->id == $daftar_Jadwal->guru_id) selected @endif>
                    {{$item->nama_guru}}
                </option>
                @endforeach
            </select>
            <label for="hari">Pilih Mata Pelajaran </label>
            <select id="hari" name="mapel_id" class=" py-1">
                <option value="">Pilih Mata Pelajaran</option>
                @foreach($daftarMapel as $item)
                <option value="{{$item->id}}" @if($item->id == $daftar_Jadwal->mapel_id) selected @endif>
                    {{$item->kelas}} - {{$item->mapel}} {{$item->periode}} {{$item->ket_semester}}
                </option>
                @endforeach

            </select>
            <div></div>
            <div class="  gap-2 justify-end flex ">

                <a href="/jadwal-guru/{{$daftar_Jadwal->jadwal_id}}" class=" bg-red-600 px-1 py-1 text-white">Kembali</a>
                <button class=" bg-blue-600 px-1 py-1 text-white">Update</button>
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


    </div>

</x-app-layout>