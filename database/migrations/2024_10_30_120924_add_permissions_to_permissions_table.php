<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class AddPermissionsToPermissionsTable extends Migration
{
    public function up()
    {
        $permissions = [
            'view staff dashboard',
            'view admin dashboard',
            'view take attendance',
            'view attendance report',
            'view approve users',
            'view user settings',
            'view role settings',
            'view attendance report staff',
            'view staff list',
            // Add more permissions as needed
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

    public function down()
    {
        // Optional: define how to remove these permissions if you rollback
        Permission::whereIn('name', [
            'view staff dashboard',
            'view admin dashboard',
            'view take attendance',
            'view attendance report',
            'view approve users',
            'view user settings',
            'view role settings',
            'view attendance report staff',
            'view staff list',
        ])->delete();
    }
}
