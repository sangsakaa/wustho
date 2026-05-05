<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('admin.permissions.index', compact(
            'roles',
            'permissions'
        ));
    }

    public function update(Request $request, Role $role)
    {
     
    $request->validate([
            'permissions' => 'nullable|array'
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return back()->with('success', 'Permission role berhasil diupdate');
    }
}
