<div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-white dark:bg-gray-900 dark:border-gray-800">

    {{-- ================= LOGO ================= --}}
    @php
    $dashboardRoute = route('dashboard');

    if(auth()->user()?->hasRole('siswa')) {
    $dashboardRoute = route('userdashboard');
    }

    if(auth()->user()?->hasRole('guru')) {
    $dashboardRoute = route('gurudashboard');
    }
    @endphp

    <a href="{{ $dashboardRoute }}"
        class="flex items-center gap-3 transition-all duration-200">

        {{-- Logo --}}
        <div class="flex items-center justify-center shrink-0">
            <x-application-logo
                aria-hidden="true"
                class="w-9 h-9 object-contain" />
        </div>

        {{-- Brand --}}
        <div
            x-show="isSidebarOpen || isSidebarHovered"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-x-2"
            x-transition:enter-end="opacity-100 translate-x-0"
            class="flex flex-col leading-tight">

            <span class="text-sm font-bold tracking-wide text-gray-800 dark:text-gray-100">
                SMEDI
            </span>

            <span class="text-[11px] text-gray-500 dark:text-gray-400">
                Sistem Manajemen Pendidikan
            </span>
        </div>
    </a>


    {{-- ================= TOGGLE BUTTON ================= --}}
    <x-button
        type="button"
        iconOnly
        srText="Toggle Sidebar"
        variant="secondary"
        class="rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-800 bg-white shadow-sm hover:shadow-md transition-all duration-200"
        x-show="isSidebarOpen || isSidebarHovered"
        @click="isSidebarOpen = !isSidebarOpen">

        {{-- Desktop --}}
        <x-icons.menu-fold-right
            x-show="!isSidebarOpen"
            aria-hidden="true"
            class="hidden w-5 h-5 text-gray-700 dark:text-gray-200 lg:block" />

        <x-icons.menu-fold-left
            x-show="isSidebarOpen"
            aria-hidden="true"
            class="hidden w-5 h-5 text-gray-700 dark:text-gray-200 lg:block" />

        {{-- Mobile --}}
        <x-heroicon-o-x
            aria-hidden="true"
            class="w-5 h-5 text-gray-700 dark:text-gray-200 lg:hidden" />
    </x-button>

</div>