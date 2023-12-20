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
            // Adding the foreign key to the 'users' table
            $table->unsignedBigInteger('ukf_employee_id')->nullable()->after('student_id');
            $table->foreign('ukf_employee_id')->references('id')->on('ukf_employee')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['ukf_employee_id']);
            // Remove the column
            $table->dropColumn('ukf_employee_id');
        });
    }
};
