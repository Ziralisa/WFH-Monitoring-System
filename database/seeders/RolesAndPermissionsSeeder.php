<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view profile']);
        Permission::create(['name' => 'clock in']);
        Permission::create(['name' => 'clock out']);
        Permission::create(['name' => 'view attendance report']);
        Permission::create(['name' => 'view admin dashboard']);
        Permission::create(['name' => 'view staff dashboard']);
        Permission::create(['name' => 'view staff list']);
        Permission::create(['name' => 'view user list']);
        Permission::create(['name' => 'view take attendance']);
        Permission::create(['name' => 'view approve users']);
        Permission::create(['name' => 'view attendance report staff']);
        // Create roles and assign created permissions

        // User role, no permissions needed for this role
        Role::create(['name' => 'user']);

        // Staff role
        $staffRole = Role::create(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view profile',
            'clock in',
            'clock out',
            'view attendance report',
            'view take attendance',
            'view staff dashboard',
        ]);

        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view profile',
            'clock in',
            'clock out',
            'view admin dashboard',
            'view staff list',
            'view approve users',
            'view role settings',
            'view attendance report staff',
        ]);
    }
}
