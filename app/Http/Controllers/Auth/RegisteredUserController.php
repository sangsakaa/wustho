<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Hasrole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Spatie\Permission\Models\Permission;

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
            ->select(
                [
                    'users.id',
                    'users.email',
                    'siswa.nama_siswa',
                    'users.name',
                ]
            )
            ->get();
        $hasRole = Hasrole::all();
        $RoleHas = HasRole::query()
        ->join('permissions', 'permissions.id',  '=', 'role_has_permissions.permission_id',)
        ->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')
        ->select('roles.name AS Role', 'permissions.name AS Permission')
        ->get();
        return view(
            'admin/admin',
            [
                'users' => $users,
                'hasRole' => $hasRole,
                'HasRole' => $RoleHas,
                'permissions' => $permissions,
                'hasrole' => $hasrole
            ]
        );
    }
    public function manajemen()
    {
        $roles = Roles::all();
        $permissions = Permission::query()
            ->get();
        return view(
            'admin/manajemen',
            [
                'hasRole' => $permissions,
                'roles' => $roles
            ]
        );
    }
    public function HasRole()
    {

        $roles = Roles::all();
        $permissions = Permission::query()
            ->get();
        return view(
            'admin/HasRole',
            [
                'hasRole' => $permissions,
                'roles' => $roles
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
        dd($role_has_permission);
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

        if ($request->siswa_id) {
            $user->assignRole('siswa');
        } else {
            $user->assignRole('super admin');
        }

        event(new Registered($user));
        // Auth::login($user);
        if (Auth::login($user)) {
            return redirect(RouteServiceProvider::USER);
        } elseif (Auth::login($user == 'pengurus')) {
            return redirect(RouteServiceProvider::PONDOK);
        } else {
            return redirect(RouteServiceProvider::HOME);
        }


        
        // return redirect(RouteServiceProvider::HOME);
        

        
    }
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect('admin');
    }
}