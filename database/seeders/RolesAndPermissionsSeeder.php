<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'web';

        // === Define all permissions for this app ===
        $permissions = [
            'Can View Dashboard',
            'Can View Work/Product',
            'Can Access Work Category',
            'Can Access My Work',
            'Can View Admin Info',
            'Can Access About',
            'Can Access Contact',
            'Can View Order',
            'Can Access Order',
            'Can Access Contact Messages',
            'Can View Attribute',
            'Can Access Attribute',
            'Can Access Attribute Value',
            'Can Access Settings',
        ];

        // Create permissions if not exist
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => $guard]);
        }

        // === Create the Super Admin role ===
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => $guard]);

        // Assign ALL permissions to Super Admin
        $superAdmin->syncPermissions($permissions);

        // === (Optional) create a default super admin user ===
        $user = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name'     => 'Super',
                'last_name'      => 'Admin',
                'name'           => 'Super Admin',
                'country'        => 'Bangladesh',
                'role'           => 1,
                'password'       => Hash::make('admin@1234'), 
                'remember_token' => Str::random(10),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole('Super Admin');

        // Clear cache again
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
