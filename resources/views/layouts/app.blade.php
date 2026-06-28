<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="mainState"
    :class="{ 'dark': isDarkMode }"
    x-cloak>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name') }}

        @yield('title')
    </title>

    {{-- FAVICON --}}
    <link
        rel="shortcut icon"
        href="{{ asset('asset/images/logo.png') }}"
        type="image/x-icon">

    {{-- FONT --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- APP --}}
    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$dbOnline = true;
$user = null;
$dbError = null;

try {
DB::connection()->getPdo();
$user = Auth::user();
} catch (\Throwable $e) {
$dbOnline = false;
$dbError = $e->getMessage(); // 👈 ambil pesan asli error
}

@endphp

<body class="antialiased bg-slate-100 dark:bg-dark-bg overflow-hidden">

    @if ($dbOnline)

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <x-sidebar.sidebar />

        {{-- MAIN --}}
        <div
            class="flex flex-col flex-1 transition-all duration-200 ease-in-out"
            :class="{
                'lg:ml-64': isSidebarOpen,
                'lg:ml-16': !isSidebarOpen
            }">

            {{-- NAVBAR --}}
            <x-navbar />

            {{-- HEADER --}}
            <header
                class="bg-white dark:bg-dark-eval-1 border-b border-slate-200 dark:border-slate-700 px-4 py-3 shadow-sm">

                <div class="flex items-center justify-between">

                    {{-- LEFT --}}
                    <div>

                        <h1 class="text-lg font-semibold text-slate-800 dark:text-white">
                            {{ $header ?? 'Dashboard' }}
                        </h1>

                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Sistem Manajemen Madrasah Diniyah
                        </p>

                    </div>

                    {{-- RIGHT --}}
                    <div class="hidden md:flex items-center gap-4">

                        {{-- ONLINE --}}
                        <div class="flex items-center gap-2">

                            <span class="relative flex h-2 w-2">

                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>

                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>

                            </span>

                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Online
                            </span>

                        </div>

                        {{-- PERIODE --}}
                        @if($periodeAktif)

                        <div class="flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800">

                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                Periode:
                            </span>

                            <span class="text-xs font-semibold text-slate-700 dark:text-white">

                                {{ $periodeAktif->periode }}
                                -
                                {{ $periodeAktif->semester?->ket_semester }}

                            </span>

                        </div>

                        @endif

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
            <footer class="bg-white dark:bg-dark-eval-1 border-t border-slate-200 dark:border-slate-700 px-4 py-3">

                <div class="flex flex-col md:flex-row items-center justify-between gap-2">

                    {{-- Kiri --}}
                    <div class="text-xs text-slate-500 dark:text-slate-400 text-center md:text-left">
                        © {{ date('Y') }}
                        <span class="font-medium">SMEDI - Sistem Madrasah Diniyah</span>
                    </div>

                    {{-- Tengah --}}
                    <div class="text-xs text-slate-500 dark:text-slate-400 text-center">
                        @role('super admin')
                        <span class="inline-flex items-center gap-1">
                            Made with
                            <x-heroicon-s-heart class="w-4 h-4 text-red-500" />
                            by
                            <a href="https://wustho.smedi.my.id/"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                MADIN WUSTHA WAHIDIYAH
                            </a>
                        </span>
                        @endrole

                        @role('pengurus')
                        <span class="inline-flex items-center gap-1">
                            Made with
                            <x-heroicon-s-heart class="w-4 h-4 text-red-500" />
                            by
                            <a href="https://wustho.smedi.my.id/"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                PONDOK PESANTREN KEDUNGLO WAHIDIYAH
                            </a>
                        </span>
                        @endrole

                        @role('siswa')
                        <span class="inline-flex items-center gap-1">
                            Made with
                            <x-heroicon-s-heart class="w-4 h-4 text-red-500" />
                            by
                            <a href="https://wustho.smedi.my.id/"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                MADIN WUSTHA WAHIDIYAH
                            </a>
                        </span>
                        @endrole
                    </div>

                    {{-- Kanan --}}
                    <div class="text-xs text-slate-400 dark:text-slate-500 text-center md:text-right">
                        Powered by Laravel 12 • TailwindCSS •
                        <span class="font-semibold">
                            v{{ config('app.version', '1.0.0') }}
                        </span>
                    </div>

                </div>

            </footer>

        </div>

    </div>

    @else

    {{-- OFFLINE --}}
    {{-- OFFLINE --}}
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-slate-100 via-white to-emerald-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 px-4">

        <div class="w-full max-w-2xl">

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">

                {{-- HEADER --}}
                <div class="bg-gradient-to-r from-red-500 to-rose-600 p-6 text-white">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-white/20">
                            ⚠️
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold">
                                Database Connection Error
                            </h1>
                            <p class="text-sm text-red-100 mt-1">
                                Sistem gagal terhubung ke database
                            </p>
                        </div>

                    </div>

                </div>

                {{-- BODY --}}
                <div class="p-6">

                    <div class="mb-4">
                        <h2 class="font-semibold text-slate-800 dark:text-white">
                            Detail Error
                        </h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Silakan cek MySQL, .env, atau server database Anda
                        </p>
                    </div>

                    {{-- ERROR CONSOLE --}}
                    <div class="bg-slate-900 text-slate-100 rounded-2xl p-4 overflow-x-auto">

                        <div class="flex gap-2 mb-3">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        </div>

                        <pre class="text-xs text-red-300 whitespace-pre-wrap font-mono">
                        {{ $dbError ?? 'SQLSTATE[HY000] [2002] Connection refused' }}
                        </pre>

                    </div>

                    {{-- INFO BOX --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-5">

                        <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-700">
                            <div class="text-xs text-slate-500">Status</div>
                            <div class="font-semibold text-red-600">Offline</div>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-700">
                            <div class="text-xs text-slate-500">Environment</div>
                            <div class="font-semibold">{{ app()->environment() }}</div>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-700">
                            <div class="text-xs text-slate-500">Time</div>
                            <div class="font-semibold">{{ now()->format('d M Y H:i:s') }}</div>
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="flex gap-3 mt-6">

                        <button
                            onclick="window.location.reload()"
                            class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition">

                            Refresh
                        </button>

                        <a href="/"
                            class="px-5 py-3 rounded-xl border border-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition">

                            Kembali
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @endif

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>