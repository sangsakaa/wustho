<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Tambah Asrama') }}
        </h2>
    </x-slot>
    <div class="p-4">
        <div class=" mx-auto ">
            <div class=" p-4 w-1/2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <span class=" capitalize">form tambah daftar asrama</span>
                <form action="/asrama" method="post">
                    @csrf
                    <div class=" grid grid-cols-1 gap-2">
                        <input type="text" name="nama_asrama" class=" form-input  py-1 " placeholder=" Asrama : Al Hikam" required>
                        <select name="type_asrama" id="" class="  py-1 form-multiselect" required>
                            <option value=""> -- Pilih Type Asrama --</option>
                            <option value="Putra"> Asrama Putra</option>
                            <option value="Putri"> Asrama Putri</option>
                        </select>
                        <div class="  flex grid-cols-2 gap-2 justify-end">
                            <button type="submit" class=" w-1/4 px-4 pt-2 pb-1 bg-blue-600 text-white font-medium text-xs leading-normal uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex align-center">
                                <x-icons.save></x-icons.save>
                                <span class="px-4">SIMPAN</span>
                            </button>
                            <a href="/asramasiswa" type="button" class=" w-1/4 px-2 pt-2 pb-1 bg-blue-600 text-white font-medium text-xs leading-normal uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out flex align-center">
                                <x-icons.add></x-icons.add>
                                <span class=" px-1">ASRAMA SISWA</span>
                            </a>
                        </div>
                    </div>

                </form>



            </div>
        </div>
    </div>

</x-app-layout>