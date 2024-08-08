<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
{
    $roles = Role::all();
    $permissions = Permission::all();
    $rolePermissions = [];
    foreach ($roles as $role) {
        $rolePermissions[$role->id] = $role->permissions->pluck('id')->toArray();
    }
    return view('admin.role-permission.role.index', compact('roles', 'permissions', 'rolePermissions'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
        Role::create([
            'name' => $request->name
        ]);
        return redirect()->route('roles.index')->with('success', 'Role created successfully');


    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $role->id,
        ]);

        // Permission'ni yangilaymiz
        $role->update([
            'name' => $request->name
        ]);

        // Muvaffaqiyatli xabar bilan permissions.index yo'nalishiga qaytamiz
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role delete successfully');
    }


    public  function givePermissionsToRole(Request $request, $id)
    {

        $request->validate([
            'permission' => 'required'
        ]);

        $role=Role::findOrFail($id);
        $role->syncPermissions($request->permission);
        return redirect()->route('roles.index')->with('success', 'Permissions added successfully');
    }
}
