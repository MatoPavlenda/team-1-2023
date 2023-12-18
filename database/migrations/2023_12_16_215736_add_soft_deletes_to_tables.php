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
        Schema::table('company', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('company_employee', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('practice_offer', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('company_employee', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('practice_offer', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
