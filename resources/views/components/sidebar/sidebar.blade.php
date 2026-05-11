@php
use Illuminate\Support\Facades\DB;

$dbOnline = true;

try {
DB::connection()->getPdo();
} catch (\Exception $e) {
$dbOnline = false;
}
@endphp

<x-sidebar.overlay />

<aside
    class="fixed inset-y-0 z-20 flex flex-col py-4 space-y-6 bg-white shadow-lg dark:bg-dark-eval-1"
    :class="{
        'translate-x-0 w-64': isSidebarOpen || isSidebarHovered,
        '-translate-x-full w-64 md:w-16 md:translate-x-0': !isSidebarOpen && !isSidebarHovered,
    }"
    style="transition-property: width, transform; transition-duration: 150ms;"
    @mouseenter="handleSidebarHover(true)"
    @mouseleave="handleSidebarHover(false)">

    @if($dbOnline)
    <x-sidebar.header />
    <x-sidebar.content />
    <x-sidebar.footer />
    @else
    <div class="flex flex-col items-center justify-center h-full px-4 text-center">
        <div class="text-5xl mb-3">⚠️</div>

        <h2 class="text-sm font-bold text-red-500">
            Database Offline
        </h2>

        <p class="mt-2 text-xs text-slate-500">
            Sidebar tidak tersedia karena koneksi database gagal.
        </p>
    </div>
    @endif

</aside>