<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="mainState"
    :class="{ 'dark': isDarkMode }"
    x-cloak>

<head>
    {{-- META --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- WA / SOCIAL PREVIEW --}}
    <meta name="description" content="Sistem Madrasah Diniyah (SMEDI) - Manajemen Akademik dan Administrasi Madrasah">
    <meta name="keywords" content="SMEDI, Madrasah, Akademik, Raport, Absensi, Laravel">
    <meta name="author" content="SMEDI">

    {{-- OPEN GRAPH --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="SMEDI - Sistem Madrasah Diniyah">
    <meta property="og:description" content="Sistem informasi manajemen akademik Madrasah Diniyah">
    <meta property="og:image" content="{{ asset('asset/images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="SMEDI">

    {{-- TWITTER --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SMEDI - Sistem Madrasah Diniyah">
    <meta name="twitter:description" content="Sistem informasi manajemen akademik Madrasah Diniyah">
    <meta name="twitter:image" content="{{ asset('asset/images/logo.png') }}">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- TITLE --}}
    <title>SMEDI @yield('title')</title>

    {{-- FAVICON --}}
    <link rel="shortcut icon"
        href="{{ asset('asset/images/logo.png') }}"
        type="image/x-icon">

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    {{-- TOASTIFY --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- ALPINE CLOAK --}}
    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .dark ::-webkit-scrollbar-track {
            background: #111827;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
    </style>

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- LIVEWIRE --}}
    @livewireStyles
</head>

<body class="font-sans antialiased bg-slate-100 dark:bg-dark-bg overflow-hidden">

    <div class="h-screen flex">

        {{-- SIDEBAR --}}
        <x-sidebar.sidebar />

        {{-- MAIN WRAPPER --}}
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
                            {{ $header }}
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

    {{-- TOASTIFY --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- LIVEWIRE --}}
    @livewireScripts

</body>

</html>