<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if role exists before creating
        if (!Role::where('name', 'user')->exists()) {
            Role::create(['name' => 'user']);
        }

        if (!Role::where('name', 'staff')->exists()) {
            Role::create(['name' => 'staff']);
        }

        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        if (!Role::where('name', 'resign')->exists()) {
            Role::create(['name' => 'resign']);
        }
    }
}
