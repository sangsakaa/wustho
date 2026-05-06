<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    /**
     * Menampilkan halaman manajemen permission role
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->orderBy('name')
            ->get();

        $permissions = Permission::orderBy('name')->get();

        return view('admin.permissions.index', compact(
            'roles',
            'permissions'
        ));
    }

    /**
     * Update permission untuk role tertentu
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->syncPermissions($validated['permissions'] ?? []);

        return redirect()
            ->back()
            ->with('success', 'Permission role berhasil diupdate');
    }
}
