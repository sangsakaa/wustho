<x-app-layout>
    <x-slot name="header">
        @section('title', ' | Kelas Wustho' )
        <h2 class="font-semibold text-xl  leading-tight sm:text-left text-center">
            {{ __('Dashboard Kelas') }}
        </h2>
    </x-slot>
    <div class=" mt-2">
        <div class=" mx-auto ">
            <div class="bg-white dark:bg-dark-bg overflow-hidden shadow-sm">
                <div class="p-2 ">
                    <div class=" w-full ">
                        <div class=" overflow-auto">

                            @if (session('delete'))
                            <script>
                                Toastify({
                                    text: "data berhasil hapus",
                                    className: "delete",
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                                    }
                                }).showToast();
                            </script>
                            @endif
                            @if (session('success'))
                            <div class=" py-2">
                                <div class=" bg-green-500 px-2 py-1 text-white">
                                    {{ session('success') }}
                                </div>
                            </div>
                            @endif
                            @if (session('update'))
                            <script>
                                Toastify({
                                    text: "data berhasil diperbarui",
                                    className: "update",
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                                    }
                                }).showToast();
                            </script>
                            @endif

                            <div class=" overflow-auto">
                                <livewire:list-kelas />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>