<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sprint_task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('sprint_id');
            $table->unsignedBigInteger('task_id');
            $table->enum('task_status', ['to do', 'in progress', 'done', 'stuck'])->default('to do');
            $table->enum('task_priority', ['low', 'medium', 'high'])->default('medium');
            $table->unsignedBigInteger('task_assign')->nullable(); // ID of the assigned user
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('sprint_id')->references('id')->on('sprints')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('project_task')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sprint_task');
    }

};
