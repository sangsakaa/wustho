<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen User' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard Manajemen User') }}
    </h2>
  </x-slot>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 py-2">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1">
          <span> User Role</span>
          <table class=" w-full">
            <thead>
              <tr class=" border">
                <th class=" border">No</th>
                <th class=" border">Username</th>
                <th class=" border">Email</th>
                <th class=" border">Nama Pengguna</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr class=" border ">
                <th class=" border">{{$loop->iteration}}</th>
                <th class=" border">{{$user->name}}</th>
                <th class=" border">{{$user->email}}</th>
                <th class=" border">{{$user->nama_siswa}}</th>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>