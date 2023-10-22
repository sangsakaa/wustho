<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Nomor Induk Siswa' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update  Nomor Induk Siswa ') }} : {{$nisSiswa->nama_siswa}} -{{$nisSiswa->nis}}
        </h2>
    </x-slot>

    <div class=" px-4">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2">
                        <div class=" py-1">


                            <form action="/nis/{{$nis->id}}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="siswa_id" value="{{$nis->siswa_id}}" class=" py-1" required>
                                <input type="text" name="nis" value="{{$nis->nis}}" class=" py-1">
                                <select name="madrasah_diniyah" id="" class=" py-1">
                                    <option {{old('madrasah_diniyah',$nis->madrasah_diniyah)=="Ula"? 'selected':''}} value="Ula">
                                        Ula</option>
                                    <option {{old('madrasah_diniyah',$nis->madrasah_diniyah)=="Wustho"? 'selected':''}} value="Wustho">
                                        Wustho</option>
                                    <option {{old('madrasah_diniyah',$nis->madrasah_diniyah)=="Ulya"? 'selected':''}} value="Ulya">
                                        Ulya</option>
                                </select>
                                <select name="nama_lembaga" id="" class=" py-1">
                                    <option value="Wahidiyah">--Wahidiyah--</option>
                                </select>
                                <input type="date" name="tanggal_masuk" id="" class=" py-1" required value="{{$nis->tanggal_masuk}}">
                                <button class=" bg-blue-600 py-1 px-2 text-white rounded-sm">Update NIS</button>
                                <a href="/nis/{{$nis->siswa_id}}" class=" bg-blue-600 py-1 px-2 text-white rounded-sm">Batal</a>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>






</x-app-layout>