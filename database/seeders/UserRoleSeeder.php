<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        $user->assignRole('user');

        $staff = User::find(2);
        $staff->assignRole('staff');
        $staff->removeRole('user');

        $admin = User::find(3);
        $admin->assignRole('admin');
        $admin->removeRole('user');

    }
}
