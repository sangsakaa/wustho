<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Tambah Pelanggaran' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Form Tambah Pelanggaran') }}
    </h2>
  </x-slot>
  <div class="px-4 mt-4 ">
    <div class=" p-2">
      <div class="  grid grid-cols-2 w-full gap-4 ">
        <div class=" bg-white p-4  grid-cols-1 gap-2 capitalize">
          <span>Form </span>
          <form action="/addpelanggaran" method="post">
            @csrf
            <label for="">kode_pelanggaran</label>
            <input type="text" name="kode_pelanggaran" class=" w-full py-1 " placeholder="kode_pelanggaran : 001 " value="{{old('kode_pelanggaran')}}">
            @error('kode_pelanggaran')
            <div class=" text-red-500">{{ $message }}</div>
            @enderror
            <label for="">nama_pelanggaran</label>
            <input type="text" name="nama_pelanggaran" class=" w-full py-1 " placeholder=" nama_pelanggaran" value="{{old('nama_pelanggaran')}}">
            @error('nama_pelanggaran')
            <div class=" text-red-500">{{ $message }}</div>
            @enderror
            <label for="">type_pelanggaran</label><br>
            <!-- <input type="text" name="type_pelanggaran" class=" w-full py-1 " placeholder=" type_pelanggaran"> -->
            <select name="type_pelanggaran" id="" class=" w-full py-1 capitalize">
              <option value="">pilih type pelanggaran</option>
              <option value="ringan">ringan</option>
              <option value="sedang">sedang</option>
              <option value="berat">berat</option>
            </select>
            @error('type_pelanggaran')
            <div class=" text-red-500">{{ $message }}</div>
            @enderror
            <label for="">poin_pelanggaran</label>
            <input type="text" name="poin_pelanggaran" class=" w-full py-1 " placeholder=" poin_pelanggaran: min: 1 max:100">
            @error('poin_pelanggaran')
            <div class=" text-red-500">{{ $message }}</div>
            @enderror
            <button type="submit" class=" bg-blue-600 text-white rounded-md px-2 py-1 mt-2"> simpan</button>
            <a href="/addpelanggaran" class=" bg-sky-600 text-white rounded-md px-2 py-1">Reset</a>
          </form>
        </div>
        <div class=" bg-white p-4">
          <span class=" capitalize"> list pelanggaran</span>
          <table class=" w-full">
            <thead>
              <tr class=" border capitalize bg-gray-100">
                <th class=" border text-center">no</th>
                <th class=" border text-center">kode pelanggaran</th>
                <th class=" border text-center">nama pelanggaran</th>
                <th class=" border text-center">type pelanggaran</th>
                <th class=" border text-center">poin</th>
                <th class=" border text-center">act</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pelanggaran as $list)
              <tr class=" capitalize border">
                <td class=" border text-center">{{$loop->iteration}}</td>
                <td class=" border text-center">{{$list->kode_pelanggaran}}</td>
                <td class=" border text-center">{{$list->nama_pelanggaran}}</td>
                <td class=" border text-center">{{$list->type_pelanggaran}}</td>
                <td class=" border text-center">{{$list->poin_pelanggaran}}</td>
                <td class=" border text-center">
                  <form action="/addpelanggaran/{{$list->id}}" method="post">
                    @method('delete')
                    @csrf
                    <button>delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</x-app-layout>