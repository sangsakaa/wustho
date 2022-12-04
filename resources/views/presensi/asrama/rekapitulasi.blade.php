<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black" class="justify-center max-w-xs gap-2">
                <x-icons.usercircle class="w-6 h-6" aria-hidden="true" />
                <span>Star on Github</span>
            </x-button>
        </div>
    </x-slot>
    <div class="px-6 py-2 overflow-hidden bg-white shadow-md dark:bg-dark-eval-1">
        <table class=" w-full">
            <thead>
                <tr class=" border capitalize text-sm ">
                    <th class=" text-center">no</th>
                    <th class=" border px-1">nama Santri</th>
                    <th class=" border px-1">kegiatan</th>
                    <th class=" border px-1">keterangan</th>
                    <th class=" border px-1">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($DataPresensi as $user)
                <tr class=" border even:bg-gray-100">
                    <td class=" text-center border px-1 ">{{$loop->iteration}}</td>
                    <td class="px-1 capitalize text-sm">{{strtolower($user->nama_siswa)}}</td>
                    <td class="px-1 text-center border">{{$user->kegiatan}}</td>
                    <td class=" capitalize text-center border">
                        {{$user->keterangan}}
                    </td>
                    <td class=" capitalize text-center border">
                        {{$user->alasan}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-app-layout>