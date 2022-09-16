<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembelajaran') }}
        </h2>
    </x-slot>

    <div class=" px-4">
        <div class="py-4">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class=" bg-white border-b border-gray-200">
                        <div class=" px-4 py-1">
                            <span class=" text-2xl  text-blue-400">Input Nilai</span>
                        </div>
                        <hr>
                        <div class=" py-2 px-6">
                            <div class=" grid grid-cols-2 py-1">
                                <div class=" grid grid-cols-2 ">
                                    <div>Guru</div>
                                    <div>: M. Nasir</div>
                                    <div>Periode</div>
                                    <div>: 2022/2023 Ganjil</div>
                                </div>
                                <div class=" grid grid-cols-2">
                                    <div>Mata Pelajaran</div>
                                    <div>: Fiqih</div>
                                    <div>Kelas</div>
                                    <div>: 1B</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form action="/nilai" method="post">
                            @csrf
                            <div class=" grid grid-cols-2  py-1">
                                <span class=" grid">
                                    Dafta Nilai
                                </span>
                                <div class=" grid justify-items-end">
                                    <button class=" bg-red-600 py-1 rounded-md text-white px-4">simpan</button>
                                </div>
                            </div>
                            <table class=" w-full">
                                <thead>
                                    <tr class="border">
                                        <th class=" border px-2">#</th>
                                        <th class=" border px-2 w-1/2">NAMA SISWA</th>
                                        <th class=" border px-2">KELAS</th>
                                        <th class=" border px-2">UH 1</th>
                                        <th class=" border px-2">UH 2</th>
                                        <th class=" border px-2">UH 3</th>
                                        <th class=" border px-2">UTS</th>
                                        <th class=" border px-2">UAS</th>
                                        <th class=" border px-2">NT</th>
                                        <th class=" border px-2">R2</th>
                                        <th class=" border px-2">Index</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datanilai as $nilai)
                                    <tr class=" border hover:bg-gray-100">
                                        <th class=" border px-2">{{$loop->iteration}}</th>
                                        <th class=" border text-left px-2">{{$nilai->nama}}<input type="hidden" name="siswa_id[{{ $nilai->siswa_id }}]" value="{{$nilai->siswa_id}}"></th>
                                        <th class=" border">
                                            {{$nilai->kelas}}<input type="hidden" name="kelas_id[{{ $nilai->siswa_id }}]" value="{{$nilai->kelas_id}}">
                                        </th>
                                        <td class=" text-center border py-1 px-1">
                                            <input type="text" name="uh1[{{ $nilai->siswa_id }}]" value="{{$nilai->uh1}}" class=" py-1 px-1 text-center w-10">
                                        </td>
                                        <td class="text-center border py-1 px-1">
                                            <input type="text" name="uh2[{{ $nilai->siswa_id }}]" value="{{$nilai->uh2}}" class=" py-1 px-1 text-center w-10">
                                        </td>
                                        <td class="text-center border py-1 px-1">
                                            <input type="text" name="uh3[{{ $nilai->siswa_id }}]" value="{{$nilai->uh3}}" class=" py-1 px-1 text-center w-10">
                                        </td>
                                        <td class="text-center border py-1 px-1">
                                            <input type="text" name="uts[{{ $nilai->siswa_id }}]" value="{{$nilai->uts}}" class=" py-1 px-1 text-center w-10">
                                        </td>
                                        <td class="text-center border py-1 px-1">
                                            <input type="text" name="uas[{{ $nilai->siswa_id }}]" value="{{$nilai->uas}}" class=" py-1 px-1 text-center w-10">
                                        </td>
                                        <td class="text-center border py-1 px-1 ">{{$nilai->uh1 + $nilai->uh2 +$nilai->uh3 +$nilai->uts + $nilai->uas}}</td>
                                        <td class="text-center border py-1 px-1 ">{{($nilai->uh1 + $nilai->uh2 +$nilai->uh3 +$nilai->uts + $nilai->uas)/5}}</td>
                                        <td class="text-center border py-1 px-1 ">


                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>