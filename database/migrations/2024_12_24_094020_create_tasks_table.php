<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sprint_id')->constrained()->onDelete('cascade'); // Ensures sprint_id exists
            $table->string('name');
            $table->enum('task_status', ['To Do', 'In Progress', 'Done', 'Stuck']);
            $table->enum('task_priority', ['Low', 'Medium', 'High']);
            $table->string('task_assign')->nullable()->default(null);
            $table->text('task_description')->nullable();
            $table->timestamps();
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
