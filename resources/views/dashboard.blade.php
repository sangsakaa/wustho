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
    <div class=" grid grid-cols-2 gap-2 sm:grid-cols-4">
        <div class="p-6 mt-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 dark:text-purple-600">
            NIS : {{$siswa}}
        </div>
        <div class="p-6 mt-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            LK : {{$lk}}
        </div>
        <div class="p-6 mt-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            PR : {{$pr}}
        </div>
        <div class=" flex p-6 mt-2 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> : {{$pa}} Pa <br>
            <x-icons.home class="flex-shrink-0 w-6 h-6" aria-hidden="true" /> : {{$pi}} Pi
        </div>
    </div>
</x-app-layout>