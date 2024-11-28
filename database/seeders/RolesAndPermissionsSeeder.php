<?php

namespace Database\Seeders;

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

        // Create permissions, using firstOrCreate to avoid duplicates
        Permission::firstOrCreate(['name' => 'view profile']);
        Permission::firstOrCreate(['name' => 'clock in']);
        Permission::firstOrCreate(['name' => 'clock out']);
        Permission::firstOrCreate(['name' => 'view attendance report']);
        Permission::firstOrCreate(['name' => 'view admin dashboard']);
        Permission::firstOrCreate(['name' => 'view staff dashboard']);
        Permission::firstOrCreate(['name' => 'view staff list']);
        Permission::firstOrCreate(['name' => 'view user list']);
        Permission::firstOrCreate(['name' => 'view take attendance']);
        Permission::firstOrCreate(['name' => 'view approve users']);
        Permission::firstOrCreate(['name' => 'view attendance report staff']);

        // Create roles and assign created permissions

        // User role, no permissions needed for this role
        Role::firstOrCreate(['name' => 'user']);

        // Staff role
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view profile',
            'clock in',
            'clock out',
            'view attendance report',
            'view take attendance',
            'view staff dashboard',
        ]);

        // Admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view profile',
            'clock in',
            'clock out',
            'view admin dashboard',
            'view staff list',
            'view approve users',
            'view role settings',
            'view user settings',
            'view attendance report staff',
        ]);
    }
}