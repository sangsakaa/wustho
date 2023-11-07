<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:bg-dark-bg dark:text-purple-600 text-gray-800 leading-tight">
            Peserta Asrama : {{$tittle->nama_asrama}}
        </h2>
    </x-slot>

    <div class="px-4 py-2">
        <div class="  shadow-sm sm:rounded-lg">
            <div class="p-2 dark:bg-dark-bg bg-white  dark:text-purple-600 ">
                <div class=" sm:grid-cols-4 grid grid-cols-2">
                    <div>Nama Asrama</div>
                    <div class=" uppercase  font-semibold"> : {{$tittle->nama_asrama}} </div>
                    <div>Kuota Asrama</div>
                    <div> : {{$tittle->kuota}} org </div>


                </div>
            </div>
        </div>
    </div>
    <div class="py-1 px-4">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2  ">
                    <livewire:list-peserta-asrama :asramasiswa="$asramasiswa->id" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>