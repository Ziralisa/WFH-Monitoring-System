<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Check if the foreign key exists
            if (Schema::hasColumn('tasks', 'sprint_id')) {
                $table->dropForeign(['sprint_id']); // Drop the foreign key
                $table->dropColumn('sprint_id');    // Drop the column
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'sprint_id')) {
                $table->unsignedBigInteger('sprint_id')->nullable();

                // Re-add the foreign key
                $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            }
        });
    }
};
