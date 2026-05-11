<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="mainState"
    :class="{ 'dark': isDarkMode }"
    x-cloak>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SMEDI @yield('title')</title>

    <link rel="shortcut icon"
        href="{{ asset('asset/images/logo.png') }}"
        type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

$dbOnline = true;
$user = null;

try {
DB::connection()->getPdo();
$user = Auth::user();
} catch (\Exception $e) {
$dbOnline = false;
}
@endphp

<body class="font-sans antialiased bg-slate-100 dark:bg-dark-bg overflow-hidden">

    @if ($dbOnline)

    <div class="h-screen flex">

        {{-- SIDEBAR --}}
        <x-sidebar.sidebar />

        <div class="flex flex-col flex-1 transition-all duration-200 ease-in-out"
            :class="{
                    'lg:ml-64': isSidebarOpen,
                    'lg:ml-16': !isSidebarOpen
                }">

            {{-- NAVBAR --}}
            <x-navbar />

            {{-- HEADER --}}
            <header
                class="bg-white dark:bg-dark-bg border-b border-slate-200 dark:border-slate-700 shadow-sm px-4 py-3">

                <div class="flex items-center justify-between">

                    <div>
                        <h1 class="text-lg font-semibold text-slate-800 dark:text-white">
                            {{ $header ?? 'Dashboard' }}
                        </h1>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Sistem Manajemen Madrasah Diniyah
                        </p>
                    </div>

                    <div class="hidden md:flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            Online
                        </span>
                    </div>

                </div>
            </header>

            {{-- CONTENT --}}
            <main class="flex-1 overflow-y-auto bg-slate-100 dark:bg-dark-bg">
                <div class="min-h-full">
                    {{ $slot }}
                </div>
            </main>

            {{-- FOOTER --}}
            <footer
                class="bg-white dark:bg-dark-bg border-t border-slate-200 dark:border-slate-700 px-4 py-2">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-1">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        © {{ date('Y') }} SMEDI - Sistem Madrasah Diniyah
                    </p>

                    <p class="text-xs text-slate-400 dark:text-slate-500">
                        Powered by Laravel & TailwindCSS
                    </p>
                </div>
            </footer>
        </div>
    </div>

    @else

    {{-- DATABASE OFFLINE SCREEN --}}
    <div class="flex items-center justify-center min-h-screen bg-slate-100 px-4">
        <div class="max-w-md w-full bg-white shadow-xl rounded-2xl p-8 text-center">

            <div class="text-6xl mb-4">⚠️</div>

            <h1 class="text-2xl font-bold text-slate-800 mb-2">
                Database Offline
            </h1>

            <p class="text-slate-500 mb-6">
                Sistem tidak dapat terhubung ke database.<br>
                Silakan hubungi administrator atau coba lagi nanti.
            </p>

            <button onclick="window.location.reload()"
                class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Refresh Halaman
            </button>

        </div>
    </div>

    @endif

    @livewireScripts
</body>

</html>