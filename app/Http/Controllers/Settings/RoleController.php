<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        // returns the Blade page (tabs for Roles/Permissions/Users)
        return view('backend.settings.index');
    }

    public function list(Request $r)
    {
        $q = Role::query()->with('permissions');
        if ($search = $r->get('search')) {
            $q->where('name', 'like', "%{$search}%");
        }
        $roles = $q->latest()->get()->map(function($role){
            return [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name')->values(),
            ];
        });
        return response()->json($roles);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => ['required','string','max:255','unique:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['string','exists:permissions,name'],
        ]);

        $role = Role::create(['name' => $data['name']]);
        if (!empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return response()->json(['message' => 'Role created', 'role' => $role], 201);
    }

    public function update(Request $r, Role $role)
    {
        $data = $r->validate([
            'name' => ['required','string','max:255','unique:roles,name,'.$role->id],
            'permissions' => ['array'],
            'permissions.*' => ['string','exists:permissions,name'],
        ]);

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions'] ?? []);
        return response()->json(['message'=>'Role updated']);
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return response()->json(['message'=>'Cannot delete Super Admin'], 422);
        }
        $role->delete();
        return response()->json(['message'=>'Role deleted']);
    }
}