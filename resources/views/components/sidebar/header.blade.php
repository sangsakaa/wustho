<div class="flex items-center justify-between px-4 py-4 border-b">

    @php
    $dashboardRoute = route('dashboard');

    if(auth()->user()?->hasRole('siswa')){
    $dashboardRoute = route('userdashboard');
    }

    if(auth()->user()?->hasRole('guru')){
    $dashboardRoute = route('gurudashboard');
    }
    @endphp

    <a href="{{ $dashboardRoute }}" class="flex items-center gap-3">

        <x-application-logo class="w-10 h-10" />

        <div
            x-show="isSidebarOpen || isSidebarHovered"
            class="flex flex-col">

            <span class="font-bold text-emerald-700">
                SMEDI
            </span>

            <span class="text-xs text-slate-500">
                Sistem Madrasah
            </span>

        </div>

    </a>

    <button
        x-show="isSidebarOpen || isSidebarHovered"
        @click="isSidebarOpen = !isSidebarOpen">

        <x-icons.menu-fold-left class="w-5 h-5" />
    </button>

</div>