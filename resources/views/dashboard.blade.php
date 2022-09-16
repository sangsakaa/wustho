<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Dashboard' )
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="px-4 mt-4">
        <div class=" mx-auto ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-green-900 border-b border-gray-200 text-white">
                    <p class=" text-sm text-center uppercase font-semibold sm:text-3xl">pondok pesantren putra putri</p>
                    <p class="  text-sm sm:text-4xl text-center uppercase font-semibold">{{$profile->nama_madin}}</p>
                    <p class=" text-sm sm:text-2xl text-center">{{$profile->alamat}}</p>

                </div>
            </div>
        </div>
    </div>
    <div class="mt-1">
        <hr class=" border-2 bg-blue-800 border-blue-800 ">
        <div class=" mx-auto mt-6 ">
            <div class="bg-blue-800 overflow-hidden shadow-sm sm:rounded-lg">
                -
            </div>
        </div>
    </div>
</x-app-layout>