<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Data Siswa' )
        <h2 class="font-semibold text-xl leading-tight">
            @role('super admin')
            {{ __('  Data Siswa') }}
            @endrole
            @role('pengurus')
            {{ __('  Data Santri') }}
            @endrole
        </h2>
    </x-slot>

    <div class="dark:bg-dark-bg dark:text-purple-600 px-2   ">
        <div class="  shadow-sm sm:rounded-md">

            <div class=" p-2  bg-white dark:bg-black ">
                <livewire:siswa-table></livewire:siswa-table>
                <div class=" bg-sky-400 rounded-md text-white px-1 grid grid-cols-1 mt-1">
                    <span class="px-4 mt-4 text-bold">Keterangan :</span>
                    <div class=" px-6 mb-4">
                        <p>1. Siswa yang berstatus <b>Aktif</b> adalah siswa masih dalam pondok dan mengikuti pembelajaran</p>
                        <p>2. Siswa yang berstatus <b>Lulus</b> adalah siswa sudah dinytakan Selesai dalam mengikuti pembelajaran</p>
                        <p>3. Siswa yang berstatus <b>Boyong</b> adalah siswa yang sudah tidak didalam pondok dan tidak mengikuti pembelajaran</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>