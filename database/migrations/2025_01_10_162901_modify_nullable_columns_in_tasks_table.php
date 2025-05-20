<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Modify columns to allow null values
            $table->enum('task_status', ['To Do', 'In Progress', 'Done', 'Stuck'])->nullable()->change();
            $table->enum('task_priority', ['Low', 'Medium', 'High'])->nullable()->change();
            $table->string('task_assign')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Revert changes to make columns non-nullable
            $table->enum('task_status', ['To Do', 'In Progress', 'Done', 'Stuck'])->nullable(false)->change();
            $table->enum('task_priority', ['Low', 'Medium', 'High'])->nullable(false)->change();
            $table->string('task_assign')->nullable(false)->change();
        });
    }
};
