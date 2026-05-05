<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Halaman daftar siswa / user sementara
     */
    public function index(Request $request)
    {
        $siswa = Siswa::when($request->filled('search'), function ($query) use ($request) {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%');
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('auth.index', compact('siswa'));
    }

    /**
     * Form register
     */
    public function create()
    {
        $siswa = Siswa::doesntHave('user')->get();

        return view('auth.register', compact('siswa'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'siswa_id' => ['nullable', 'exists:siswa,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'siswa_id' => $validated['siswa_id'] ?? null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Registrasi berhasil');
    }

    /**
     * Hapus user (opsional)
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
