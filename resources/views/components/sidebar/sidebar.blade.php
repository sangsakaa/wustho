@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$dbOnline = false;

try {
DB::connection()->getDatabaseName();

if (Schema::hasTable('users')) {
$dbOnline = true;
}
} catch (\Throwable $e) {
$dbOnline = false;
}
@endphp

<x-sidebar.overlay />

<aside
    class="fixed inset-y-0 left-0 z-40 flex flex-col bg-white border-r border-slate-200 shadow-lg dark:bg-dark-eval-1 dark:border-slate-700"
    :class="{
        'translate-x-0 w-64': isSidebarOpen || isSidebarHovered,
        '-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen && !isSidebarHovered
    }"
    @mouseenter="handleSidebarHover(true)"
    @mouseleave="handleSidebarHover(false)">

    @if($dbOnline)

    <x-sidebar.header />

    <div class="flex-1 overflow-hidden">
        <x-sidebar.content />
    </div>

    <x-sidebar.footer />

    @endif

</aside>