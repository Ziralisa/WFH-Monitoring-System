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
        Schema::table('user_locations', function (Blueprint $table) {
            $table->integer('total_points')->default(0);//->after('workinghourpoints'); // Adjust position as needed
        });
    }

    public function down()
    {
        Schema::table('user_locations', function (Blueprint $table) {
            $table->dropColumn('total_points');
        });
    }
};
