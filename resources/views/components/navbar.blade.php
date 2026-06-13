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

} catch (\Throwable $e) {

$periodeAktif = null;
}
@endphp

{{-- SWEET ALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<nav
    class="sticky top-0 z-10 flex items-center justify-between px-4 py-2 bg-white border-b dark:bg-dark-eval-1 dark:border-slate-700">

    {{-- LEFT --}}
    <div class="flex items-center gap-2">

        <x-button
            type="button"
            class="md:hidden"
            iconOnly
            variant="secondary"
            srText="Toggle dark mode"
            @click="toggleTheme">

            <x-heroicon-o-moon
                x-show="!isDarkMode"
                class="w-5 h-5" />

            <x-heroicon-o-sun
                x-show="isDarkMode"
                class="w-5 h-5" />
        </x-button>

    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-2">

        {{-- PERIODE --}}
        @if($periodeAktif)

        <x-dropdown align="right" width="64">

            {{-- TRIGGER --}}
            <x-slot name="trigger">

                <button
                    class="flex items-center gap-2 px-3 py-2 text-sm border rounded-lg dark:border-slate-700">

                    <div class="font-medium whitespace-nowrap">
                        {{ $periodeAktif->periode }}
                        -
                        {{ $periodeAktif->semester->ket_semester ?? '-' }}
                    </div>

                    <x-heroicon-o-chevron-down class="w-4 h-4" />

                </button>

            </x-slot>

            {{-- CONTENT --}}
            <x-slot name="content">

                @foreach ($dataperiode as $list)

                <form
                    method="POST"
                    action="{{ route('setperiode') }}"
                    class="form-periode">

                    @csrf

                    <input
                        type="hidden"
                        name="periode_id"
                        value="{{ $list->id }}">

                    <button
                        type="submit"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-700">

                        <div class="flex items-center gap-2">

                            <span>
                                {{ $list->periode }}
                                -
                                {{ $list->semester->ket_semester ?? '-' }}
                            </span>

                        </div>

                        @php
                        $isDipilih = session('periode_id') == $list->id;
                        $isAktif = $list->is_active;
                        @endphp

                        @if($isAktif)

                        <span class="text-[10px] text-green-500 font-medium">
                            Aktif Sistem
                        </span>

                        @elseif($isDipilih)

                        <span class="text-[10px] text-blue-500 font-medium">
                            Dipilih Sementara
                        </span>

                        @endif

                    </button>

                </form>

                @endforeach

            </x-slot>

        </x-dropdown>

        @endif

        {{-- DARK MODE --}}
        <x-button
            type="button"
            class="hidden md:inline-flex"
            iconOnly
            variant="secondary"
            srText="Toggle dark mode"
            @click="toggleTheme">

            <x-heroicon-o-moon
                x-show="!isDarkMode"
                class="w-5 h-5" />

            <x-heroicon-o-sun
                x-show="isDarkMode"
                class="w-5 h-5" />
        </x-button>

        {{-- USER --}}
        @if($user)

        <x-dropdown align="right" width="48">

            <x-slot name="trigger">

                <button
                    class="flex items-center gap-2 px-3 py-2 text-sm border rounded-lg dark:border-slate-700">

                    {{ $user->name }}

                    <x-heroicon-o-chevron-down class="w-4 h-4" />

                </button>

            </x-slot>

            <x-slot name="content">

                <form
                    method="POST"
                    action="{{ route('logout') }}">

                    @csrf

                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">

                        Log Out

                    </x-dropdown-link>

                </form>

            </x-slot>

        </x-dropdown>

        @endif

    </div>

</nav>

{{-- SWEET ALERT CONFIRM --}}
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
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded-lg mx-1',
                    cancelButton: 'bg-gray-200 text-gray-700 px-4 py-2 rounded-lg mx-1',
                },
                buttonsStyling: false
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });
</script>