<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Periode' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengaturan Periode') }}
        </h2>
    </x-slot>
    <div class=" grid grid-cols-2 gap-2 px-2 py-2">
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 flex grid-cols-1 gap-1">
                            <a href="/periode" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                periode
                            </a>
                            <a href="/pengaturan" class=" py-1 px-2 bg-blue-600 rounded-md text-white hover:bg-purple-500">
                                pengaturan
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class=" mx-auto ">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" p-6 grid grid-cols-1">
                            <form action="/periode" method="post">
                                @csrf
                                <label for="">Periode</label>
                                <input name="periode" type="text" class=" w-full sm:w-full py-1 rounded-md" placeholder="  Periode : 2022/2023">
                                <label for="">Semester</label>
                                <select name="semester_id" id="" class=" w-full py-1 rounded-md">
                                    @foreach($semester as $list)
                                    <option value="{{$list->id}}">{{$list->ket_semester}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class=" px-2 py-1 bg-blue-600 text-white rounded-md mt-1">Simpan</button>
                                <a href="/siswa" class=" px-2 py-1 bg-red-600 text-white rounded-md mt-1">
                                    Batal
                                </a>
                            </form>

                            <table class=" border">
                                <thead class=" border">
                                    <tr class=" capitalize bg-gray-100">
                                        <th class=" border px-2 py-1">No</th>
                                        <th class=" border px-2 py-1 text-center">Periode</th>
                                        <th class=" border px-2 py-1 text-center">semester</th>
                                        <th class=" border px-2 py-1 text-center">Ket Semester</th>
                                        <th class=" border px-2 py-1 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($periode as $list)
                                    <tr class=" hover:bg-gray-100">
                                        <th class=" border py-1">
                                            <a href="/report/{{$list->id}}"> {{$loop->iteration}}</a>
                                        </th>
                                        <th class=" border px-2 text-center">
                                            <a href="/report/{{$list->id}}"> {{$list->periode}}</a>
                                        </th>
                                        <th class=" border px-2 text-center">
                                            <a href="/report/{{$list->id}}"> {{$list->semester}}</a>
                                        </th>
                                        <th class=" border px-2 text-center">
                                            <a href="/report/{{$list->id}}"> {{$list->ket_semester}}</a>
                                        </th>
                                        <th class=" border px-2 text-center">
                                            <form action="/periode/{{$list->id}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class=" bg-red-500 text-white p-1 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg></button>
                                            </form>
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>