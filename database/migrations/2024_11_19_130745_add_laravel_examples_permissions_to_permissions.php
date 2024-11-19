<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Define the permission
        $permissionName = 'view laravel examples';

        // Create the permission
        Permission::create(['name' => $permissionName]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete the permission
        Permission::where('name', 'view laravel examples')->delete();
    }
};
