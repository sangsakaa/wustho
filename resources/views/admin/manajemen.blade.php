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
            <a href="/manajemen-user" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">ListUsers</a>
            <a href="/HasRole" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Has Role</a>
            <button class=" text-white rounded-md  bg-green-800 px-2 py-1 " onclick="printContent('div1')">Cetak Akun Guru</button>
          </div>
          <script>
            function printContent(el) {
              var fullbody = document.body.innerHTML;
              var printContent = document.getElementById(el).innerHTML;
              document.body.innerHTML = printContent;
              window.print();
              document.body.innerHTML = fullbody;
            }
          </script>
          <style>
            .page-break {
              page-break-after: always;
            }
          </style>
        </div>
      </div>
    </div>
  </div>
  <div id="div1" class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 mt-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1">
          <span class=" font-semibold">Data User Akun Guru</span>
          <table class=" w-full">
            <thead>
              <tr class=" border bg-gray-100">
                <th class=" border uppercase py-1 ">No</th>
                <th class=" border uppercase">Name Akun</th>
                <th class=" border uppercase">username / email</th>
                <th class=" border uppercase">password</th>
              </tr>
            </thead>
            <tbody>
              @foreach($UserGuru as $user)
              <tr class=" border ">
                <td class=" border text-center">{{$loop->iteration}}</td>
                <td class=" border text-left">{{$user->name}}</td>
                <td class=" border text-center">{{$user->email}}</td>
                <td class=" border text-center">{{$user->nig}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="page-break"></div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>