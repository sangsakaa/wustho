<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="px-4 mt-4 ">
        <div class=" grid grid-cols-1 sm:grid-cols-4 gap-2">
            <div class=" bg-green-800 hover:bg-purple-500  text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" grid  grid-cols-2   ">
                    <div class=" mt-3 px-4 ">
                        <span class=" text-5xl font-mono  ">
                            {{$siswa}}
                        </span>
                        <p>Nomor Induk Siswa</p>
                    </div>
                    <div class=" flex justify-end py-1 ">
                        <span class=" text-5xl font-mono">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>