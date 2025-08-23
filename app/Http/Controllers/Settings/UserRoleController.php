<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function list(Request $r)
    {
        $q = User::query()->with('roles');
        if ($search = $r->get('search')) {
            $q->where(function($qq) use ($search){
                $qq->where('name','like',"%{$search}%")
                   ->orWhere('email','like',"%{$search}%");
            });
        }
        $users = $q->latest()->paginate(15);
        $payload = [
            'data' => $users->getCollection()->map(function($u){
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'roles' => $u->roles->pluck('name')->values(),
                ];
            }),
            'links' => [
                'next' => $users->nextPageUrl(),
                'prev' => $users->previousPageUrl(),
            ],
        ];
        return response()->json($payload);
    }

    public function syncRoles(Request $r, User $user)
    {
        $data = $r->validate([
            'roles' => ['array'],
            'roles.*' => ['string','exists:roles,name'],
        ]);

        $user->syncRoles($data['roles'] ?? []);
        return response()->json(['message' => 'Roles updated']);
    }
}
