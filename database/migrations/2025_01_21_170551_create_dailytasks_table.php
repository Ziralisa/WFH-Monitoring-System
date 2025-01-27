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
    Schema::create('dailytasks', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable(); // For open tasks
        $table->foreignId('task_id')->nullable()->constrained('tasks')->onDelete('cascade'); // Optional reference to sprint tasks
        $table->boolean('status')->default(0); // 0 = not completed, 1 = done
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dailytasks');
    }
};
