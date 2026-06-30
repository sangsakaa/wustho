@php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

try {

if (
session('periode_id') &&
!$dataperiode->contains('id', session('periode_id'))
) {
session()->forget('periode_id');
}

$periodeAktif =
$dataperiode->firstWhere('id', session('periode_id'))
?? $dataperiode->firstWhere('is_active', true)
?? $dataperiode->first();

$dataperiodeNavbar = collect();

if ($periodeAktif && !empty($periodeAktif->periode)) {

$tahunAktif = (int) explode('/', $periodeAktif->periode)[0];

$dataperiodeNavbar = $dataperiode
->filter(function ($periode) use ($tahunAktif) {

if (empty($periode->periode)) {
return false;
}

$tahun = (int) explode('/', $periode->periode)[0];

return $tahun >= ($tahunAktif - 1)
&& $tahun <= ($tahunAktif + 1);

    })
    ->sort(function ($a, $b) {

    if ($a->periode == $b->periode) {
    return $a->semester_id <=> $b->semester_id;
        }

        return strcmp($a->periode, $b->periode);

        })
        ->values();
        }

        } catch (\Throwable $e) {

        $periodeAktif = null;
        $dataperiodeNavbar = collect();

        }
        @endphp

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <nav
            aria-label="secondary"
            x-data="{ open: false }"
            class="sticky top-0 z-30 flex items-center justify-between px-4 py-3 bg-white border-b border-green-100 shadow-sm dark:bg-dark-eval-1 dark:border-slate-700">

            <div class="flex items-center gap-3">

                <button
                    type="button"
                    class="p-2 rounded-lg md:hidden hover:bg-green-50"
                    @click="isSidebarOpen = !isSidebarOpen">

                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                </button>

                <div>

                    <h1 class="font-bold text-green-700">
                        SMEDI
                    </h1>

                    <p class="text-xs text-slate-500">
                        Sistem Manajemen Madrasah
                    </p>

                </div>

            </div>

            <div class="flex items-center gap-2">

                <button
                    type="button"
                    @click="toggleTheme"
                    class="p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-green-600 dark:text-slate-300 dark:hover:bg-slate-700 transition duration-200">

                    {{-- Moon --}}
                    <x-heroicon-o-moon
                        x-show="!isDarkMode"
                        class="w-5 h-5" />

                    {{-- Sun --}}
                    <x-heroicon-o-sun
                        x-show="isDarkMode"
                        class="w-5 h-5" />

                </button>

                @if($dataperiodeNavbar->isNotEmpty())

                <form
                    action="{{ route('periode.set-active') }}"
                    method="POST"
                    class="form-periode">

                    @csrf

                    <select
                        name="periode_id"
                        onchange="this.form.submit()"
                        class="px-4 py-2 text-sm rounded-xl border border-green-200 bg-white dark:bg-slate-800 dark:border-slate-700">

                        @foreach($dataperiodeNavbar as $periode)

                        <option
                            value="{{ $periode->id }}"
                            @selected($periodeAktif?->id == $periode->id)>

                            {{ $periode->periode }}
                            - {{ $periode->semester?->ket_semester }}

                        </option>

                        @endforeach

                    </select>

                </form>

                @endif
                @auth

                <x-dropdown align="right" width="60">

                    <x-slot name="trigger">

                        <button class="flex items-center gap-3 px-3 py-2 rounded-xl border border-green-100 hover:bg-green-50">

                            <div class="w-10 h-10 rounded-full bg-green-600 text-white flex items-center justify-center font-bold">

                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                            </div>

                            <div class="hidden md:block text-left">

                                <div class="font-semibold text-sm">

                                    {{ auth()->user()->name }}

                                </div>

                                <div class="text-xs text-slate-500">

                                    {{ auth()->user()->getRoleNames()->first() ?? 'User' }}

                                </div>

                            </div>

                        </button>

                    </x-slot>

                    <x-slot name="content">

                        <div class="px-4 py-3 border-b">

                            <div class="font-semibold">
                                {{ auth()->user()->name }}
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ auth()->user()->email }}
                            </div>

                        </div>

                        <x-dropdown-link :href="route('dashboard')">
                            🏠 Dashboard
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('user')">
                            👤 Profil Saya
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">

                                🚪 Logout

                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

                @else

                <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700">

                    Login

                </a>

                @if(Route::has('register'))

                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm border rounded-xl hover:bg-slate-50">

                    Register

                </a>

                @endif

                @endauth

            </div>

        </nav>

        <script>
            document.querySelectorAll('.form-periode').forEach(form => {

                form.addEventListener('submit', function(e) {

                    e.preventDefault();

                    Swal.fire({
                        title: 'Ganti Periode?',
                        text: 'Pastikan periode yang dipilih sudah benar.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Pilih',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {

                        if (result.isConfirmed) {
                            form.submit();
                        }

                    });

                });

            });
        </script>