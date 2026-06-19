<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [

            // Dashboard
            'view dashboard',

            // Clients
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',

            // Contracts
            'view contracts',
            'create contracts',
            'edit contracts',
            'delete contracts',

            // Payments
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',

            // Users
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Roles
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Settings
            'view settings',
            'edit settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        $accountant = Role::firstOrCreate([
            'name' => 'Accountant',
            'guard_name' => 'web'
        ]);

        // Super Admin
        $superAdmin->syncPermissions(Permission::all());

        // Admin
        $admin->syncPermissions([
            'view dashboard',

            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            
            'view contracts',
            'create contracts',
            'edit contracts',
            'delete contracts',

            'view payments',
            'create payments',
            'edit payments',
            'delete payments',

            'view users',
            'create users',
            'edit users',

            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            

            'view settings',
            'edit settings',
        ]);

        // Accountant
        $accountant->syncPermissions([
            'view dashboard',

            'view clients',

            'view contracts',

            'view payments',
            'create payments',
            'edit payments',
        ]);
    }
}