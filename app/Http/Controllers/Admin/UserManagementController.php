<?php

// ===== UserManagementController =====
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permissions;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->with([
                'siswa:id,nama_siswa',
                'guru:id,nama_guru',
                'roles:id,name',
            ])
            ->when($request->filled('cari'), function ($query) use ($request) {
                $search = $request->cari;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('siswa', function ($siswa) use ($search) {
                            $siswa->where('nama_siswa', 'like', "%{$search}%");
                        })
                        ->orWhereHas('guru', function ($guru) use ($search) {
                            $guru->where('nama_guru', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.manajemen-user', [
            'users' => $users,
            'permissions' => Permissions::all(),
            'roles' => Roles::all(),
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
