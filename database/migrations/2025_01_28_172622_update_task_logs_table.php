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
        Schema::table('task_logs', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            //$table->foreignId('task_id')->nullable()->constrained()->cascadeOnDelete()->after('title');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->after('task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_logs', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropForeign(['task_id']);
            $table->dropColumn('task_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
}
};