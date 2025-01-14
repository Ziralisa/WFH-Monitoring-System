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
        // Drop the foreign key constraint first
        $table->dropForeign('tasks_sprint_id_foreign'); // Replace with the actual constraint name if different

        // Now drop the column
        $table->dropColumn('sprint_id');
    });
}

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->unsignedBigInteger('sprint_id')->nullable(); // Re-add the column if rolling back
    });
}


};
