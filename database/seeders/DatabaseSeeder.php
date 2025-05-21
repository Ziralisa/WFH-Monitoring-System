<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Run the RolesAndPermissionsSeeder
        $this->call(RolesAndPermissionsSeeder::class);

        // Create an admin user and assign the admin role
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@kodewave.my',
            'password' => Hash::make('secret'),
            'company_id' => 1,   
        ]);

         // Assign the admin role to the newly created admin user
         $adminRole = Role::where('name', 'admin')->first();
         if ($adminRole) {
             $admin->assignRole($adminRole);
         }
    }
}
