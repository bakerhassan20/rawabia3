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
            'view dashboard' => 'عرض لوحة التحكم',

            // Clients
            'view clients' => 'عرض العملاء',
            'create clients' => 'إضافة عميل',
            'edit clients' => 'تعديل عميل',
            'delete clients' => 'حذف عميل',

            // Contracts
            'view contracts' => 'عرض العقود',
            'create contracts' => 'إضافة عقد',
            'edit contracts' => 'تعديل عقد',
            'delete contracts' => 'حذف عقد',

            // Payments
            'view payments' => 'عرض المدفوعات',
            'create payments' => 'إضافة دفعة',
            'edit payments' => 'تعديل دفعة',
            'delete payments' => 'حذف دفعة',

            // Users
            'view users' => 'عرض المستخدمين',
            'create users' => 'إضافة مستخدم',
            'edit users' => 'تعديل مستخدم',
            'delete users' => 'حذف مستخدم',

            // Roles
            'view roles' => 'عرض الصلاحيات',
            'create roles' => 'إضافة صلاحية',
            'edit roles' => 'تعديل صلاحية',
            'delete roles' => 'حذف صلاحية',

            // Settings
            'view settings' => 'عرض الإعدادات',
            'edit settings' => 'تعديل الإعدادات',
        ];

        foreach ($permissions as $name => $description) {

            Permission::updateOrCreate(
                [
                    'name' => $name,
                    'guard_name' => 'web'
                ],
                [
                    'description' => $description
                ]
            );
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