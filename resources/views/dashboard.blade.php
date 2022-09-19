<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="px-4 mt-2">
        <div class=" grid grid-cols-1 sm:grid-cols-4 gap-2">
            <div class="bg-sky-400  text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" grid grid-cols-2">
                    <div class=" p-4">
                        <span> Siswa Putra</span>
                        <p>{{$lk}}</p>
                    </div>
                    <div class=" p-4 ">
                        <span> Siswi Putri</span>
                        <p class=" flex pr-2 ">{{$pr}} </p>
                    </div>
                </div>
            </div>
            <div class="bg-blue-400  text-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" flex">
                    <div class=" p-4">
                        <span> Total Siswa Siswi </span>
                        <p>{{$siswa}}</p>
                    </div>
                    <div class=" p-4 flex justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 ">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                </div>
            </div>

        </div>


    </div>
</x-app-layout>