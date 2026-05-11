@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

$dbOnline = true;
$user = null;
$periodeAktif = null;

try {
DB::connection()->getPdo();

$user = Auth::user();

if (isset($dataperiode) && $dataperiode->count()) {
$periodeAktif = $dataperiode->firstWhere('id', session('periode_id'))
?? $dataperiode->firstWhere('is_active', true)
?? $dataperiode->first();
}
} catch (\Exception $e) {
$dbOnline = false;
}
@endphp

<nav aria-label="secondary"
    x-data="{ open: false }"
    class="sticky top-0 z-10 flex items-center justify-between px-4 py-2 sm:px-6 transition-transform duration-500 bg-white dark:bg-dark-eval-1"
    :class="{
        '-translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    <div class="flex items-center gap-3">
        <x-button type="button" class="md:hidden" iconOnly variant="secondary"
            srText="Toggle dark mode" @click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" class="w-6 h-6" />
        </x-button>
    </div>

    <div class="flex items-center gap-3">

        {{-- DROPDOWN PERIODE --}}
        @if($dbOnline && $periodeAktif)
        <x-dropdown align="top" width="48">
            <x-slot name="trigger">
                <button class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">
                    <div>
                        {{ $periodeAktif->periode ?? '-' }}
                        {{ $periodeAktif->ket_semester ?? '' }}
                    </div>

                    <div class="ml-1">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path d="M5.293 7.293L10 12l4.707-4.707" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                @foreach ($dataperiode as $list)
                <form method="POST" action="{{ route('setperiode') }}">
                    @csrf
                    <input type="hidden" name="periode_id" value="{{ $list->id }}">

                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 flex justify-between">

                        <span>
                            {{ $list->periode }}
                            {{ $list->semester->ket_semester ?? '' }}
                        </span>

                        <span>
                            @if(session('periode_id') == $list->id)
                            <span class="text-blue-500 text-xs">(Dipilih)</span>
                            @elseif($list->is_active)
                            <span class="text-green-500 text-xs">(Aktif)</span>
                            @endif
                        </span>
                    </button>
                </form>
                @endforeach
            </x-slot>
        </x-dropdown>
        @else
        <div class="px-3 py-2 text-sm text-red-500 font-medium">
            Database Offline
        </div>
        @endif


        {{-- DARK MODE --}}
        <x-button type="button" class="hidden md:inline-flex" iconOnly variant="secondary"
            srText="Toggle dark mode" @click="toggleTheme">
            <x-heroicon-o-moon x-show="!isDarkMode" class="w-6 h-6" />
            <x-heroicon-o-sun x-show="isDarkMode" class="w-6 h-6" />
        </x-button>


        {{-- USER DROPDOWN --}}
        @if($dbOnline && $user)
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700">

                    <div>{{ $user->name }}</div>

                    <div class="ml-1">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
        @endif

    </div>
</nav>


{{-- MOBILE BOTTOM BAR --}}
<div class="fixed inset-x-0 bottom-0 flex items-center justify-between px-4 py-4 sm:px-6 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1"
    :class="{
        'translate-y-full': scrollingDown,
        'translate-y-0': scrollingUp,
    }">

    <x-button type="button" iconOnly variant="secondary" srText="Search">
        <x-heroicon-o-search class="w-6 h-6" />
    </x-button>

    @if($dbOnline && $user)
    @role('super admin')
    <a href="{{ route('dashboard') }}">
        <x-application-logo class="w-10 h-10" />
    </a>
    @endrole

    @role('siswa')
    <a href="{{ route('userdashboard') }}">
        <x-application-logo class="w-10 h-10" />
    </a>
    @endrole
    @endif

    <x-button type="button" iconOnly variant="secondary"
        srText="Open main menu"
        @click="isSidebarOpen = !isSidebarOpen">
        <x-heroicon-o-menu x-show="!isSidebarOpen" class="w-6 h-6" />
        <x-heroicon-o-x x-show="isSidebarOpen" class="w-6 h-6" />
    </x-button>
</div>