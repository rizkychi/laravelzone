<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Services\MenuTreeService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('name')->get();
        return view('roles.index', compact('roles'));
    }

    public function edit(Role $role)
    {
        $resources = Resource::orderBy('name')->get();
        $rolePerms = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role','resources','rolePerms'));
    }

    public function update(Request $request, Role $role)
    {
        $perms = $request->input('permissions', []); // array of permission_name
        $role->syncPermissions($perms);

        MenuTreeService::bustAll();
        return redirect()->route('roles.index')->with('success','Hak akses diperbarui.');
    }
}
