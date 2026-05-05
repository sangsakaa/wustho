<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;

class RoleManagementController extends Controller
{
    public function index()
    {
        return view('admin.has-role', [
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'roles' => Roles::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_name' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->syncRoles([$request->role_name]);

        return back()->with('success', 'Role berhasil diassign');
    }
}
