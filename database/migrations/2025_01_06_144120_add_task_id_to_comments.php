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
        Schema::table('comments', function (Blueprint $table) {
            // Ensure the column exists and is unsignedBigInteger
            if (!Schema::hasColumn('comments', 'task_id')) {
                $table->unsignedBigInteger('task_id')->nullable();
            }

            // Add foreign key constraint only if the table exists
            if (Schema::hasTable('tasks')) {
                $table->foreign('task_id')
                      ->references('id')
                      ->on('tasks')
                      ->cascadeOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'task_id')) {
                $table->dropForeign(['task_id']);
                $table->dropColumn('task_id');
            }
        });
    }
};
