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
        Schema::table('sprint_task', function (Blueprint $table) {
            // Check if the column exists before dropping
            if (Schema::hasColumn('sprint_task', 'project_id')) {
                // Drop the foreign key
                $table->dropForeign(['project_id']);

                // Drop the column
                $table->dropColumn('project_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sprint_task', function (Blueprint $table) {
            // Re-add the column if not exists
            if (!Schema::hasColumn('sprint_task', 'project_id')) {
                $table->unsignedBigInteger('project_id')->nullable();

                // Recreate the foreign key constraint
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            }
        });
    }
};
