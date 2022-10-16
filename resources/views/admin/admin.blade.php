<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen User' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard Manajemen User') }}
    </h2>
  </x-slot>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 my-2 ">
    <div class="bg-white overflow-hidden shadow-sm ">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1">
          <span class=" text-sky-500"> User Management Role</span>
          <div class=" flex grid-cols-1 gap-1">
            <a href="/admin" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">ListUsers</a>
            <a href="/manajemen" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Manajemen Role User</a>
            <a href="/HasRole" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Has Role</a>
            <a href="/buatakunsiswa" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Buat akun untuk siswa</a>
            @if ($pesan = Session::get('status'))
                <p>{{$pesan}}</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 my-2 ">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1">
          <span>
            User Role
          </span>
          <form action="/admin" method="post">
            @csrf
            <select name="permission_id" id="" class=" py-1">
              @foreach($permissions as $permission)
              <option value="{{$permission->id}}">{{$permission->name}}</option>
              @endforeach
            </select>
            <select name="role_id" id="" class=" py-1">
              @foreach($hasrole as $permission)
              <option value="{{$permission->id}}">{{$permission->name}}</option>
              @endforeach
            </select>

            <button class=" bg-sky-500 px-2 py-1 text-white"> create role</button>
          </form>
          <table class=" mt-2 w-full">
            <thead>
              <tr class=" border bg-gray-100 ">
                <th class=" border py-2">No</th>
                <th class=" border">Role User</th>
                <th class=" border"> Permission</th>
              </tr>
            </thead>
            <tbody>
              @foreach($HasRole as $user)
              <tr class=" border ">
                <th class=" border">{{$loop->iteration}}</th>
                <th class=" border">{{$user->Role}}</th>
                <th class=" border">{{$user->Permission}}</th>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class=" p-4 grid grid-cols-1">
          <span> User Role</span>
          <table class=" w-full">
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
                <th class=" border">{{$loop->iteration}}</th>
                <th class=" border">{{$user->name}}</th>
                <th class=" border">{{$user->email}}</th>
                <th class=" border">{{$user->nama_siswa}}</th>
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
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
