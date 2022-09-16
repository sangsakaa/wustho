<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Transkip Nilai ' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transkip Nilai') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-2 bg-white border-b border-gray-200">
                    <a href="/siswa">
                        <!-- <button class=" bg-blue-600 text-white rounded-sm px-2 py-1"> siswa</button> -->
                    </a>

                    <table class=" w-full">
                        <thead>
                            <tr>
                                <td class=" capitalize">Mata Pelajaran</td>
                                <td class=" capitalize">nilai ujian</td>
                                <td class=" capitalize">nilai harian</td>
                            </tr>
                        </thead>
                        <tbody>
                            {{$pesertakelas}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</x-app-layout>