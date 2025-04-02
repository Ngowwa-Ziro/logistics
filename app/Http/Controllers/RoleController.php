<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){
        $role = Role::get();

        return view('roles.index', [
            'roles' => $role
        ]);
    }

    public function create(){
        $permissions = Permission::all(); // Fetch all permissions

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions); // Attach permissions to role
        }

        return redirect()->route('roles.index')->with('success', 'Role Created Successfully');
    }


    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray(); // Current permissions for this role

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions); // Sync permissions for role
        } else {
            $role->syncPermissions([]); // If none selected, remove all permissions
        }

        return redirect()->route('roles.index')->with('success', 'Role Updated Successfully');
    }


    public function destroy($roleId){
        $role = Role::find($roleId);
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role Deleted Successfully');
    }


    public function addPermissionToRole($roleId){
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                                    ->where('role_has_permissions.role_id', $role->id)
                                    ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                    ->all();

        return view('roles.add-permissions',[
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId){
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('success','Permissions added to role');
    }
}
