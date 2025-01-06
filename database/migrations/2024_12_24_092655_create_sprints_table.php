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
        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->text('desc');
            $table->dateTime('startdate');
            $table->dateTime('enddate')->nullable();
            //$table->unsignedInteger('task_id');
            $table->timestamps();
            //$table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // Adjust task table name and key as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sprints');
    }
};
