<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{
    /**
     * Halaman daftar registrasi siswa
     */
    public function index(Request $request)
    {
        $search = $request->search;

        // siswa belum punya akun
        $belumPunyaAkun = Siswa::doesntHave('user')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_siswa', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10, ['*'], 'belum_page')
            ->withQueryString();

        // user yang sudah punya akun siswa
        $sudahPunyaAkun = User::with('siswa')
            ->whereNotNull('siswa_id')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_siswa', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'sudah_page')
            ->withQueryString();

        return view('auth.index', compact(
            'belumPunyaAkun',
            'sudahPunyaAkun'
        ));
    }

    /**
     * Form buat akun siswa
     */
    public function create(Request $request)
    {
        $selectedSiswa = null;

        if ($request->filled('siswa_id')) {
            $selectedSiswa = Siswa::doesntHave('user')
                ->where('id', $request->siswa_id)
                ->first();
        }

        $siswa = Siswa::doesntHave('user')
            ->orderBy('nama_siswa')
            ->get();

        return view('auth.register', compact(
            'siswa',
            'selectedSiswa'
        ));
    }

    /**
     * Simpan akun baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'siswa_id' => 'required|exists:siswa,id',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'siswa_id.required' => 'Siswa wajib dipilih',
        ]);

        $cekUser = User::where('siswa_id', $validated['siswa_id'])->first();

        if ($cekUser) {
            return back()
                ->withErrors([
                    'siswa_id' => 'Siswa ini sudah memiliki akun.'
                ])
                ->withInput();
        }

        $randomPassword = Str::password(8);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($randomPassword),
            'siswa_id' => $validated['siswa_id'],
        ]);

        event(new Registered($user));

        return redirect()
            ->route('register.index')
            ->with([
                'success' => 'Akun berhasil dibuat',
                'generated_email' => $user->email,
                'generated_password' => $randomPassword,
            ]);
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('register.index')
            ->with('success', 'User berhasil dihapus');
    }
    public function quickCreate(Siswa $siswa)
    {
        if ($siswa->user) {
            return back()->withErrors([
                'error' => 'Siswa sudah memiliki akun.'
            ]);
        }

        $password = Str::random(8);

        // ambil nis dari relasi tabel nis
        $nis = optional($siswa->nis)->nis;

        if (!$nis) {
            return back()->withErrors([
                'error' => 'NIS tidak ditemukan untuk siswa ini.'
            ]);
        }

        $email = trim($nis) . '@smedi.my.id';

        if (User::where('email', $email)->exists()) {
            return back()->withErrors([
                'error' => 'Email sudah digunakan: ' . $email
            ]);
        }

        $user = User::create([
            'name' => $siswa->nama_siswa,
            'email' => $email,
            'password' => Hash::make($password),
            'siswa_id' => $siswa->id,
        ]);

        event(new Registered($user));

        return redirect()
            ->route('register.index')
            ->with([
                'success' => 'Akun berhasil dibuat',
                'generated_email' => $email,
                'generated_password' => $password,
                'active_tab' => 'sudah',
            ]);
    }
}
