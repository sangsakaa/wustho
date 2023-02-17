<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen User' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard Manajemen User') }}
    </h2>
  </x-slot>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2  ">
    <div class="bg-white overflow-hidden shadow-sm ">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-2 grid grid-cols-1">
          <div class=" flex grid-cols-1 gap-1">
            <a href="/admin" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">ListUsers</a>
            <a href="/manajemen" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Manajemen User Guru</a>
            <a href="/HasRole" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Has Role</a>
            <a href="/buatakunsiswa" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Buat akun untuk siswa</a>
            <a href="/buatakunguru" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Buat akun untuk guru</a>
            @if ($pesan = Session::get('status'))
            <p class=" py-1">{{$pesan}}</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 my-2 ">
    <div class="bg-white overflow-hidden shadow-sm ">
      <div class=" bg-white border-b border-gray-200">

        <div class=" py-4 px-4 grid grid-cols-1">
          <span> User Role</span>
          <form action="/admin" method="get" class="  gap-1">
            <div class=" grid sm:grid-cols-2 grid-cols-1 gap-1 w-1/2 ">
              <input type="text" name="cari" value="{{ request('cari') }}" class=" border text-green-800 rounded-sm py-1  sm:w-full " placeholder=" Cari ...">
              <button type="submit" class=" px-2 py-1  w-1/4    bg-blue-500  rounded-sm text-white">
                Cari </button>
            </div>
          </form>
          <table class=" w-full mt-2 ">
            <thead>
              <tr class=" border bg-gray-100 ">
                <th class=" border py-2">No</th>
                <th class=" border">Username</th>
                <th class=" border">Email</th>
                <th class=" border">Nama Pengguna</th>
                <th class=" border">ACT</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr class=" border ">
                <th class=" px-2 tex-xs sm:text-sm border">{{$loop->iteration}}</th>
                <td class=" px-2 tex-xs sm:text-sm border uppercase">{{strtolower($user->name)}}</td>
                <td class=" px-2 tex-xs sm:text-sm border text-center">{{$user->email}}</td>
                <td class=" px-2 tex-xs sm:text-sm border capitalize">{{strtolower($user->nama_siswa)}}</td>
                <td class=" text-sm flex justify-center py-1  gap-1">
                  <form action="/admin/{{$user->id}}" method="post">
                    @csrf
                    @method('delete')
                    <button class=" bg-red-500 text-white p-1 rounded-md flex"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" onclick="return  confirm ('apakah anda yakin menghapus data ini : {{$user->nis}} {{$user->nama_siswa}}')" )>
                        <path stroke-linecap=" round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg></button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class=" mt-1">
            {{$users}}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>