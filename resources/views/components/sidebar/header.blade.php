<div class="flex items-center justify-between flex-shrink-0 px-3">
    <!-- Logo -->
    @role('super admin')
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
        <x-application-logo aria-hidden="true" class="w-10 h-auto" />
        <span class="sr-only text-black">S M E D I</span>
    </a>
    @endrole
    @role('pengurus')
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
        <x-application-logo aria-hidden="true" class="w-10 h-auto" />
        <span class="sr-only text-black">S M E D I</span>
    </a>
    @endrole
    @role('siswa')
    <a href="{{ route('userdashboard') }}" class="inline-flex items-center gap-2">
        <x-application-logo aria-hidden="true" class="w-10 h-auto" />
        <span class="sr-only text-black">S M E D I</span>
    </a>
    @endrole
    @role('guru')
    <a href="{{ route('gurudashboard') }}" class="inline-flex items-center gap-2">
        <x-application-logo aria-hidden="true" class="w-10 h-auto" />
        <span class="sr-only text-black">S M E D I</span>
    </a>
    @endrole
    <!-- Toggle button -->
    <x-button type="button" iconOnly srText="Toggle sidebar" variant="secondary" x-show="isSidebarOpen || isSidebarHovered" @click="isSidebarOpen = !isSidebarOpen">
        <x-icons.menu-fold-right x-show="!isSidebarOpen" aria-hidden="true" class="hidden w-6 h-6 lg:block" />
        <x-icons.menu-fold-left x-show="isSidebarOpen" aria-hidden="true" class="hidden w-6 h-6 lg:block" />
        <x-heroicon-o-x aria-hidden="true" class="w-6 h-6 lg:hidden" />
    </x-button>
</div>