<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Hasrole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::query()
            ->leftjoin('siswa', 'users.siswa_id', 'siswa.id')
            ->select('users.email', 'siswa.nama_siswa', 'users.name')
            ->get();
        $hasRole = Hasrole::all();
        return view(
            'admin/admin',
            [
                'users' => $users,
                'hasRole' => $hasRole
            ]
        );
    }
    public function HasRole()
    {

        $hasRole = Hasrole::query()
            // ->join('permissions', 'permission.id', '=', 'role_has_permissions.permission_id ')
            ->get();
        return view(
            'admin/HasRole',
            [

                'hasRole' => $hasRole
            ]
        );
    }
    public function create()
    {
        $siswa = Siswa::all();
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
    public function store(Request $request, Siswa $siswa)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $siswa = Siswa::find($siswa);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'siswa_id' => $request->siswa,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
