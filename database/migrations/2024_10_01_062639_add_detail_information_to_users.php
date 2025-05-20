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
    Schema::table('users', function (Blueprint $table) {
        // Personal Information
        $table->string('first_name', 40);
        $table->string('last_name', 40);
        $table->date('birthdate')->nullable();
        $table->enum('gender', ['male', 'female', 'other']);
        $table->string('location1', 100);
        $table->string('location2', 100)->nullable();
        $table->string('suburb', 40);
        $table->string('state', 40);

        // Job Information
        $table->boolean('job_status')->nullable();
        $table->string('position', 40);
        $table->string('work_email')->unique()->nullable();
        $table->string('work_phone', 20)->nullable();

        // Emergency Contact
        $table->string('emergency_firstname', 40)->nullable();
        $table->string('emergency_lastname', 40)->nullable();
        $table->string('emergency_relation', 40)->nullable();
        $table->string('emergency_phone', 20)->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Personal Information
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('birthdate');
            $table->dropColumn('gender');
            $table->dropColumn('location1');
            $table->dropColumn('location2');
            $table->dropColumn('suburb');
            $table->dropColumn('state');

            // Job Information
            $table->dropColumn('job_status');
            $table->dropColumn('position');
            $table->dropColumn('work_email');
            $table->dropColumn('work_phone');

            // Emergency Contact
            $table->dropColumn('emergency_firstname');
            $table->dropColumn('emergency_lastname');
            $table->dropColumn('emergency_relation');
            $table->dropColumn('emergency_phone');
        });
    }
};
