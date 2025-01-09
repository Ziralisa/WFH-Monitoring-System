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
        Permission::firstOrCreate(['name' => 'view attendance report']);
        Permission::firstOrCreate(['name' => 'view admin dashboard']);
        Permission::firstOrCreate(['name' => 'view take attendance']);
        Permission::firstOrCreate(['name' => 'view attendance report staff']);
        Permission::firstOrCreate(['name' => 'view daily tasks']);
        Permission::firstOrCreate(['name' => 'view backlog']);
        Permission::firstOrCreate(['name' => 'view attendance status']);
        
        


        // Create roles and assign created permissions

        // User role, no permissions needed for this role
        Role::firstOrCreate(['name' => 'user']);

        // Staff role
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view profile',
            'view attendance report',
            'view take attendance',
            'view backlog',
            'view daily tasks'
        ]);

        // Admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'view profile',
            'view admin dashboard',
            'view role settings',
            'view user settings',
            'view attendance report staff',
            'view take attendance',
            'view backlog',
            'view daily tasks'
        ]);
    }
}