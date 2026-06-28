<div class="p-3 border-t border-slate-200 dark:border-slate-700">

    @auth

    <div class="flex items-center gap-3">

        <div
            class="flex items-center justify-center w-10 h-10 font-bold text-white rounded-full bg-emerald-600">

            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}

        </div>

        <div x-show="isSidebarOpen || isSidebarHovered">

            <div class="text-sm font-semibold text-slate-800 dark:text-white">
                {{ auth()->user()->name }}
            </div>

            <div class="text-xs text-slate-500">
                {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
            </div>

        </div>

    </div>

    @else

    <div class="flex items-center gap-3">

        <div
            class="flex items-center justify-center w-10 h-10 font-bold text-white rounded-full bg-slate-400">

            ?

        </div>

        <div x-show="isSidebarOpen || isSidebarHovered">

            <div class="text-sm font-semibold text-slate-600">
                Guest
            </div>

            <div class="text-xs text-slate-500">
                Belum Login
            </div>

        </div>

    </div>

    @endauth

</div>