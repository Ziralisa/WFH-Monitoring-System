<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUserDetailsNullable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Personal Information
            $table->string('first_name', 40)->nullable()->change();
            $table->string('last_name', 40)->nullable()->change();
            $table->date('birthdate')->nullable()->change();
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->change();
            $table->string('location1', 100)->nullable()->change();
            $table->string('location2', 100)->nullable()->change();
            $table->string('suburb', 40)->nullable()->change();
            $table->string('state', 40)->nullable()->change();

            // Job Information
            $table->boolean('job_status')->nullable()->change();
            $table->string('position', 40)->nullable()->change();
            $table->string('work_email')->nullable()->change(); // Keep this line to make it nullable
            $table->string('work_phone', 20)->nullable()->change();

            // Emergency Contact
            $table->string('emergency_firstname', 40)->nullable()->change();
            $table->string('emergency_lastname', 40)->nullable()->change();
            $table->string('emergency_relation', 40)->nullable()->change();
            $table->string('emergency_phone', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverting to non-nullable fields
            $table->string('first_name', 40)->nullable(false)->change();
            $table->string('last_name', 40)->nullable(false)->change();
            $table->date('birthdate')->nullable(false)->change();
            $table->enum('gender', ['male', 'female', 'other'])->nullable(false)->change();
            $table->string('location1', 100)->nullable(false)->change();
            $table->string('location2', 100)->nullable(false)->change();
            $table->string('suburb', 40)->nullable(false)->change();
            $table->string('state', 40)->nullable(false)->change();

            // Job Information
            $table->boolean('job_status')->nullable(false)->change();
            $table->string('position', 40)->nullable(false)->change();
            $table->string('work_email')->nullable(false)->unique()->change();
            $table->string('work_phone', 20)->nullable(false)->change();

            // Emergency Contact
            $table->string('emergency_firstname', 40)->nullable(false)->change();
            $table->string('emergency_lastname', 40)->nullable(false)->change();
            $table->string('emergency_relation', 40)->nullable(false)->change();
            $table->string('emergency_phone', 20)->nullable(false)->change();
        });
    }
}
