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
            // Drop the foreign key constraint first
            $table->dropForeign(['project_id']);

            // Then drop the column
            $table->dropColumn('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sprint_task', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('project_id')->nullable();

            // Recreate the foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }
};
