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
    <div class="px-6 py-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        {{ __("You're logged in!")  }} <br> <span class=" flex capitalize">
            User Log : {{Auth::user()->name}}
        </span>
    </div>
    <div class=" grid grid-cols-1 gap-2 sm:grid-cols-3">
        <div class=" grid grid-cols-2 p-6 mt-2 sm:mt-1 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 dark:text-purple-600">
            <div>NIS : {{$siswa}}</div>
            <div>USER : {{Auth::user()->count()}}</div>


        </div>
        <div class=" grid grid-cols-2 p-6 mt-1 sm:mt-1  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div>LK : {{$lk}}</div>
            <div>PR : {{$pr}}</div>
        </div>
        <div class=" grid grid-cols-2 p-6 mt-1 sm:mt-1  overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div>PA : {{$pa}}</div>
            <div>PI : {{$pi}}</div>
        </div>
    </div>
</x-app-layout>