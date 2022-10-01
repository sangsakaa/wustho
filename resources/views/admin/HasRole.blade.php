<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen Has Role' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard Has Role User') }}
    </h2>
  </x-slot>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 mt-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1">
          <span class=" text-sky-500"> User Management Role</span>
          <div class=" flex grid-cols-1 gap-1">
            <a href="/admin" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">ListUsers</a>
            <a href="#" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Manajemen Role User</a>
            <a href="#" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Has Role</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 mt-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1">
          <span> User Role</span>
          <table class=" w-full">
            <thead>
              <tr class=" border">
                <th class=" border">No</th>
                <th class=" border">Permissions</th>
                <th class=" border">Role</th>
              </tr>
            </thead>
            <tbody>
              @foreach($hasRole as $user)
              <tr class=" border ">
                <th class=" border">{{$loop->iteration}}</th>
                <th class=" border">{{$user->permission_id}}</th>
                <th class=" border">{{$user->role_id}}</th>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>