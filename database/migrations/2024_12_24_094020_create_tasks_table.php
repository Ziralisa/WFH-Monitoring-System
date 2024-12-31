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
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('sprint_id'); 
            $table->unsignedBigInteger('user_id'); 
            
            $table->string('name', 250); 
            $table->string('task_status', 50); 
            $table->string('task_priority', 50);
            $table->string('task_assign', 50);
            $table->text('task_description'); 

            $table->timestamps(); // Created_at and updated_at columns

            // Foreign key constraints
            // $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
