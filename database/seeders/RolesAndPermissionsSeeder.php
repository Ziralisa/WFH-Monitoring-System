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
       Permission::create(['name' => 'view attendance record']);
       Permission::create(['name' => 'view dashboard']);
       Permission::create(['name' => 'view staff list']);
       Permission::create(['name' => 'view user list']);

       // Create roles and assign created permissions

       // User role, no permissions needed for this role
       Role::create(['name' => 'user']);

       // Staff role
       $staffRole = Role::create(['name' => 'staff']);
       $staffRole->givePermissionTo(['view profile', 'clock in', 'clock out', 'view attendance record']);

       // Admin role
       $adminRole = Role::create(['name' => 'admin']);
       $adminRole->givePermissionTo([
           'view profile', 'clock in', 'clock out', 'view attendance record', 'view dashboard', 'view staff list',
           'view user list'
       ]);
    }
}
