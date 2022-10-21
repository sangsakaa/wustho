<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black" class="justify-center max-w-xs gap-2">
                <x-icons.usercircle class="w-6 h-6" aria-hidden="true" />
                <span>Star on Github</span>
            </x-button>
        </div>
    </x-slot>
    <div class="px-6 py-2 overflow-hidden bg-white shadow-md dark:bg-dark-eval-1">
        {{ __("You're logged in!")  }} <br> <span class=" flex capitalize">
            User Log : {{Auth::user()->name}}
        </span>
    </div>
    <div class=" grid grid-cols-1 gap-2 sm:grid-cols-6 p-4">
        <div class=" bg-green-700 p-3 rounded-md text-center text-white">NIS : {{$siswa}}</div>
        <div class=" bg-blue-700 p-3 rounded-md text-center text-white">USER : {{Auth::user()->count()}}</div>
        <div class=" bg-blue-700 p-3 rounded-md text-center text-white">LK : {{$lk}}</div>
        <div class=" bg-pink-600 p-3 rounded-md text-center text-white">PR : {{$pr}}</div>
        <div class=" bg-blue-700 p-3 rounded-md text-center text-white">PA : {{$pa}}</div>
        <div class=" bg-pink-600 p-3 rounded-md text-center text-white">PI : {{$pi}}</div>
    </div>
    </div>
</x-app-layout>