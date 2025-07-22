<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('role.manage')) {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function edit(Role $role)
    {
        if (\Auth::user()->can('role.update')) {
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0]; // group by module
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function update(Request $request, Role $role)
    {
        if (\Auth::user()->can('role.update')) {
            $user = \Auth::user();
            try {
                $role->syncPermissions($request->permissions ?? []);
                $log_description = "Updated Role ID - ". $role->id;
                create_log('Update Role', $log_description, $user->id);
                return redirect()->route('roles.index')->with('success', 'Permissions updated!');
            } catch (\Exception $e) {
                return redirect()->route('roles.index')->with('error', 'Failed to updated Permissions!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }
    public function create()
    {
        if (\Auth::user()->can('role.create')) {
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });
        return view('roles.create', compact('permissions'));
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('role.create')) {
            $user = \Auth::user();
            try {
                $request->validate([
                    'name' => 'required|string|unique:roles,name',
                    'permissions' => 'nullable|array',
                ]);

                $role = Role::create(['name' => $request->name]);

                if ($request->has('permissions')) {
                    $role->syncPermissions($request->permissions);
                }
                $log_description = "Created Role ID- ". $role->id;
                create_log('Create Role', $log_description, $user->id);
                return redirect()->route('roles.index')->with('success', 'Role created successfully!');
            } catch (\Exception $e) {
                return redirect()->route('roles.index')->with('error', 'Failed to created Role!');
            }

        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }

    public function destroy(Role $role)
    {
        if (\Auth::user()->can('role.delete')) {
            $user = \Auth::user();
            try {
                $role->delete();
                $log_description = "Deleted Role ID- ". $role->id;
                create_log('Delete Role', $log_description, $user->id);
                return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
            } catch (\Exception $e) {
                return redirect()->route('roles.index')->with('error', 'Failed to delete Role!');
            }
        }else{
            return redirect()->back()->with('error', 'User don\'t have permission to access this page');
        }
    }
}

