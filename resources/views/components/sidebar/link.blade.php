@props(['isActive' => false, 'title' => '', 'collapsible' => false])

@php
$isActiveClasses = $isActive
? 'text-white bg-emerald-600 shadow-md hover:bg-emerald-700'
: 'text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 dark:text-slate-300 dark:hover:text-emerald-400 dark:hover:bg-slate-800';

$classes = 'flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 overflow-hidden '
. $isActiveClasses;

if ($collapsible) {
$classes .= ' w-full';
}
@endphp

@if ($collapsible)

<button
    type="button"
    {{ $attributes->merge(['class' => $classes]) }}>

    {{-- Icon --}}
    @if ($icon ?? false)
    {{ $icon }}
    @else
    <x-icons.empty-circle
        class="w-5 h-5 shrink-0"
        aria-hidden="true" />
    @endif

    {{-- Label --}}
    <span
        x-show="isSidebarOpen || isSidebarHovered"
        x-transition
        class="font-medium truncate">

        {{ $title }}

    </span>

    {{-- Arrow --}}
    <span
        x-show="isSidebarOpen || isSidebarHovered"
        aria-hidden="true"
        class="relative ml-auto w-5 h-5">

        <span
            :class="open ? '-rotate-45' : 'rotate-45'"
            class="absolute right-[8px] top-1/2 -mt-1 h-2 w-[2px] bg-emerald-500 transition-all duration-200">
        </span>

        <span
            :class="open ? 'rotate-45' : '-rotate-45'"
            class="absolute left-[8px] top-1/2 -mt-1 h-2 w-[2px] bg-emerald-500 transition-all duration-200">
        </span>

    </span>

</button>

@else

<a {{ $attributes->merge(['class' => $classes]) }}>

    {{-- Icon --}}
    @if ($icon ?? false)
    {{ $icon }}
    @else
    <x-icons.empty-circle
        class="w-5 h-5 shrink-0"
        aria-hidden="true" />
    @endif

    {{-- Label --}}
    <span
        x-show="isSidebarOpen || isSidebarHovered"
        x-transition
        class="font-medium truncate">

        {{ $title }}

    </span>

</a>

@endif