<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Hasrole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $permissions = Permissions::all();
        $hasrole = Roles::all();
        $users = User::query()
            ->leftjoin('siswa', 'users.siswa_id', '=', 'siswa.id')
            ->leftjoin('guru', 'users.guru_id', '=', 'guru.id')
            ->select(
                [
                    'users.id',
                    'users.email',
                    'siswa.nama_siswa',
                    'users.name',
                ]
        )->orderby('nama_siswa');
        
        
        if (request('cari')) {
            $users->where('name', 'like', '%' . request('cari') . '%');
            
            
        }
        return view(
            'admin/manajemen-user',
            [
                'users' => $users->paginate(10),
                'permissions' => $permissions,
                'hasrole' => $hasrole,
                
            ]
        );
    }
    public function manajemen()
    {

        $UserGuru = Guru::query()
            ->join('nig', 'nig.guru_id', '=', 'guru.id')
            ->join('users', 'users.guru_id', '=', 'guru.id')->get();
            
        return view(
            'admin/manajemen',
            [
                'UserGuru' => $UserGuru,
                
            ]
        );
    }
    public function HasRole()
    {

        $User = User::all();
        $roles = Roles::all();
        $permissions = Hasrole::query()
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->join('users', 'users.id', '=', 'model_has_roles.model_id')
            ->select('users.name', 'model_id', 'role_id', 'roles.name as role_name', 'email',);
        if (request('cari')) {
            $permissions->where('users.name', 'like', '%' . request('cari') . '%');
        }

        $data = $permissions->get();
        return view(
            'admin/HasRole',
            [
                'hasRole' => $data,
                'roles' => $roles,
                'User' => $User
            ]
        );
    }
    public function create()
    {
        $siswa = Siswa::query()
            ->leftJoin('users', 'users.siswa_id', '=', 'siswa.id')
            ->where('users.siswa_id', null)
            ->select('siswa.*')
            ->get();
        return view(
            'auth.register',
            [
                'siswa' => $siswa
            ]
        );
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function role_has_permission(Request $request)
    {

        $role_has_permission = new Hasrole();
        $role_has_permission->permission_id = $request->permission_id;
        $role_has_permission->role_id = $request->role_id;
        // dd($role_has_permission);
        $role_has_permission->save();
        return redirect()->back();
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'siswa_id' => $request->siswa_id,
            'password' => Hash::make($request->password),
        ]);

        // if ($request->siswa_id) {
        //     $user->assignRole('siswa');
        // } else {
        //     $user->assignRole('super admin');
        // }

        event(new Registered($user));
        Auth::login($user);
        if (Auth::login($user)) {
            return redirect(RouteServiceProvider::USER);
        } else {

            return redirect(RouteServiceProvider::HOME);
        }
    }
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('admin');
    }

    public function buatAkunSiswa()
    {
        $dataSiswa = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->leftJoin('users', 'users.siswa_id', '=', 'siswa.id')
            ->select('siswa.id', 'siswa.nama_siswa', 'nis.nis')
            ->where('users.siswa_id', null)
            ->get();
        // dd($siswa->toSql());

        $jumlahUser = 0;
        foreach ($dataSiswa as $siswa) {
            $user = User::create([
                'name' => $siswa->nama_siswa,
                'email' => $siswa->nis . '@smedi.my.id',
                'password' => Hash::make($siswa->nis),
                'siswa_id' => $siswa->id
            ]);
            $user->assignRole('siswa');
            $jumlahUser++;
        }

        return redirect()->back()->with('status', $jumlahUser . ' user untuk siswa telah dibuat');
    }
    public function buatAkunGuru()
    {
        $dataGuru = Guru::query()
            ->join('nig', 'nig.guru_id', '=', 'guru.id')
            ->leftJoin('users', 'users.guru_id', '=', 'guru.id')
            ->select('guru.id', 'guru.nama_guru', 'nig.nig')
            ->where('users.guru_id', null)
            ->get();
        // dd($siswa->toSql());

        $jumlahUserGuru = 0;
        foreach ($dataGuru as $guru) {
            $user = User::create([
                'name' => $guru->nama_guru,
                'email' => $guru->nig . '@smedi.my.id',
                'password' => Hash::make($guru->nig),
                'guru_id' => $guru->id

            ]);
            $user->assignRole('guru');
            $user->givePermissionTo('show post');
            $jumlahUserGuru++;
        }

        return redirect()->back()->with('status', $jumlahUserGuru . ' user untuk guru telah dibuat');
    }
    public function storeole(Request $request)
    {
        $request->validate(
            [
                'name' => 'required'
            ],
            [
                'name.required' => 'wajib ada isinya'
            ]
        );


        $dataRole = Roles::all();
        $existingRole = Roles::where('name', $request->name)->first();

        if ($existingRole) {
            // Role dengan nama yang sama sudah ada
            Session::flash('message', 'Role dengan nama tersebut sudah ada!');
            Session::flash('alert-class', 'alert-danger');

            // Redirect kembali ke halaman sebelumnya atau halaman tertentu
            return redirect()->back(); // atau return redirect()->route('nama_rute');
        } else {
            // Role dengan nama yang sama belum ada, maka simpan data baru
            $role = new Roles();
            $role->name = $request->name;
            $role->guard_name = $request->guard_name;
            $role->save();

            // Set notifikasi sukses jika diperlukan
            Session::flash('message', 'Role berhasil disimpan!');
            Session::flash('alert-class', 'alert-success');

            return redirect()->back(); // Ganti "nama_rute" dengan nama rute yang sesuai
        }
    }
    public function storeHasRole(Request $request)
    {
        $hasRole = new Hasrole();
        $hasRole->role_id = $request->role_id;
        $hasRole->model_type = $request->model_type;
        $hasRole->model_id = $request->model_id;
        $hasRole->save();
        // Show a success notification in the blade view
        Session::flash('success', 'Role and Model ID combination created successfully.');
        return redirect()->back();
    }
    
}
