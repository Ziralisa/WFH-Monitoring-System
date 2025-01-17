<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * This seeder is responsible for creating roles and permissions, and also assigning them to specific users.
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
        Permission::firstOrCreate(['name' => 'view project']);

        // Create roles and assign created permissions

        // User role, no permissions needed for this role
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Staff role
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffRole->givePermissionTo([
            'view profile',
            'view attendance report',
            'view take attendance',
            'view backlog',
            'view daily tasks',
            'view project'
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
            'view daily tasks',
            'view project'
        ]);

        // Assign roles to specific users
        //UNCOMMENT AND ADJUST TO YOUR NEEDS
        // $user = User::firstWhere('email', 'user@example.com'); // Replace with the actual user's email
        // if ($user) {
        //     $user->assignRole($userRole); // Assign 'user' role
        // }

        // $staff = User::firstWhere('email', 'staff@example.com'); // Replace with the actual staff email
        // if ($staff) {
        //     $staff->assignRole($staffRole); // Assign 'staff' role
        // }

        // $admin = User::firstWhere('email', 'admin@kodewave.my'); // Replace with the actual admin email
        // if ($admin) {
        //     $admin->assignRole($adminRole); // Assign 'admin' role
        // }
    }
}
