<x-app-layout>
  <x-slot name="header">
    @section('title', ' | Manajemen Has Role' )
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard Has Role User') }}
    </h2>
  </x-slot>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 mt-2">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-2 grid grid-cols-1">
          <span class=" text-sky-500"> User Management Role</span>
          <div class=" flex grid-cols-1  sm:grid-cols-2 gap-1">
            <a href="/manajemen-user" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">ListUsers</a>
            <a href="/manajemen" class=" bg-sky-400 py-1 px-4 rounded-md text-white hover:bg-purple-500">Manajemen Role User</a>
          </div>
          <div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 mt-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
          <div>
            <form action="/HasRole" method="post">
              @csrf
              <div class=" grid grid-cols-1  gap-2">
                <label for="">Name : </label>
                <input type="text" name="name" class=" py-1 sm:w-full" placeholder="contoh :  super admin">
                <small>@error('name')
                  <div id="notification" class=" text-red-700">{{ $message }}</div>
                  @enderror
                </small>
                <label for="">Guard Name : </label>
                <input type="text" name="guard_name" class=" py-1 w-full" placeholder="contoh :  super admin" value="web" readonly>
                <button class=" bg-blue-700 px-1 py-1 text-white w-fit">Create Role</button>
                <div class=" py-2">
                  notification : <span class=" text-red-700">
                    @if(Session::has('message'))
                    <div id="notification" class="alert {{ Session::get('alert-class', 'alert-info') }}">
                      {{ Session::get('message') }}
                    </div>
                    @endif
                    <script>
                      // Fungsi untuk menghilangkan notifikasi setelah 5 detik
                      setTimeout(function() {
                        var notification = document.getElementById('notification');
                        if (notification) {
                          notification.style.display = 'none';
                        }
                      }, 5000); // 5000 milidetik = 5 detik
                    </script>
                  </span>
                </div>
              </div>
            </form>
          </div>
          <div>
            <form action="/HasRole" method="post">
              @csrf
              <div class=" grid grid-cols-1 gap-2">
                <label for="">Role : </label>
                <select name="role_id" id="" class=" py-1 w-full">
                  <option value="">Pilih Role</option>
                  @foreach($roles as $list)
                  <option value="{{$list->id}}">{{$list->name}}</option>
                  @endforeach
                </select>
                <label for="">Role : </label>

                <select name="model_id" id="" class=" py-1 w-full capitalize">
                  <option value="">Pilih User</option>
                  @foreach($User as $list)
                  <option value="{{$list->id}}">{{$list->name}}</option>
                  @endforeach

                </select>
                <input type="hidden" name="model_type" value="App\Models\User">
                <small>@error('name')
                  <div id="notification" class=" text-red-700">{{ $message }}</div>
                  @enderror
                </small>
                <button class=" bg-blue-700 px-1 py-1 text-white w-fit">Create Role</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class=" grid grid-cols-1 sm:grid-cols-1 gap-2 px-2 mt-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class=" bg-white border-b border-gray-200">
        <div class=" p-4 grid grid-cols-1 sm:grid-cols-1 gap-2">
          <div>
            <div>
              <form action="/HasRole" method="get">
                <input type="text" name="cari" value="{{ request('cari') }}" class="border border-green-800 text-green-800 rounded-md py-1 px-4" placeholder="Cari ..">
                <button type="submit" class="bg-green-800 py-1 px-2 rounded-md text-white">
                  Cari
                </button>
              </form>
            </div>

            <table class=" w-full mt-2">
              <thead>
                <tr class=" border bg-gray-100">
                  <th class=" border py-1 ">No</th>

                  <th class=" border">Email</th>
                  <th class=" border">Role</th>
                  <th class=" border">Act</th>
                </tr>
              </thead>
              <tbody>
                @if(request('cari') !== null)
                @foreach($hasRole as $Hasrole)
                <tr class="border">
                  <td class="border px-1">{{ $Hasrole->name }}</td>

                  <td class="border px-1 text-center">{{ $Hasrole->email }}</td>
                  <td class="border px-1 text-center">{{ $Hasrole->role_name }}</td>
                  <td>
                    <form action="/has-role/{{$Hasrole->model_id}}" method="post">
                      @csrf
                      @method('delete')
                      <button>Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td class=" border text-red-700 font-semibold text-center text-sm" colspan="4">
                    data not found
                  </td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</x-app-layout>