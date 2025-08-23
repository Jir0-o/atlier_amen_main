<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function list(Request $r)
    {
        $q = Permission::query();
        if ($search = $r->get('search')) {
            $q->where('name','like',"%{$search}%");
        }
        return response()->json($q->orderBy('name')->get());
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => ['required','string','max:255','unique:permissions,name'],
        ]);
        $p = Permission::create(['name'=>$data['name']]);
        return response()->json(['message'=>'Permission created', 'permission'=>$p], 201);
    }

    public function update(Request $r, Permission $permission)
    {
        $data = $r->validate([
            'name' => ['required','string','max:255','unique:permissions,name,'.$permission->id],
        ]);
        $permission->update(['name'=>$data['name']]);
        return response()->json(['message'=>'Permission updated']);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message'=>'Permission deleted']);
    }
}

