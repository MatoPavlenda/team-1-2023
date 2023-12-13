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
        Schema::table('company_employee', function (Blueprint $table) {
            Schema::table('company_employee', function (Blueprint $table) {
                $table->string('email')->unique()->after('surname'); // Add email column
                $table->softDeletes(); // Add softDelete
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_employee', function (Blueprint $table) {
            Schema::table('company_employee', function (Blueprint $table) {
                $table->dropColumn('email'); // Remove email column
                $table->dropSoftDeletes(); // Remove softDeletes
            });
        });
    }
};
