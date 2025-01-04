<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id');    // Remove the user_id column
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Re-add the column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Re-add the foreign key
        });
    }
};

