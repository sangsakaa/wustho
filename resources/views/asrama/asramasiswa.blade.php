<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Asrama Siswa' )
        <h2 class="font-semibold text-xl  leading-tight">
            @role('pengurus')
            {{ __('Asrama Santri') }}
            @endrole
            @role('super admin')
            {{ __('Asrama Siswa') }}
            @endrole
        </h2>
    </x-slot>
    <div class=" p-2">
        <livewire:list-asrama />
    </div>
</x-app-layout>