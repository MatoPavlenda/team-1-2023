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
        Schema::table('agreement', function (Blueprint $table) {
            // Change the data type of 's_active' column to integer
            $table->integer('s_active')->change();

            // Change the data type of 't_url' column to text with a length of 300
            $table->text('t_url-', 300)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agreement', function (Blueprint $table) {
            // If you need to reverse the change to 's_active', you might need to drop and recreate the column
            $table->dropColumn('s_active');
            $table->string('s_active', 255);

            // If you need to reverse the change to 't_url', you might need to drop and recreate the column
            $table->dropColumn('t_url-');
            $table->string('t_url-', 255);
        });
    }
};
